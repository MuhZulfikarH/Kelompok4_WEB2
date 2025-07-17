<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
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
      --bg-light: linear-gradient(to right, #007bff, #00c6ff);
      --bg-dark: #121212;
      --card-light: #fff;
      --card-dark: #1e1e1e;
      --text-light: #333;
      --text-dark: #f5f5f5;
      --primary: #007bff;
      --danger: #ff4d4f;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
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

    .top-right-controls {
      position: fixed;
      top: 20px;
      right: 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 12px;
      z-index: 1001;
    }

    .toggle-switch-container {
      display: inline-block;
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

    .profile {
      position: relative;
      background: linear-gradient(to right,   #9ab2ff, #f3f4f5);
      padding: 12px 18px;
      border-radius: 50px;
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dark-mode .profile {
      background: linear-gradient(to right,   #001866, #003061);;
      color: white;
    }

    .profile::after {
      content: "▼";
      font-size: 10px;
      margin-left: auto;
      transition: transform 0.3s ease;
    }

    .profile.open::after {
      transform: rotate(180deg);
    }

    .dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 110%;
      background: var(--card-light);
      color: var(--text-light);
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 10px;
      width: 240px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      z-index: 10;
      animation: fadeIn 0.3s ease;
    }

    .dark-mode .dropdown {
      background: var(--card-dark);
      color: var(--text-dark);
      border-color: #444;
    }

    .dropdown p {
      margin: 6px 0;
      font-size: 14px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 4px;
    }

    .dark-mode .dropdown p {
      border-bottom: 1px solid #555;
    }

    .dropdown button {
      margin-top: 10px;
      width: 100%;
      background-color: var(--danger);
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .dropdown button:hover {
      background-color: #c62828;
    }

    .container {
      background: var(--card-light);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
      text-align: center;
      transition: background 0.4s;
    }

    .dark-mode .container {
      background: var(--card-dark);
    }

    h2 {
      margin-bottom: 30px;
      color: var(--primary);
    }

    .menu {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .menu a {
      padding: 12px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      transition: 0.3s ease;
      font-size: 16px;
    }

    .menu a:hover {
      background: #0056b3;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1002;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: var(--card-light);
      color: var(--text-light);
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .dark-mode .modal-content {
      background: var(--card-dark);
      color: var(--text-dark);
    }

    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 20px;
    }

    .modal-buttons button {
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
    }

    .confirm-logout {
      background-color: var(--danger);
      color: white;
    }

    .cancel-logout {
      background-color: #ccc;
    }

    .confirm-logout:hover {
      background-color: #d9363e;
    }

    .cancel-logout:hover {
      background-color: #aaa;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="top-right-controls">
  <div class="toggle-switch-container">
    <label class="switch">
      <input type="checkbox" id="toggleSwitch">
      <span class="slider"></span>
    </label>
  </div>
  <div class="profile" onclick="toggleDropdown()">
    {{ Auth::user()->name }}
    <div class="dropdown" id="dropdownMenu">
      <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
      <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
      <button onclick="showModal()">Logout</button>
    </div>
  </div>
</div>

<div class="container">
  <h2>Dashboard Admin</h2>
  <div class="menu">
    <a href="{{ route('obat.index') }}">Kelola Obat</a>
    <a href="{{ route('pesanan.masuk') }}">Pesanan Masuk</a>
    <a href="{{ route('laporan.index') }}">Laporan Transaksi</a>
    <a href="{{ route('admin.komplain') }}">Kotak Komplain</a>
  </div>
</div>

<div class="modal" id="logoutModal">
  <div class="modal-content">
    <h3>Yakin ingin logout?</h3>
    <div class="modal-buttons">
      <form id="logoutForm" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="confirm-logout">Ya, Logout</button>
      </form>
      <button class="cancel-logout" onclick="hideModal()">Batal</button>
    </div>
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

  function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    const profile = document.querySelector('.profile');
    const isOpen = dropdown.style.display === 'block';
    dropdown.style.display = isOpen ? 'none' : 'block';
    profile.classList.toggle('open', !isOpen);
  }

  document.addEventListener('click', function(event) {
    const profile = document.querySelector('.profile');
    const dropdown = document.getElementById('dropdownMenu');
    if (!profile.contains(event.target)) {
      dropdown.style.display = 'none';
      profile.classList.remove('open');
    }
  });

  function showModal() {
    document.getElementById('logoutModal').style.display = 'flex';
  }

  function hideModal() {
    document.getElementById('logoutModal').style.display = 'none';
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") hideModal();
  });
</script>

</body>
</html>
