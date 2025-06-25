<?php

namespace App\Jobs;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourImportClass; // Ganti dengan nama kelas import Anda
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    // Constructor untuk menerima file yang diimpor
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        // Logika untuk memproses file Excel
        Excel::import(new YourImportClass, $this->file);
    }
}