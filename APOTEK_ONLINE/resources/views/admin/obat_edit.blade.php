<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Obat - Admin</title>
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
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-light);
            color: var(--text-light);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .box {
            background: var(--card-light);
            color: var(--text-light);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 480px;
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode .box {
            background: var(--card-dark);
            color: var(--text-dark);
        }

        h2 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            margin-top: 10px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            background: #fff;
            color: #000;
        }

        .dark-mode input,
        .dark-mode select {
            background: #2a2a2a;
            color: #f5f5f5;
            border: 1px solid #444;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--primary);
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        ul {
            color: red;
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            .box {
                padding: 25px;
                margin: 20px;
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

<div class="box">
    <h2>Edit Obat: {{ $obat->nama }}</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Obat</label>
        <input type="text" name="nama" value="{{ $obat->nama }}" required>

        <label>Harga</label>
        <input type="number" name="harga" value="{{ $obat->harga }}" required>

        <label>Stok</label>
        <input type="number" name="stok" value="{{ $obat->stok }}" required>

        <label>Kategori</label>
        <select name="kategori_obat_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id }}" {{ $obat->kategori_obat_id == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update</button>
    </form>

    <a class="back-link" href="{{ route('obat.index') }}">← Kembali ke Daftar Obat</a>
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
