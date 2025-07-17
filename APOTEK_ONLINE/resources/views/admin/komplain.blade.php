<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Komplain Pengguna - Admin</title>
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
      --bg-light: #eef6ff;
      --bg-dark: #121212;
      --card-light: #fff;
      --card-dark: #1e1e1e;
      --text-light: #333;
      --text-dark: #f5f5f5;
      --primary: #007bff;
      --komentar-bg: #ffffff;
      --balasan-bg: #e6f3ff;
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
      max-width: 800px;
      margin: auto;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: var(--primary);
      margin-bottom: 20px;
    }

    .back-link {
      margin-bottom: 20px;
    }

    a {
      color: var(--primary);
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .komplain-card {
      background: var(--komentar-bg);
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 24px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .dark-mode .komplain-card {
      background: #1f2e4d;
    }

    .komplain-header {
      font-weight: bold;
      color: var(--primary);
    }

    .komplain-body {
      margin-top: 8px;
      margin-bottom: 10px;
    }

    .komplain-date {
      font-size: 13px;
      color: #666;
    }

    .dark-mode .komplain-date {
      color: #aaa;
    }

    .balasan-box {
      background: var(--balasan-bg);
      padding: 12px;
      border-left: 4px solid var(--primary);
      border-radius: 10px;
      margin-top: 12px;
    }

    .dark-mode .balasan-box {
      background: #283b5f;
    }

    .balasan-form {
      display: none;
      margin-top: 12px;
    }

    .balasan-form textarea {
      width: 97%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      resize: vertical;
      font-size: 14px;
      margin-bottom: 8px;
    }

    .dark-mode .balasan-form textarea {
      background-color: #1e1e1e;
      color: #f5f5f5;
      border-color: #444;
    }

    button {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }

    button:hover {
      background-color: #005bb5;
    }

    .btn-toggle {
      margin-top: 8px;
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
  <h2>Komplain Pengguna</h2>

  <div class="back-link">
    <a href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
  </div>

  @if ($komplains->isEmpty())
    <p>Tidak ada komplain yang masuk saat ini.</p>
  @else
    @foreach ($komplains as $komplain)
      <div class="komplain-card">
        <div class="komplain-header">{{ $komplain->user->name }}</div>
        <div class="komplain-body">{{ $komplain->isi }}</div>
        <div class="komplain-date">Dikirim pada {{ \Carbon\Carbon::parse($komplain->created_at)->format('d M Y') }}</div>

        @if ($komplain->balasan)
          <div class="balasan-box">
            <strong>Balasan Admin:</strong><br>
            {{ $komplain->balasan->isi }}
          </div>
        @else
          <button class="btn-toggle" onclick="toggleForm({{ $komplain->id }})">Balas</button>

          <form action="{{ route('admin.balas_komplain', $komplain->id) }}" method="POST" class="balasan-form" id="form-{{ $komplain->id }}">
            @csrf
            <textarea name="isi" rows="2" placeholder="Tulis balasan admin..." required></textarea>
            <button type="submit">Kirim Balasan</button>
          </form>
        @endif
      </div>
    @endforeach
  @endif
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

  function toggleForm(id) {
    const form = document.getElementById(`form-${id}`);
    if (form.style.display === 'block') {
      form.style.display = 'none';
    } else {
      form.style.display = 'block';
    }
  }
</script>

</body>
</html>
