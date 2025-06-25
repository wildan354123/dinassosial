<div class="container-fluid">
    <x-navbar></x-navbar> <!-- ini sidebar -->

    <div class="content" style="margin-left: 180px; padding: 20px;">
        <h1><strong>Dashboard</strong></h1>
        <hr style="border: 1px solid #ccc; margin-top: 20px; margin-bottom: 20px;">

        <!-- Tombol Navigasi -->
        <div class="nav-buttons" style="margin: 20px 0; text-align: left;">
            <button onclick="location.href='#fitur-utama'" class="nav-btn btn-blue">Data Mining</button>
            <button onclick="location.href='#informasi-terbaru'" class="nav-btn btn-green">K-Means Clustering</button>
            <button onclick="location.href='#hasil-kluster'" class="nav-btn btn-yellow">Cara Menggunakan Aplikasi</button>
        </div>

        <hr style="border: 1px solid #ccc; margin-top: 20px; margin-bottom: 20px;">

        <!-- Section Fitur Utama -->
        <section id="fitur-utama">
            <h4><strong>Data Mining</strong></h4>
            <p style="text-align: justify;">
                Data mining adalah proses menganalisis sejumlah besar data untuk menemukan pola, hubungan, atau informasi tersembunyi yang bermanfaat dalam pengambilan keputusan. Dalam konteks data sosial, data mining dapat digunakan untuk memahami perilaku masyarakat, mengidentifikasi kelompok rentan, atau memetakan distribusi sosial ekonomi suatu wilayah.
            </p>

            <img src="{{ asset('images/datamining.png') }}" alt="data mining" class="datamining-img">
            <p>Berikut adalah proses dalam data mining:</p>
            <ul>
                <li><i class="fas fa-database"></i> <strong>Pengumpulan Data:</strong> Data dikumpulkan dari berbagai sumber, seperti sensus penduduk, survei sosial, atau data administrasi wilayah. Kualitas dan kelengkapan data sangat menentukan hasil analisis.</li>
                <li><i class="fas fa-filter"></i> <strong>Pembersihan dan persiapan data:</strong> Data yang telah dikumpulkan sering kali mengandung kesalahan, duplikat, atau nilai kosong. Proses ini bertujuan memastikan data yang akan dianalisis bersih dan konsisten.</li>
                <li><i class="fas fa-random"></i> <strong>Transformasi Data:</strong> Informasi mentah diubah menjadi format yang lebih sesuai untuk dianalisis. Contohnya, mengelompokkan usia ke dalam rentang, mengkodekan variabel kategorikal menjadi numerik, atau melakukan normalisasi.</li>
                <li><i class="fas fa-chart-line"></i> <strong>Pemodelan dan Analisis:</strong> Di sinilah algoritma data mining diterapkan. Metode seperti klasifikasi, asosiasi, prediksi, atau klasterisasi digunakan untuk menemukan pola dalam data.</li>
                <li><i class="fas fa-check-circle"></i> <strong>Evaluasi dan Interpretasi:</strong> Hasil analisis dievaluasi untuk mengukur keakuratannya dan ditafsirkan agar bisa dijadikan dasar dalam pengambilan keputusan, perencanaan, atau kebijakan.</li>
                <li><i class="fas fa-chart-bar"></i> <strong>Visualisasi dan Pelaporan:</strong> Pola dan informasi yang ditemukan disajikan dalam bentuk grafik, tabel, atau peta, sehingga mudah dipahami oleh pemangku kepentingan atau masyarakat umum.</li>
            </ul>
        </section>

        <hr class="section-separator">

        <!-- Section Informasi Terbaru -->
        <section id="informasi-terbaru">
            <h4><strong>K-Means Clustering</strong></h4>
            <p style="text-align: justify;">
                K-Means Clustering adalah algoritma pembelajaran tanpa pengawasan (unsupervised learning) yang digunakan untuk mengelompokkan data ke dalam beberapa kelompok berdasarkan kemiripan atau kedekatannya. Dalam teknik ini, data dibagi menjadi <strong>k</strong> kelompok yang berbeda, di mana setiap kelompok disebut <strong>cluster</strong>. Setiap data dalam kelompok tersebut lebih mirip satu sama lain dibandingkan dengan data di kelompok lain.
            </p>
            <img src="{{ asset('images/kmeans.jpg') }}" alt="kmeansclustering" class="datamining-img">
            <ul>
            <p><strong>Proses K-Means Clustering</strong></p>
            <p><strong>1. Inisialisasi:</strong> Pilih jumlah <strong>k</strong> (jumlah cluster) yang diinginkan dan tentukan titik pusat awal (centroids) secara acak.</p>
            <p><strong>2. Penugasan Cluster:</strong> Setiap data dihitung jaraknya ke setiap titik pusat. Data akan dipetakan ke cluster dengan jarak terdekat.</p>
            <p><strong>3. Perhitungan Centroid Baru:</strong> Setelah semua data dipetakan ke cluster, centroid baru dihitung dengan mengambil rata-rata dari semua titik data dalam cluster tersebut.</p>
            <p><strong>4. Pengulangan:</strong> Proses penugasan dan perhitungan centroid diulang hingga posisi centroid tidak berubah secara signifikan antara iterasi.</p>
            <p><strong>5. Penghentian:</strong> Proses berhenti ketika tidak ada perubahan lagi pada penugasan data atau centroid. K-Means clustering menghasilkan pembagian data yang stabil.</p>
            </ul>
        </section>

        <hr class="section-separator">

        <!-- Section Hasil Kluster -->
        <section id="hasil-kluster">
            <h4><strong>Cara Menggunakan Aplikasi</strong></h4>
            <ul>
            <p><strong>1. Pembersihan Data:</strong> Data dibersihkan terlebihdahulu sebelum digunakan, seperti melengkapi data yang hilang, menghapus data duplikat dan memperbaiki format sesuai nilai pada atribut.</p>
            <p><strong>2. Transformasi Data:</strong> Data yang kategorikal diubah menjadi data numerik agar bisa diproses algoritma k-means, seperti pekerjaan, kepemilikan rumah dan lainnya.</p>
            <p><strong>3. Import Data:</strong> Setelah data disiapkan barulah data diimportn ke sistem agar dapat diproses.</p>
            <p><strong>4. Tentukan Kluster:</strong> Ini adalah pemilihan kluster sekaligus proses klasterisasi.</p>
            <p><strong>5. Lihat hasil dan visualisasi:</strong> Hasil dapat dilihat pada halaman Hasil Klusterisasi. Untuk melihat visualisasi dari data dapat dilihat di halaman visualisasi data.</p>
            </ul>
        </section>

        <hr class="section-separator">
    </div>
