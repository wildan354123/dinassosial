<div class="container-fluid">
    <x-navbar></x-navbar>

    <div class="content" style="margin-left: 180px; padding: 40px;">
        <div class="card shadow p-4" style="max-width: 600px; margin: auto; border-radius: 1rem;">
            <h4 class="text-center mb-4">🔍 Tentukan Kluster</h4>

            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert error --}}
            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form klustering --}}
            <form action="{{ route('kluster.proses') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jumlah_kluster" class="form-label">Jumlah Kluster (K):</label>
                    <input type="number" name="jumlah_kluster" id="jumlah_kluster"
                           class="form-control" placeholder="Masukkan jumlah kluster yang diinginkan (2 - 10)" min="2" max="10" required>
                </div>

                <div class="text-muted mb-3 text-center">
                    Proses klasterisasi menggunakan algoritma <strong>K-Means</strong><br>
                    <small>Dengan maksimal iterasi: <strong>10</strong></small>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-cogs"></i> Proses Klasterisasi
                </button>
            </form>
        </div>
    </div>
</div>
