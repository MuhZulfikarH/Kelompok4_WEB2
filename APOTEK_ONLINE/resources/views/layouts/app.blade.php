<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        .dark-mode .navbar {
            background-color: #1e1e1e !important;
        }

        .dark-mode .container, 
        .dark-mode .card, 
        .dark-mode .form-control {
            background-color: #1e1e1e;
            color: #e0e0e0;
            border-color: #333;
        }

        .dark-mode a {
            color: #90caf9;
        }

        .dark-mode input, 
        .dark-mode textarea {
            background-color: #1e1e1e;
            color: #e0e0e0;
            border-color: #444;
        }

        .dark-mode table {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }

        .dark-mode th {
            background-color: #2c2c2c;
            color: #fff;
        }

        .dark-mode td {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="#">Apotek</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard Admin</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/user/dashboard">Dashboard User</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                @endauth

                @if (request()->is('login') || request()->is('admin/dashboard') || request()->is('user/dashboard'))
                    <li class="nav-item">
                        <button id="darkModeToggle" class="btn btn-sm btn-outline-light ms-2">🌙</button>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('darkModeToggle');
            const prefersDark = localStorage.getItem('darkMode') === 'true';

            if (prefersDark) {
                document.body.classList.add('dark-mode');
            }

            if (toggle) {
                toggle.addEventListener('click', () => {
                    document.body.classList.toggle('dark-mode');
                    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
                });
            }
        });
    </script>
</body>
</html>