</div>

<!-- CSS (Dapat Ditambahkan dalam Tag <style> atau di File Terpisah) -->
<style>
    /* Styles for the buttons */
    .nav-btn {
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        margin-right: 10px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
        opacity: 0.8;
    }

    .btn-blue {
        background-color: #007BFF;
        color: white;
    }

    .btn-green {
        background-color: #28A745;
        color: white;
    }
    .btn-yellow {
        background-color: #FFC107;
        color: white;
    }

    /* Style for each section separator */
    .section-separator {
        border: 1px solid #ccc;
        margin-top: 40px;
        margin-bottom: 20px;
    }

    /* List and text styling */
    ul {
        list-style-type: disc;
        margin-left: 20px;
        font-size: 20px;
    }

    ul li {
        margin-bottom: 10px;
    }

    /* Section Headings */
    h4 {
        font-size: 24px;
        color: #333;
        font-weight: bold;
        margin-bottom: 15px;
    }

    /* Section Content */
    section {
        margin-top: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Text Alignment */
    p, ul {
        text-align: justify;
        font-size: 16px;  /* Set uniform font size */
    }

    /* For large screen */
    @media (min-width: 768px) {
        .container {
            max-width: 85%;
        }
    }

    /* Icon Styling */
    ul li i {
        margin-right: 10px;
        color: #007BFF; /* Set icon color */
    }
    .datamining-img {
        width: 800px;
        height: auto;
        margin-left : 0px;
        margin-bottom : 10px;
        display: block;
    }
</style>
