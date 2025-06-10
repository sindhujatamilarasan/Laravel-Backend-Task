<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Demo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background: #f4f6f9;
        }

        #app {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        nav.navbar {
            background: #ffffff;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .navbar-brand {
            font-weight: bold;
            color: #3f51b5;
        }

        .navbar-nav .nav-link,
        .dropdown-toggle {
            color: #3f51b5;
            font-weight: 600;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .dropdown-menu .dropdown-item:hover {
            color: #1a237e;
            background-color: #f0f0f0;
        }
        th,td {
            color: #494a50  !important;
        }
        /* Content Area */
        main.content {
            flex: 1;
            background: #ffffff;
            padding: 2rem;
            overflow-y: auto;
            border-radius: 0 0 0 12px;
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.03);
        }

        /* Avatar image */
        .navbar-nav img {
            object-fit: cover;
        }

        /* Responsive */
        @media (max-width: 575px) {
            main.content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg">
            <h4 class="navbar-brand">Products</h4>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3f51b5&color=fff&size=32"
                            alt="User Avatar" class="rounded-circle me-2" width="32" height="32" />
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables + jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 10,
                "columnDefs": [{
                    "orderable": false,
                    "targets": 2
                }]
            });
        });
    </script>
</body>

</html>
