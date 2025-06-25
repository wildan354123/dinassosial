<nav class="sidebar">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container-fluid {
            display: flex;
            height: 100vh;
        }
        nav.sidebar {
            width: 200px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            padding-left: 15px;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
        }
        nav.sidebar h3 {
            display: flex;
            align-items: center;
            font-size: 15px;
            margin-bottom: 20px;
        }
        nav.sidebar .logo-img {
            width: 50px;
            height: auto;
            margin-right: 0px;
        }
        nav.sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            font-size: 13px;
        }
        nav.sidebar a:hover {
            background-color: #495057;
        }
        nav.sidebar i {
            margin-right: 10px;
        }
        .content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .logout-btn {
            font-size: 13px !important;
            width: 170px;
            margin-top: 10px;
        }
        nav.sidebar a.active {
            background-color: #007bff;
        }
    </style>

    <h3>
        <img src="{{ asset('images/logodinassosial.png') }}" alt="Logo Dinas Sosial" class="logo-img">
        Dinas Sosial <br> Banyuasin
    </h3>

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>

    <a href="{{ route('importdata') }}" class="{{ request()->routeIs('importdata') ? 'active' : '' }}">
        <i class="fas fa-upload"></i> Import Data
    </a>

    <a href="{{ route('tentukancluster') }}" class="{{ request()->routeIs('tentukancluster') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Tentukan Kluster
    </a>

    <a href="{{ route('hasilclustering') }}" class="{{ request()->routeIs('hasilclustering') ? 'active' : '' }}">
        <i class="fas fa-chart-pie"></i> Hasil Klasterisasi
    </a>

    <a href="{{ route('visualisasidata') }}" class="{{ request()->routeIs('visualisasidata') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Visualisasi Data
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger logout-btn">Logout</button>
    </form>
</nav>
