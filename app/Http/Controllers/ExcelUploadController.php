<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ImportExcelJob;
use App\Models\Dtks;

class ExcelUploadController extends Controller
{
    public function index()
    {
        return view('importdata');
    }

    public function import(Request $request)
    {
        set_time_limit(0);

        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:20480',
        ]);

        try {
            // Simpan file
            $filePath = $request->file('file')->store('imports');

            // Dispatch job (kalau tetap ingin ada proses background)
            ImportExcelJob::dispatch($filePath);

            // Baca langsung isi file
            $data = Excel::toArray([], $request->file('file'));
            $rows = $data[0];

            if (count($rows) < 2) {
                return back()->with('error', 'File tidak memiliki data baris.');
            }

            // Kosongkan tabel dtks sebelum insert
            Dtks::truncate();

            // Masukkan data mulai dari baris kedua (baris pertama = header)
            foreach ($rows as $i => $row) {
                if ($i === 0) continue; // Lewati header

                Dtks::create([
                    'nama_kepala_keluarga' => $row[0] ?? null,
                    'pekerjaan'            => $row[2] ?? null,
                    'kepemilikan_rumah'    => $row[3] ?? null,
                    'jenis_atap'           => $row[4] ?? null,
                    'jenis_dinding'        => $row[5] ?? null,
                    'jenis_lantai'         => $row[6] ?? null,
                    'sumber_penerangan'    => $row[7] ?? null,
                    'daya_listrik'         => $row[8] ?? null,
                    'bahan_bakar'          => $row[9] ?? null,
                    'sumber_air'           => $row[10] ?? null,
                    'fasilitas_bab'        => $row[11] ?? null,
                ]);
            }

            // Hitung informasi untuk ditampilkan
            $totalRows = count($rows) - 1;
            $totalColumns = count($rows[0]);
            $emptyCells = 0;
            foreach ($rows as $row) {
                foreach ($row as $cell) {
                    if (is_null($cell) || $cell === '') {
                        $emptyCells++;
                    }
                }
            }

            $sampleRows = array_slice($rows, 0, 11); // header + 10 data

            return view('importdata', [
                'rows' => $sampleRows,
                'totalRows' => $totalRows,
                'totalColumns' => $totalColumns,
                'emptyCells' => $emptyCells,
            ])->with('success', 'File berhasil diunggah dan data disimpan ke database.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
        }
    }
    public function reset(Request $request)
    {
        Dtks::truncate(); // Menghapus seluruh data

        return back()->with('success', 'Seluruh data DTKS berhasil dihapus.');
    }
}
