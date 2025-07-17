<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
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
            --card-light: #ffffff;
            --card-dark: #1e1e1e;
            --text-light: #333;
            --text-dark: #f5f5f5;
            --primary: #007bff;
            --hover: #0056b3;
            --table-row-light: #f9fbff;
            --table-row-dark: #1c1c1c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-light);
            color: var(--text-light);
            padding: 40px 20px;
            transition: background 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .dark-mode body {
            background: var(--bg-dark);
            color: var(--text-dark);
        }

        .container {
            max-width: 800px;
            background: var(--card-light);
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: background 0.3s;
        }

        .dark-mode .container {
            background: var(--card-dark);
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

        .info {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .status {
            font-weight: bold;
        }

        .status-pending {
            color: orange;
        }

        .status-diproses {
            color: red;
        }

        .status-selesai {
            color: #32cd32;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            background: var(--table-row-light);
        }

        .dark-mode td {
            background: var(--table-row-dark);
            border-color: #333;
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 13px;
                padding: 8px;
            }
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
    </style>
</head>
<body>

<div class="toggle-switch-container">
    <label class="switch">
        <input type="checkbox" id="toggleSwitch">
        <span class="slider"></span>
    </label>
</div>

<div class="container">
    <h2>Detail Pesanan</h2>

    <div class="back-link">
        <a href="{{ route('user.pesanan_saya') }}">← Kembali ke Pesanan Saya</a>
    </div>

    <div class="info">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d M Y') }}</p>
        @php
            $statusClass = match($pesanan->status) {
                'pending' => 'status-pending',
                'diproses' => 'status-diproses',
                'selesai' => 'status-selesai',
                default => ''
            };
        @endphp
        <p><strong>Status:</strong> <span class="status {{ $statusClass }}">{{ ucfirst($pesanan->status) }}</span></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->detailPesanan as $detail)
            <tr>
                <td>{{ $detail->obat->nama }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp{{ number_format($detail->harga) }}</td>
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
