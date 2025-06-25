<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunPythonScript extends Command
{
    // Nama perintah artisan
    protected $signature = 'python:run {jumlahKluster=3}';

    // Deskripsi perintah
    protected $description = 'Menjalankan skrip K-Means Python untuk klasterisasi';

    public function __construct()
    {
        parent::__construct();
    }

    // Menjalankan perintah artisan
    public function handle()
    {
        // Ambil parameter jumlah kluster yang diteruskan melalui perintah artisan
        $jumlahKluster = $this->argument('jumlahKluster');

        // Tentukan path ke skrip Python
        $scriptPath = base_path('python/kmeans_cluster.py');

        // Jalankan perintah Python menggunakan Laravel Process
        $process = new \Symfony\Component\Process\Process(['python', $scriptPath, $jumlahKluster]);
        $process->run();

        // Cek apakah perintah berhasil dijalankan
        if ($process->successful()) {
            $this->info('Skrip Python berhasil dijalankan.');
            $this->info('Output: ' . $process->getOutput());
        } else {
            $this->error('Gagal menjalankan skrip Python.');
            $this->error('Error: ' . $process->getErrorOutput());
        }
    }
}
