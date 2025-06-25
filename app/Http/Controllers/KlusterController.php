<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dtks;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class KlusterController extends Controller
{
    /**
     * Menampilkan form input jumlah kluster
     */
    public function index()
    {
        $total = Dtks::count();  // Menggunakan model Dtks

        if ($total === 0) {
            return redirect()->route('importdata')->with('error', 'Data DTKS kosong. Silakan upload data terlebih dahulu.');
        }

        return view('tentukancluster');
    }

    /**
     * Proses klasterisasi menggunakan Python K-Means
     */
    public function proses(Request $request)
    {
        $request->validate([
            'jumlah_kluster' => 'required|integer|min:2|max:10',
        ]);

        $jumlahKluster = $request->input('jumlah_kluster');
        
        // 1️⃣ Ekspor data ke CSV untuk Python
        $dtks = Dtks::all([  // Menggunakan model Dtks
            'id',
            'pekerjaan',
            'kepemilikan_rumah',
            'jenis_atap',
            'jenis_dinding',
            'jenis_lantai',
            'sumber_penerangan',
            'daya_listrik',
            'bahan_bakar',
            'sumber_air',
            'fasilitas_bab',
            'cluster_id'
        ]);
        
        $csvPath = storage_path('app/clustering/dtks_input.csv');
        
        // Pastikan direktori ada
        if (!File::exists(dirname($csvPath))) {
            File::makeDirectory(dirname($csvPath), 0777, true);
        }

        $csv = fopen($csvPath, 'w');
        
        // Tulis header kolom CSV
        fputcsv($csv, [
            'id', 
            'pekerjaan', 
            'kepemilikan_rumah', 
            'jenis_atap', 
            'jenis_dinding', 
            'jenis_lantai', 
            'sumber_penerangan', 
            'daya_listrik', 
            'bahan_bakar', 
            'sumber_air', 
            'fasilitas_bab', 
            'cluster_id'
        ]);

        // Masukkan data ke CSV
        foreach ($dtks as $row) {
            fputcsv($csv, [
                $row->id,
                $row->pekerjaan,
                $row->kepemilikan_rumah,
                $row->jenis_atap,
                $row->jenis_dinding,
                $row->jenis_lantai,
                $row->sumber_penerangan,
                $row->daya_listrik,
                $row->bahan_bakar,
                $row->sumber_air,
                $row->fasilitas_bab,
                $row->cluster_id,
            ]);
        }

        fclose($csv);

        // 2️⃣ Jalankan script Python menggunakan Symfony Process
        $scriptPath = base_path('python/kmeans_cluster.py');
        $process = new Process(['python', $scriptPath, $jumlahKluster]);

        // Menjalankan proses dan menangani error jika gagal
        try {
            $process->mustRun();
            Log::info("Skrip Python berhasil dijalankan: " . $process->getOutput());
        } catch (ProcessFailedException $exception) {
            Log::error("Gagal menjalankan skrip Python: " . $exception->getMessage());
            return redirect()->route('tentukancluster')->with('error', 'Gagal menjalankan skrip klasterisasi Python.');
        }

        // 3️⃣ Ambil hasil klasterisasi dari output CSV
        $outputPath = storage_path('app/clustering/dtks_output.csv');

        if (!file_exists($outputPath)) {
            return redirect()->route('tentukancluster')->with('error', 'Gagal memproses klasterisasi. File output tidak ditemukan.');
        }

        // Baca file CSV untuk update cluster_id di database
        $handle = fopen($outputPath, 'r');
        fgetcsv($handle); // lewati header

        // Debugging: Cek isi file CSV
        while (($row = fgetcsv($handle)) !== false) {
            Log::info('Membaca data output CSV:', ['id' => $row[0], 'cluster_id' => $row[1]]);
            
            // Update database dengan cluster_id dari CSV
            $updated = Dtks::where('id', $row[0])->update([  // Menggunakan model Dtks
                'cluster_id' => 'Kluster ' . $row[1]
            ]);

            // Debugging: Cek apakah update berhasil
            if ($updated) {
                Log::info('Database updated:', ['id' => $row[0], 'cluster_id' => 'Kluster ' . $row[1]]);
            } else {
                Log::error('Database update failed:', ['id' => $row[0]]);
            }
        }

        fclose($handle);

        return redirect()->route('hasilclustering')->with('success', 'Klasterisasi K-Means berhasil diproses.');
    }
}
