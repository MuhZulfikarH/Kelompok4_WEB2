<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Apotek Online</title>
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
      --bg-light: linear-gradient(135deg, #007bff, #00c6ff);
      --bg-dark: #121212;
      --box-light: #fff;
      --box-dark: #1e1e1e;
      --text-light: #333;
      --text-dark: #f5f5f5;
      --primary: #007bff;
    }

    * { box-sizing: border-box; }

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
      transition: background 0.4s, color 0.4s;
      padding: 0 10px;
    }

    .dark-mode body {
      background: var(--bg-dark);
      color: var(--text-dark);
    }

    .toggle-switch-container {
      position: absolute;
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
      background-color: #007bff;
    }

    input:checked + .slider:before {
      transform: translateX(24px);
    }

    .box {
      background: var(--box-light);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px;
      animation: fadeIn 0.6s ease;
      transition: background 0.4s, color 0.4s;
      position: relative;
      text-align: center;
    }

    .dark-mode .box {
      background: var(--box-dark);
      color: var(--text-dark);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo {
      display: block;
      margin: 0 auto 20px auto;
      width: 80px;
      height: 80px;
      object-fit: contain;
    }

    h2 {
      text-align: center;
      color: var(--primary);
      margin-bottom: 25px;
    }

    label {
      font-weight: 600;
      margin-top: 10px;
      display: block;
      text-align: left;
    }

    input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 5px;
    }

    /* Penyesuaian untuk dark mode */
    .dark-mode input {
      background-color: #2b2b2b; /* Latar belakang gelap untuk input */
      color: #f5f5f5; /* Teks putih pada input */
      border-color: #555; /* Warna border yang lebih gelap */
    }

    /* Penyesuaian untuk placeholder di input */
    .dark-mode input::placeholder {
      color: #bbb; /* Warna placeholder lebih terang di dark mode */
    }

    button {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      background: var(--primary);
      border: none;
      color: white;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    /* Penyesuaian untuk button di dark mode */
    .dark-mode button {
      background-color: #003366; /* Background yang lebih gelap di dark mode */
      color: #f5f5f5; /* Warna teks putih */
    }

    .message {
      text-align: center;
      margin-top: 15px;
    }

    .message a {
      color: var(--primary);
      text-decoration: none;
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

<div class="box">
  <!-- Logo di tengah atas -->
  <img src="{{ asset('img/Logo.png') }}" alt="Logo Apotek" class="logo">

  <h2>Login Akun</h2>

  @if(session('error'))
    <div class="error">{{ session('error') }}</div>
  @endif

  @if(session('success'))
    <div class="success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="error">
      <ul style="padding-left: 20px; text-align: left;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <label>Email</label>
    <input type="email" name="email" required value="{{ old('email') }}" placeholder="Silahkan masukkan akun email Anda">

    <label>Password</label>
    <input type="password" name="password" required placeholder="Silahkan masukkan password akun Anda">

    <button type="submit">Login</button>
  </form>

  <div class="message">
    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
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
