<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya - Apotek Online</title>
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
            --border-light: #ddd;
            --border-dark: #444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-light);
            padding: 30px 20px;
            transition: background 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .dark-mode body {
            background-color: var(--bg-dark);
            color: var(--text-dark);
        }

        .container {
            max-width: 900px;
            background: var(--card-light);
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dark-mode .container {
            background: var(--card-dark);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        nav {
            text-align: center;
            margin-bottom: 20px;
        }

        nav a {
            text-decoration: none;
            color: var(--primary);
            margin: 0 10px;
            font-size: 16px;
        }

        nav a:hover {
            color: var(--hover);
        }

        hr {
            border: none;
            height: 1px;
            background-color: var(--border-light);
            margin: 20px 0;
        }

        ul { list-style-type: none; padding: 0; }

        li {
            background: #f9fbff;
            margin-bottom: 15px;
            padding: 20px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
        }

        .dark-mode li {
            background: #1a1a1a;
            border-color: var(--border-dark);
        }

        li:hover {
            transform: translateY(-5px);
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .status { font-weight: bold; }
        .status-pending { color: orange; }
        .status-diproses { color: red; }
        .status-selesai { color: #32cd32; }
        .status-dibatalkan { color: gray; }

        a.detail-link {
            display: inline-block;
            padding: 6px 12px;
            margin-left: 10px;
            background-color: var(--primary);
            color: #fff;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            }

        a.detail-link:hover {
            background-color: var(--hover);
            transform: scale(1.05);
            }

        .batal-button {
            margin-left: 10px;
            background: #d33;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
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
            content: "";
            position: absolute;
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

        @media (max-width: 768px) {
            li { font-size: 14px; }
        }

        /* Modal */
        #modal-konfirmasi {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal-box {
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
        }

        .dark-mode .modal-box {
            background: #1e1e1e;
            color: #f5f5f5;
        }

        .modal-box button {
            margin: 10px;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .modal-box .btn-yakin {
            background: #d33;
            color: white;
        }

        .modal-box .btn-batal {
            background: #ccc;
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
    <h2>Pesanan Saya</h2>

    <nav>
        <a href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a> |
        <a href="{{ route('user.daftar_obat') }}">+ Pesan Obat Baru</a>
    </nav>

    <hr>

    @if ($pesanan->isEmpty())
        <p style="text-align:center; color: #666;">Belum ada pesanan.</p>
    @else
        <ul>
            @foreach ($pesanan as $p)
                @php
                    $total = $p->total_harga ?? $p->detailPesanan->sum(fn($d) => $d->jumlah * $d->harga);
                    $statusClass = match($p->status) {
                        'pending' => 'status-pending',
                        'diproses' => 'status-diproses',
                        'selesai' => 'status-selesai',
                        'dibatalkan' => 'status-dibatalkan',
                        default => ''
                    };
                @endphp
                <li>
                    <strong>ID:</strong> {{ $p->id }} |
                    <strong>Tanggal:</strong> {{ $p->created_at->format('d M Y') }} |
                    <strong>Status:</strong> <span class="status {{ $statusClass }}">{{ ucfirst($p->status) }}</span> |
                    <strong>Total:</strong> Rp{{ number_format($total) }}
                    <a href="{{ route('user.detail_pesanan', $p->id) }}" class="detail-link">[Detail]</a>

                    @if ($p->status === 'pending')
                        <button class="batal-button" onclick="konfirmasiBatal({{ $p->id }})">Batalkan</button>
                        <form id="form-batal-{{ $p->id }}" action="{{ route('user.batalkan_pesanan', $p->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>

<div id="modal-konfirmasi">
    <div class="modal-box">
        <p>Yakin ingin membatalkan pesanan?</p>
        <button class="btn-yakin" id="btn-yakin">Yakin</button>
        <button class="btn-batal" onclick="tutupModal()">Batal</button>
    </div>
</div>

<script>
    const toggle = document.getElementById('toggleSwitch');
    const html = document.documentElement;
    let formId = null;

    toggle.addEventListener('change', () => {
        html.classList.toggle('dark-mode');
        localStorage.setItem('theme', html.classList.contains('dark-mode') ? 'dark' : 'light');
    });

    window.onload = () => {
        toggle.checked = localStorage.getItem('theme') === 'dark';
    };

    function konfirmasiBatal(id) {
        formId = 'form-batal-' + id;
        document.getElementById('modal-konfirmasi').style.display = 'flex';
    }

    function tutupModal() {
        document.getElementById('modal-konfirmasi').style.display = 'none';
        formId = null;
    }

    document.getElementById('btn-yakin').addEventListener('click', function () {
        if (formId) {
            document.getElementById(formId).submit();
        }
    });
</script>

</body>
</html>
