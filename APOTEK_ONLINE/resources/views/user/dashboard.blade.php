<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pengguna - Apotek Online</title>
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
      --card-light: #fff;
      --card-dark: #1e1e1e;
      --text-light: #333;
      --text-dark: #f5f5f5;
      --primary: #007bff;
      --hover: #0056b3;
      --danger: #d33;
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
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: background 0.3s, color 0.3s;
    }

    .dark-mode body {
      background: var(--bg-dark);
      color: var(--text-dark);
    }

    header {
      background-color: var(--primary);
      padding: 20px;
      color: white;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }

    nav {
      background: var(--hover);
      padding: 12px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 8px 16px;
      border-radius: 6px;
      transition: background 0.3s;
    }

    nav a:hover {
      background-color: #003d80;
    }

    .top-controls {
      position: fixed;
      top: 20px; 
      right: 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 32px;
      z-index: 999;
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

    .profile-container {
      position: relative;
    }

    .profile-btn {
      background: linear-gradient(to right, #9ab2ff, #f3f4f5);
      color: var(--text-light);
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dark-mode .profile-btn {
      background: linear-gradient(to right, #001866, #003061);
      color: var(--text-dark);
    }

    .profile-btn::after {
      content: "▼";
      font-size: 14px;
      transition: transform 0.3s ease;
    }

    .profile-btn.open::after {
      transform: rotate(180deg); 
    }

    .profile-dropdown {
      display: none;
      position: absolute;
      top: 110%;
      right: 0;
      background: var(--card-light);
      color: var(--text-light);
      padding: 12px;
      border-radius: 10px;
      margin-top: 8px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
      width: 220px;
    }

    .dark-mode .profile-dropdown {
      background: var(--card-dark); 
      color: var(--text-dark);
    }

    .profile-dropdown p {
      margin: 5px 0;
      font-size: 14px;
      text-decoration: underline;
    }

    .profile-dropdown button {
      margin-top: 10px;
      background: var(--danger);
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    .container {
      padding: 20px;
      flex: 1;
    }

    .filter-form {
      margin-bottom: 20px;
    }

    select {
      padding: 6px 12px;
      font-size: 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 24px;
    }

    .product-card {
      background: var(--card-light);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: center;
      cursor: pointer;
    }

    .dark-mode .product-card {
      background: var(--card-dark);
    }

    .product-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .product-card h4 {
      font-size: 18px;
      margin-bottom: 8px;
      color: var(--primary);
    }

    .product-card p {
      font-size: 14px;
      margin-bottom: 6px;
      opacity: 0.85;
    }

    .btn-beli {
      display: inline-block;
      background-color: var(--primary);
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      font-size: 14px;
      margin-top: 12px;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-beli:hover {
      background-color: var(--hover);
      transform: scale(1.05);
    }

    footer {
      text-align: center;
      font-size: 14px;
      color: #888;
      padding: 20px;
    }

    .komplain-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 999;
      background-color: var(--primary);
      color: white;
      padding: 12px 18px;
      border-radius: 50px;
      font-size: 14px;
      cursor: pointer;
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
      transition: background 0.3s ease;
    }

    .komplain-btn:hover {
      background-color: var(--hover);
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.4);
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
      max-width: 400px;
      width: 90%;
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

    .modal textarea {
      width: 100%;
      height: 100px;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      resize: vertical;
      font-size: 14px;
    }

    .dark-mode .modal textarea {
      background: #2b2b2b;
      color: #f5f5f5;
      border: 1px solid #555;
      
    }
    .dark-mode select {
      background-color: #2b2b2b;
      color: #f5f5f5;
      border: 1px solid #555;
    }

    .dark-mode input[type="text"],
    .dark-mode input[type="search"] {
      background-color: #2b2b2b;
      color: #f5f5f5;
      border: 1px solid #555;
    }
    
    .pesan-btn {
      position: fixed;
      top: 10px;
      left: 20px;
      z-index: 999;
      background-color: white;
      color: var(--primary);
      padding: 12px 18px;
      border-radius: 8px;
      border: 2px solid var(--primary);
      font-size: 14px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .pesan-btn:hover {
      background-color: var(--primary);
      color: white;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
<div class="top-controls">
  <label class="switch">
    <input type="checkbox" id="toggleSwitch">
    <span class="slider"></span>
  </label>

<div class="modal" id="balasanModal">
  <div class="modal-content" style="max-height: 70vh; overflow-y: auto;">
    <h3>Balasan Admin:</h3>
    @forelse ($komplains as $k)
      <div style="margin-bottom: 16px; text-align: left;">
        <p><strong>📝 Komplain:</strong> {{ $k->isi }}</p>
        @if ($k->balasan)
          <p><strong>📩 Balasan:</strong> {{ $k->balasan->isi }}</p>
        @else
          <p style="color: gray;">(Belum ada balasan)</p>
        @endif
        <hr style="margin-top: 10px;">
      </div>
    @empty
      <p>Tidak ada komplain yang ditemukan.</p>
    @endforelse
    <div class="modal-buttons">
      <button type="button" onclick="document.getElementById('balasanModal').style.display='none'" class="cancel-logout">Tutup</button>
    </div>
  </div>
</div>

  <div class="profile-container">
    <div class="profile-btn" onclick="toggleDropdown()">
      {{ Auth::user()->name }} 
    </div>
    <div class="profile-dropdown" id="dropdownMenu">
      <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
      <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
      <button onclick="showLogoutModal()">Logout</button>
    </div>
  </div>
</div>

<header>Dashboard Pengguna</header>

<nav>
  <a href="{{ route('user.daftar_obat') }}">Daftar Obat</a>
  <a href="{{ route('user.pesanan_saya') }}">Pesanan Saya</a>
</nav>

<div class="pesan-btn" onclick="toggleBalasan()">
  📩 <span style="font-weight: bold;">Pesan</span>
</div>

<div class="container">
  <h3>Daftar Obat</h3>
  <form method="GET" action="{{ route('user.dashboard') }}" class="filter-form">
    <input type="text" id="searchInput" placeholder="Cari obat..." 
    style="margin-left: 12px; padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 14px;">
    <label for="kategori">Filter Kategori:</label>
    <select name="kategori" id="kategori" onchange="this.form.submit()">
      <option value="">Semua Kategori</option>
      @foreach ($kategoriList as $kategori)
        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
          {{ $kategori->nama }}
        </option>
      @endforeach
    </select>
  </form>

  <div class="product-grid">
    @foreach ($obats as $obat)
    <div class="product-card">
      <h4>{{ $obat->nama }}</h4>
      <p>Kategori: {{ $obat->kategori->nama ?? '-' }}</p>
      <p>Harga: Rp{{ number_format($obat->harga) }}</p>
      <a href="{{ route('user.form_pesan_obat', $obat->id) }}" class="btn-beli">Beli</a>
    </div>
    @endforeach
  </div>
</div>

<div class="komplain-btn" onclick="document.getElementById('komplainModal').style.display='flex'">
  💬 Komplain
</div>

<div class="modal" id="komplainModal">
  <div class="modal-content">
    <h3>Kirim Masalah yang dihadapi:</h3>
    <form action="{{ route('user.kirim_komplain') }}" method="POST">
      @csrf
      <textarea name="komplain" placeholder="Tulis keluhan Anda di sini..." required></textarea>
      <div class="modal-buttons">
        <button type="submit" class="confirm-logout" style="background-color: var(--primary);">Kirim</button>
        <button type="button" onclick="document.getElementById('komplainModal').style.display='none'" class="cancel-logout">Tutup</button>
      </div>
    </form>
  </div>
</div>

<div class="modal" id="logoutModal">
  <div class="modal-content">
    <h3>Yakin ingin keluar?</h3>
    <div class="modal-buttons">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="confirm-logout">Ya, Keluar</button>
      </form>
      <button onclick="hideLogoutModal()" class="cancel-logout">Batal</button>
    </div>
  </div>
</div>

<footer>&copy; {{ date('Y') }} Apotek Online</footer>

<script>
  function toggleBalasan() {
    document.getElementById('balasanModal').style.display = 'flex';
  }
  function toggleDropdown() {
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    const profileBtn = document.querySelector(".profile-btn");
    profileBtn.classList.toggle("open", dropdown.style.display === "block");
  }

  document.addEventListener("click", function(e) {
    const dropdown = document.getElementById("dropdownMenu");
    const profile = document.querySelector(".profile-container");
    if (!profile.contains(e.target)) {
      dropdown.style.display = "none";
      document.querySelector(".profile-btn").classList.remove("open");
    }
  });

  function showLogoutModal() {
    document.getElementById("logoutModal").style.display = "flex";
  }

  function hideLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
  }

  const toggle = document.getElementById('toggleSwitch');
  const html = document.documentElement;
  toggle.addEventListener('change', () => {
    html.classList.toggle('dark-mode');
    localStorage.setItem('theme', html.classList.contains('dark-mode') ? 'dark' : 'light');
  });
  window.onload = () => {
    toggle.checked = localStorage.getItem('theme') === 'dark';
  };
  const searchInput = document.getElementById('searchInput');
  searchInput.addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    const cards = document.querySelectorAll('.product-card');
    cards.forEach(card => {
      const nama = card.querySelector('h4').textContent.toLowerCase();
      card.style.display = nama.includes(keyword) ? '' : 'none';
    });
  });
</script>

</body>
</html>
