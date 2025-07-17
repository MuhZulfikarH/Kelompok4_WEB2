<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Obat - Admin</title>
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
      --danger: #dc3545;
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
      transition: background 0.4s, color 0.4s;
    }

    .dark-mode body {
      background: var(--bg-dark);
      color: var(--text-dark);
    }

    h2 {
      text-align: center;
      color: var(--primary);
      margin-bottom: 20px;
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

    .actions {
      text-align: center;
      margin-bottom: 20px;
    }

    .actions a {
      margin: 0 10px;
      padding: 8px 14px;
      background: var(--primary);
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .actions a:hover {
      background: #0056b3;
    }

    table {
      width: 100%;
      max-width: 1000px;
      margin: auto;
      border-collapse: collapse;
      background: var(--card-light);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      color: inherit;
      transition: background 0.4s;
    }

    .dark-mode table {
      background: var(--card-dark);
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background: var(--primary);
      color: #fff;
    }

    td form {
      display: inline;
    }

    button {
      padding: 5px 10px;
      background: var(--danger);
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background: #c82333;
    }

    a.edit {
      color: var(--primary);
      text-decoration: none;
      margin-right: 8px;
    }

    a.edit:hover {
      text-decoration: underline;
    }

    /* Modal Styling */
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
      width: 90%;
      max-width: 400px;
    }

    .dark-mode .modal-content {
      background: var(--card-dark);
      color: var(--text-dark);
    }

    .modal-buttons {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .btn-confirm {
      background-color: var(--danger);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-cancel {
      background-color: #e0e0e0;
      color: #333;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-cancel:hover {
      background-color: #d0d0d0;
    }

    @media (max-width: 768px) {
      table {
        font-size: 14px;
      }

      .actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .actions a {
        display: block;
        text-align: center;
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

  <div class="actions">
    <a href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
    <a href="{{ route('obat.create') }}">+ Tambah Obat Baru</a>
  </div>

  <table>
    <tr>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Stok</th>
      <th>Harga</th>
      <th>Aksi</th>
    </tr>
    @foreach ($obats as $obat)
    <tr>
      <td>{{ $obat->nama }}</td>
      <td>{{ $obat->kategori->nama ?? '-' }}</td>
      <td>{{ $obat->stok }}</td>
      <td>{{ number_format($obat->harga) }}</td>
      <td>
        <a class="edit" href="{{ route('obat.edit', $obat->id) }}">Edit</a>
        <form method="POST" action="{{ route('obat.destroy', $obat->id) }}" class="delete-form" data-obatid="{{ $obat->id }}">
          @csrf
          @method('DELETE')
          <button type="button" onclick="confirmDelete(this)">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>

  <!-- Modal Konfirmasi -->
  <div class="modal" id="deleteModal">
    <div class="modal-content">
      <h3>Yakin ingin menghapus obat?</h3>
      <div class="modal-buttons">
        <button class="btn-confirm" onclick="submitDelete()">Ya, Hapus</button>
        <button class="btn-cancel" onclick="closeModal()">Batal</button>
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

    let formToDelete = null;

    function confirmDelete(button) {
      const form = button.closest('form');
      formToDelete = form;
      document.getElementById("deleteModal").style.display = "flex";
    }

    function closeModal() {
      document.getElementById("deleteModal").style.display = "none";
      formToDelete = null;
    }

    function submitDelete() {
      if (formToDelete) {
        formToDelete.submit();
      }
    }
  </script>
</body>
</html>
