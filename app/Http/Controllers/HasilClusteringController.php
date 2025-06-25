<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dtks;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DtksExport;  // Pastikan Anda telah membuat Export class yang sesuai

class HasilClusteringController extends Controller
{
    // Menampilkan hasil klasterisasi dalam bentuk tabel
    public function index()
    {
        // Ambil semua data yang sudah memiliki cluster_id
        $hasil = Dtks::whereNotNull('cluster_id')->get();

        // Periksa apakah hasil kosong
        if ($hasil->isEmpty()) {
            return redirect()->route('tentukancluster')->with('error', 'Belum ada hasil klasterisasi.');
        }

        // Kirim ke view dengan data hasil klasterisasi
        return view('hasilclustering', compact('hasil'));
    }

    // Menampilkan visualisasi data berdasarkan hasil klasterisasi
    public function visualisasi()
    {
        // Ambil semua data yang sudah memiliki cluster_id untuk visualisasi
        $hasil = Dtks::whereNotNull('cluster_id')->get();

        // Periksa apakah hasil kosong
        if ($hasil->isEmpty()) {
            return redirect()->route('tentukancluster')->with('error', 'Belum ada hasil klasterisasi.');
        }

        // Hitung skor berbobot (prioritas) setiap klaster
        $cluster_averages = [];
        foreach ($hasil->groupBy('cluster_id') as $cluster_id => $items) {
            $cluster_averages[$cluster_id] = [
                'pekerjaan' => $items->avg('pekerjaan'),
                'kepemilikan_rumah' => $items->avg('kepemilikan_rumah'),
                'jenis_atap' => $items->avg('jenis_atap'),
                'jenis_dinding' => $items->avg('jenis_dinding'),
                'jenis_lantai' => $items->avg('jenis_lantai'),
                'sumber_penerangan' => $items->avg('sumber_penerangan'),
                'daya_listrik' => $items->avg('daya_listrik'),
                'bahan_bakar' => $items->avg('bahan_bakar'),
                'sumber_air' => $items->avg('sumber_air'),
                'fasilitas_bab' => $items->avg('fasilitas_bab'),
            ];
        }

        // Hitung prioritas (skor berbobot) untuk setiap klaster
        $cluster_priorities = [];
        foreach ($cluster_averages as $cluster_id => $averages) {
            $total_avg = array_sum($averages) / count($averages); // Rata-rata total
            $cluster_priorities[$cluster_id] = $total_avg;
        }

        // Urutkan klaster berdasarkan skor prioritas (dari yang terkecil ke terbesar)
        asort($cluster_priorities);

        // Kirim data ke view visualisasi dengan data hasil klasterisasi dan prioritas
        return view('visualisasidata', compact('cluster_averages', 'cluster_priorities', 'hasil'));
    }

    // Mengekspor hasil klasterisasi ke file Excel
    public function export()
    {
        // Menggunakan Laravel Excel untuk mengekspor data ke Excel
        return Excel::download(new DtksExport, 'hasil_klasterisasi.xlsx');
    }
}
