<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Obat - Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
        (function () {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <style>
        :root {
            --bg-light: #f4f8fb;
            --bg-dark: #121212;
            --card-light: #ffffff;
            --card-dark: #1e1e1e;
            --text-light: #333;
            --text-dark: #f5f5f5;
            --primary: #007bff;
            --hover: #0056b3;
            --input-bg-light: #fff;
            --input-bg-dark: #333;
            --border-radius: 8px;
            --transition: 0.3s ease;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-light);
            color: var(--text-light);
            padding: 20px;
            transition: background 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .dark-mode body {
            background: var(--bg-dark);
            color: var(--text-dark);
        }

        h2 {
            color: var(--primary);
            margin-bottom: 10px;
        }

        a.back-link {
            color: var(--primary);
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }

        a.back-link:hover {
            text-decoration: underline;
        }

        .toggle-switch-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1001;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 26px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        form.filter-form {
            margin-bottom: 20px;
        }

        select {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: var(--input-bg-light);
            color: var(--text-light);
            transition: 0.3s;
        }

        .dark-mode select {
            background: var(--input-bg-dark);
            color: var(--text-dark);
            border-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-light);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
            transition: background 0.3s;
        }

        .dark-mode table {
            background: var(--card-dark);
        }

        th {
            background: var(--primary);
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .dark-mode td {
            border-bottom: 1px solid #444;
        }

        tr:hover {
            background: #f1f9ff;
        }

        .dark-mode tr:hover {
            background: #1a1a1a;
        }

        .btn-pesan {
            background: var(--primary);
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-pesan:hover {
            background: var(--hover);
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                background: var(--card-light);
            }

            .dark-mode tr {
                background: var(--card-dark);
                border-color: #333;
            }

            td {
                padding: 8px 10px;
                border: none;
                position: relative;
                padding-left: 50%;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                top: 8px;
                font-weight: bold;
                color: var(--primary);
            }
        }
    </style>
</head>
<body>

<div class="toggle-switch-container">
    <label class="switch">
        <input type="checkbox" id="toggleSwitch">
        <span class="slider"></span>
    </label>
</div>

<h2>Daftar Obat</h2>
<a href="{{ route('user.dashboard') }}" class="back-link">← Kembali ke Dashboard</a>

<form method="GET" action="{{ route('user.daftar_obat') }}" class="filter-form">
    <label for="kategori">Filter Kategori:</label>
    <select name="kategori" id="kategori" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($kategoriList as $kategori)
            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</form>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($obats as $obat)
        <tr>
            <td data-label="Nama">{{ $obat->nama }}</td>
            <td data-label="Kategori">{{ $obat->kategori->nama ?? '-' }}</td>
            <td data-label="Stok">{{ $obat->stok }}</td>
            <td data-label="Harga">Rp{{ number_format($obat->harga) }}</td>
            <td data-label="Aksi">
                <a href="{{ route('user.form_pesan_obat', $obat->id) }}" class="btn-pesan">Pesan Obat Ini</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    const toggle = document.getElementById('toggleSwitch');
    const html = document.documentElement;

    toggle.addEventListener('change', () => {
        html.classList.toggle('dark-mode');
        localStorage.setItem('theme', html.classList.contains('dark-mode') ? 'dark' : 'light');
    });

    window.onload = () => {
        toggle.checked = localStorage.getItem('theme') === 'dark';
    };
</script>

</body>
</html>
