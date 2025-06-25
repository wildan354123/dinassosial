<?php

namespace App\Exports;

use App\Models\Dtks;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DtksExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        $data = Dtks::whereNotNull('cluster_id')->get();

        // Hitung rata-rata tiap cluster
        $cluster_averages = [];
        foreach ($data->groupBy('cluster_id') as $cluster_id => $items) {
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

        // Hitung skor dan tentukan ranking prioritas
        $cluster_scores = [];
        foreach ($cluster_averages as $cluster_id => $averages) {
            $cluster_scores[$cluster_id] = array_sum($averages) / count($averages);
        }

        asort($cluster_scores);
        $cluster_ranks = [];
        $rank = 1;
        foreach (array_keys($cluster_scores) as $cluster_id) {
            $cluster_ranks[$cluster_id] = $rank++;
        }

        // Tambahkan label "Prioritas x"
        return $data->map(function ($item) use ($cluster_ranks) {
            $prioritas = $cluster_ranks[$item->cluster_id] ?? null;
            return [
                'nama_kepala_keluarga' => $item->nama_kepala_keluarga,
                'pekerjaan' => $item->pekerjaan,
                'kepemilikan_rumah' => $item->kepemilikan_rumah,
                'jenis_atap' => $item->jenis_atap,
                'jenis_dinding' => $item->jenis_dinding,
                'jenis_lantai' => $item->jenis_lantai,
                'sumber_penerangan' => $item->sumber_penerangan,
                'daya_listrik' => $item->daya_listrik,
                'bahan_bakar' => $item->bahan_bakar,
                'sumber_air' => $item->sumber_air,
                'fasilitas_bab' => $item->fasilitas_bab,
                'cluster_id' => $item->cluster_id,
                'prioritas' => $prioritas ? 'Prioritas ' . $prioritas : null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama KK',
            'Pekerjaan',
            'Kepemilikan Rumah',
            'Jenis Atap',
            'Jenis Dinding',
            'Jenis Lantai',
            'Sumber Penerangan',
            'Daya Listrik',
            'Bahan Bakar',
            'Sumber Air',
            'Fasilitas BAB',
            'Cluster',
            'Prioritas',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 15,
            'M' => 20, // Kolom Prioritas
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function title(): string
    {
        return 'Hasil Klasterisasi';
    }
}
