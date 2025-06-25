<div class="container-fluid">
    <x-navbar></x-navbar>

    <div class="content" style="margin-left: 180px; padding: 40px;">
        <div class="container">
            <h4 class="mb-4">📊 Hasil Klasterisasi</h4>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($hasil->isEmpty())
                <div class="alert alert-warning">
                    Belum ada hasil klasterisasi. Silakan jalankan proses klasterisasi terlebih dahulu.
                </div>
            @else
                <!-- Tombol Ekspor Data -->
                <div class="mb-3">
                    <a href="{{ route('export.klasterisasi') }}" class="btn btn-success">Eksport Data</a>
                </div>

                <div style="overflow-x:auto; overflow-y:auto; max-height: 500px;">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 1; background-color: white;">
                            <tr>
                                <th>No</th>
                                <th>Nama KK</th>
                                <th>Pekerjaan</th>
                                <th>Kepemilikan Rumah</th>
                                <th>Jenis Atap</th>
                                <th>Jenis Dinding</th>
                                <th>Jenis Lantai</th>
                                <th>Sumber Penerangan</th>
                                <th>Daya Listrik</th>
                                <th>Bahan Bakar</th>
                                <th>Sumber Air</th>
                                <th>Fasilitas BAB</th>
                                <th>Cluster</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil->take(100) as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_kepala_keluarga ?? '-' }}</td>
                                    <td>{{ $item->pekerjaan ?? '-' }}</td>
                                    <td>{{ $item->kepemilikan_rumah ?? '-' }}</td>
                                    <td>{{ $item->jenis_atap ?? '-' }}</td>
                                    <td>{{ $item->jenis_dinding ?? '-' }}</td>
                                    <td>{{ $item->jenis_lantai ?? '-' }}</td>
                                    <td>{{ $item->sumber_penerangan ?? '-' }}</td>
                                    <td>{{ $item->daya_listrik ?? '-' }}</td>
                                    <td>{{ $item->bahan_bakar ?? '-' }}</td>
                                    <td>{{ $item->sumber_air ?? '-' }}</td>
                                    <td>{{ $item->fasilitas_bab ?? '-' }}</td>
                                    <td>{{ $item->cluster_id ?? 'Belum Diklaster' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Keterangan Karakteristik Klaster -->
                <div class="mt-4">
                    <h5 class="text-primary">Karakteristik Setiap Klaster</h5>
                    <p>Berikut adalah penjelasan berdasarkan data klaster dan tingkat prioritas :</p>

                    <!-- Hitung Rata-Rata Setiap Klaster untuk Semua Atribut -->
                    @php
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
                    @endphp

                    <!-- Mengurutkan klaster berdasarkan rata-rata nilai total dari semua atribut -->
                    @php
                        $cluster_priorities = [];
                        foreach ($cluster_averages as $cluster_id => $averages) {
                            $total_avg = array_sum($averages) / count($averages);
                            $cluster_priorities[$cluster_id] = $total_avg;
                        }
                        asort($cluster_priorities); 
                    @endphp

                    @php $priority_rank = 1; @endphp

                    @foreach($cluster_priorities as $cluster_id => $priority_score)
                        <div class="mb-4">
                            <h6 class="text-dark"><strong>{{ $cluster_id }}</strong></h6>
                            <p><strong>Jumlah Data:</strong> {{ count($hasil->where('cluster_id', $cluster_id)) }}</p>
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Atribut</th>
                                        <th>Rata-Rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td><strong>Pekerjaan</strong></td><td>{{ $cluster_averages[$cluster_id]['pekerjaan'] }}</td></tr>
                                    <tr><td><strong>Kepemilikan Rumah</strong></td><td>{{ $cluster_averages[$cluster_id]['kepemilikan_rumah'] }}</td></tr>
                                    <tr><td><strong>Jenis Atap</strong></td><td>{{ $cluster_averages[$cluster_id]['jenis_atap'] }}</td></tr>
                                    <tr><td><strong>Jenis Dinding</strong></td><td>{{ $cluster_averages[$cluster_id]['jenis_dinding'] }}</td></tr>
                                    <tr><td><strong>Jenis Lantai</strong></td><td>{{ $cluster_averages[$cluster_id]['jenis_lantai'] }}</td></tr>
                                    <tr><td><strong>Sumber Penerangan</strong></td><td>{{ $cluster_averages[$cluster_id]['sumber_penerangan'] }}</td></tr>
                                    <tr><td><strong>Daya Listrik</strong></td><td>{{ $cluster_averages[$cluster_id]['daya_listrik'] }}</td></tr>
                                    <tr><td><strong>Bahan Bakar</strong></td><td>{{ $cluster_averages[$cluster_id]['bahan_bakar'] }}</td></tr>
                                    <tr><td><strong>Sumber Air</strong></td><td>{{ $cluster_averages[$cluster_id]['sumber_air'] }}</td></tr>
                                    <tr><td><strong>Fasilitas BAB</strong></td><td>{{ $cluster_averages[$cluster_id]['fasilitas_bab'] }}</td></tr>
                                    <!-- Tambahan: baris total rata-rata -->
                                    <tr class="table-warning">
                                        <td><strong>Total Rata-Rata</strong></td>
                                        <td><strong>{{ number_format(array_sum($cluster_averages[$cluster_id]) / count($cluster_averages[$cluster_id]), 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p><strong class="text-danger">Tingkat Prioritas:</strong> 
                                <span class="badge bg-success">Prioritas {{ $priority_rank++ }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
