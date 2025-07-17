<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Obat - Admin</title>
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
            max-width: 500px;
            background: var(--card-light);
            color: var(--text-light);
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: background 0.4s, color 0.4s;
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

        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border 0.3s ease;
            background: #fff;
            color: #000;
        }

        .dark-mode input,
        .dark-mode select {
            background: #2a2a2a;
            color: #f5f5f5;
            border: 1px solid #444;
        }

        input:focus,
        select:focus {
            border-color: var(--primary);
            outline: none;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: var(--primary);
            border: none;
            color: #fff;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-top: 10px;
            padding-left: 0;
        }

        .error li {
            margin-left: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
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

<div class="container">
    <h2>Tambah Obat Baru</h2>

    @if ($errors->any())
        <ul class="error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('obat.store') }}" method="POST">
        @csrf

        <label>Nama Obat:</label>
        <input type="text" name="nama" required>

        <label>Harga:</label>
        <input type="number" name="harga" required>

        <label>Stok:</label>
        <input type="number" name="stok" required>

        <label>Kategori:</label>
        <select name="kategori_obat_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>

        <button type="submit">Simpan</button>
    </form>

    <div class="back-link">
        <a href="{{ route('obat.index') }}">← Kembali ke Daftar Obat</a>
    </div>
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
