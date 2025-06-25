<style>
    .sidebar {
        width: 200px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: #495057;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 1000;
    }

    .main-container {
        margin-left: 200px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 40px 20px;
        min-height: 100vh;
        background: #f0f2f5;
    }

    .content-wrapper {
        width: 600px;
        padding: 20px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        max-height: 80vh;
        overflow-y: auto;
    }
</style>


<div class="sidebar">
    <x-navbar></x-navbar>
</div>

<div class="main-container">
    <div class="content-wrapper">
        <div class="glass-card p-3 mb-4">
        <h4 class="text-center mb-3">📥Import Data</h4>

            <!-- Form Upload -->
            <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih file</label>
                    <input type="file" name="file" class="form-control form-control-sm" accept=".xlsx,.csv" required>
                </div>
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-upload"></i> Import
                </button>
            </form>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="alert alert-success mt-3" role="alert">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <!-- Info Baris dan Kolom -->
            @if(isset($totalRows) && isset($totalColumns))
                <div class="alert alert-info mt-3">
                    <strong>📊 Baris:</strong> {{ $totalRows }}<br>
                    <strong>📈 Kolom:</strong> {{ $totalColumns }}
                </div>
            @endif

            <form action="{{ route('dtks.reset') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data DTKS?');">
                @csrf
                <button type="submit" class="btn btn-danger">
                🗑️ Hapus Semua Data DTKS
    </button>
</form>
        </div>

        <!-- Tabel Isi File -->
        @if(isset($rows) && count($rows) > 0)
            <div class="glass-card p-6">
                <div class="mb-2 fw-bold">📄 Sampel Data (10 Baris Pertama)</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                @foreach($rows[0] as $heading)
                                    <th>{{ $heading }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $index => $row)
                                @if($index > 0 && $index <= 10)
                                    <tr>
                                        @foreach($row as $cell)
                                            <td>{{ $cell }}</td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
