<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk - Admin</title>
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
            --bg-light: #f2f7ff;
            --bg-dark: #121212;
            --card-light: #fff;
            --card-dark: #1e1e1e;
            --text-light: #333;
            --text-dark: #f5f5f5;
            --primary: #007bff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-light);
            color: var(--text-light);
            padding: 40px 20px;
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode body {
            background: var(--bg-dark);
            color: var(--text-dark);
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
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        .container {
            max-width: 1100px;
            background: var(--card-light);
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode .container {
            background: var(--card-dark);
            color: var(--text-dark);
        }

        h2 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 25px;
        }

        a {
            text-decoration: none;
            color: var(--primary);
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: var(--primary);
            color: white;
        }

        td {
            background: #f9fbff;
        }

        .dark-mode td {
            background: #2c2c2c;
        }

        .action-link {
            background: var(--primary);
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
            font-size: 14px;
        }

        .action-link:hover {
            background: #0056b3;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-diproses {
            color: red;
            font-weight: bold;
        }

        .status-selesai {
            color: green;
            font-weight: bold;
        }

        .status-dibatalkan {
            color: gray;
            font-style: italic;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 13px;
                padding: 8px;
            }

            .action-link {
                padding: 5px 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<!-- Toggle Dark Mode -->
<div class="toggle-switch-container">
    <label class="switch">
        <input type="checkbox" id="toggleSwitch">
        <span class="slider"></span>
    </label>
</div>

<div class="container">
    <h2>Pesanan Masuk</h2>

    <div class="back-link">
        <a href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Alamat Pengiriman</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total Harga</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan as $p)
                @php
                    $total = $p->total_harga ?? $p->detailPesanan->sum(fn($item) => $item->jumlah * $item->harga);
                    $catatan = $p->detailPesanan->pluck('catatan')->filter()->implode(', ');
                @endphp
                <tr>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->alamat_pengiriman ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y H:i') }}</td>
                    <td>
                        @if($p->status === 'pending')
                            <span class="status-pending">Pending</span>
                        @elseif($p->status === 'diproses')
                            <span class="status-diproses">Diproses</span>
                        @elseif($p->status === 'dibatalkan')
                            <span class="status-dibatalkan">Dibatalkan</span>
                        @else
                            <span class="status-selesai">Selesai</span>
                        @endif
                    </td>
                    <td>Rp{{ number_format($total) }}</td>
                    <td>{{ $catatan ?: '-' }}</td>
                    <td>
                        @if($p->status === 'pending')
                            <a class="action-link" href="{{ route('pesanan.ubah_status', [$p->id, 'diproses']) }}">Proses</a>
                        @elseif($p->status === 'diproses')
                            <a class="action-link" href="{{ route('pesanan.ubah_status', [$p->id, 'selesai']) }}">Selesaikan</a>
                        @elseif($p->status === 'dibatalkan')
                            <span class="status-dibatalkan">Dibatalkan User</span>
                        @else
                            <span class="status-selesai">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

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
