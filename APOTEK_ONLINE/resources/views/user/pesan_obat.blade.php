<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Obat - {{ $obat->nama }}</title>

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
            --danger: #d33;
            --border-radius: 8px;
            --transition: 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            justify-content:flex-start;
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
            font-size: 2rem;
            font-weight: 600;
        }

        nav a {
            color: var(--primary);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 1.1rem;
            transition: text-decoration 0.3s;
        }

        nav a:hover {
            text-decoration: underline;
        }

        form {
            background: var(--card-light);
            padding: 25px;
            border-radius: var(--border-radius);
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: background 0.3s;
            margin-top: 20px;
        }

        .dark-mode form {
            background: var(--card-dark);
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
        }

        input[type="number"],
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border-radius: var(--border-radius);
            border: 1px solid #ccc;
            margin-top: 5px;
            font-size: 14px;
            background: #fff;
            color: var(--text-light);
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .dark-mode input,
        .dark-mode textarea {
            background: #2a2a2a;
            color: #f5f5f5;
            border-color: #555;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        button {
            margin-top: 20px;
            padding: 12px 25px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: var(--hover);
            transform: scale(1.05);
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
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

        @media (max-width: 600px) {
            form {
                padding: 15px;
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

<h2>Pesan Obat: {{ $obat->nama }}</h2>

<nav>
    <a href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a>
    <a href="{{ route('user.daftar_obat') }}">← Kembali ke Daftar Obat</a>
</nav>

<hr><br>

@if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('user.simpan_pesanan', $obat->id) }}" method="POST">
    @csrf

    <p><strong>Harga Satuan:</strong> Rp{{ number_format($obat->harga) }}</p>
    <p><strong>Stok Tersedia:</strong> {{ $obat->stok }}</p>

    <label for="jumlah">Jumlah:</label>
    <input type="number" name="jumlah" id="jumlah" min="1" max="{{ $obat->stok }}" required>

    <label for="alamat_pengiriman">Alamat Pengiriman:</label>
    <input type="text" name="alamat_pengiriman" id="alamat_pengiriman" value="{{ old('alamat_pengiriman', $user->alamat ?? '') }}" required>

    <label for="catatan">Catatan (Opsional):</label>
    <textarea name="catatan" id="catatan" placeholder="Silahkan sampaikan pesan kepada petugas Apotek">{{ old('catatan') }}</textarea>

    <button type="submit">Kirim Pesanan</button>
</form>

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
