@auth
    @if (Auth::user()->role !== 'admin')
        <script>
            window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endauth
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sisfo Sarpras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --text-primary: #6e707e;
            --text-light: #858796;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--secondary-color);
            overflow-x: hidden;
        }
        
        #wrapper {
            display: flex;
        }
        
        #content-wrapper {
            background-color: #f8f9fc;
            width: 100%;
            overflow-x: hidden;
        }
        
        #content {
            flex: 1 0 auto;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            min-height: 100vh;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar.toggled {
            width: 6.5rem;
        }
        
        .sidebar-brand {
            height: var(--topbar-height);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
        }
        
        .sidebar-brand-icon i {
            font-size: 2rem;
        }
        
        .sidebar-brand-text {
            display: inline;
        }
        
        .sidebar.toggled .sidebar-brand-text {
            display: none;
        }
        
        .sidebar hr.sidebar-divider {
            margin: 0 1rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        .sidebar-heading {
            text-align: left;
            padding: 0 1rem;
            font-weight: 800;
            font-size: .65rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: .13rem;
        }
        
        .sidebar.toggled .sidebar-heading {
            text-align: center;
        }
        
        .nav-item {
            position: relative;
        }
        
        .sidebar .nav-item .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            width: 100%;
        }
        
        .sidebar .nav-item .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-item .nav-link:active, 
        .sidebar .nav-item .nav-link:focus {
            color: #fff;
        }
        
        .sidebar .nav-item .nav-link i {
            font-size: 0.85rem;
            margin-right: 0.25rem;
        }
        
        .sidebar .nav-item .nav-link span {
            font-size: 0.85rem;
            display: inline;
        }
        
        .sidebar.toggled .nav-item .nav-link {
            text-align: center;
            padding: 0.75rem 1rem;
        }
        
        .sidebar.toggled .nav-item .nav-link span {
            display: none;
        }
        
        .sidebar.toggled .nav-item .nav-link i {
            float: left;
            text-align: center;
            font-size: 1rem;
            margin-right: 0;
            width: 100%;
        }
        
        .sidebar .nav-item.active .nav-link {
            font-weight: 700;
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 1rem 0;
        }
        
        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .topbar .navbar {
            height: var(--topbar-height);
            padding: 0;
        }
        
        .topbar .navbar-search {
            width: 25rem;
        }
        
        .topbar .navbar-search input {
            font-size: 0.85rem;
            height: auto;
        }
        
        .topbar .dropdown {
            position: static;
        }
        
        .topbar .dropdown .dropdown-menu {
            width: calc(100% - var(--sidebar-width));
            right: 0;
            left: auto;
        }
        
        .topbar.toggled .dropdown .dropdown-menu {
            width: calc(100% - 6.5rem);
        }
        
        .topbar .dropdown-list {
            padding: 0;
            border: none;
            overflow: hidden;
        }
        
        .topbar .dropdown-list .dropdown-header {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.75rem 1rem;
            font-weight: 800;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
        }
        
        .topbar .dropdown-list .dropdown-item {
            white-space: normal;
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .topbar .dropdown-user .dropdown-menu {
            width: auto;
        }
        
        .topbar .dropdown-menu {
            position: absolute;
        }
        
        .topbar .dropdown-toggle::after {
            display: none;
        }
        
        /* Main Content */
        .container-fluid {
            padding: 1.5rem;
        }
        
        /* Cards */
        .card {
            margin-bottom: 1.5rem;
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-header h6 {
            margin-bottom: 0;
            font-weight: 700;
            font-size: 1rem;
            color: #4e73df;
        }
        
        /* Footer */
        .sticky-footer {
            padding: 2rem 0;
            flex-shrink: 0;
            background-color: #fff;
            box-shadow: 0 -0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        /* Badge Notification */
        .badge-notification {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }
            
            .sidebar.toggled {
                width: var(--sidebar-width);
            }
            
            .topbar .dropdown .dropdown-menu {
                width: 100%;
            }
            
            .topbar.toggled .dropdown .dropdown-menu {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav" id="sidebar">
            <li class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-box-open text-white"></i>
                </div>
                <div class="sidebar-brand-text mx-3 text-white">SISFO SARPRAS</div>
            </li>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Menu Utama</div>
            
            <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kategori.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Kategori Barang</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('barang.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Barang</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Transaksi</div>
            
            <li class="nav-item {{ request()->is('peminjaman*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('peminjaman.index') }}">
                    <i class="fas fa-fw fa-hand-holding"></i>
                    <span>Peminjaman</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('pengembalian*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pengembalian.index') }}">
                    <i class="fas fa-fw fa-undo"></i>
                    <span>Pengembalian</span>
                </a>
            </li>
            
            @if(auth()->user() && auth()->user()->role == 'admin')
            <li class="nav-item {{ request()->is('request*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('request.index') }}">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Permintaan Peminjaman</span>
                    @php
                        $requestCount = \App\Models\Peminjaman::where('status', 'requested')->count();
                    @endphp
                    @if($requestCount > 0)
                        <span class="badge bg-danger rounded-pill ms-2">{{ $requestCount }}</span>
                    @endif
                </a>
            </li>
            @endif
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Laporan</div>
            
            <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ Route('laporan.index') }}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </li>
            
            @if(auth()->user() && auth()->user()->role == 'admin')
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Pengaturan</div>
            
            <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User</span>
                </a>
            </li>
            @endif
            
            <li class="nav-item {{ request()->is('profile*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>Profil</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        
                        <!-- Nav Item - Notifications -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Notifications -->
                                @if(auth()->check())
                                    @php
                                        $notificationCount = 3; // Replace with your actual notification count logic
                                    @endphp
                                    @if($notificationCount > 0)
                                        <span class="badge badge-danger badge-counter">{{ $notificationCount }}</span>
                                    @endif
                                @endif
                            </a>
                            <!-- Dropdown - Notifications -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                @if(auth()->check())
                                    <!-- Include your notifications here -->
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="me-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">12 Mei, 2025</div>
                                            <span class="font-weight-bold">Laporan bulanan sudah tersedia!</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="me-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">11 Mei, 2025</div>
                                            <span>5 barang dalam kondisi rusak!</span>
                                        </div>
                                    </a>
                                @endif
                                <a class="dropdown-item text-center small text-gray-500" href="#">Tampilkan Semua Notifikasi</a>
                            </div>
                        </li>
                        
                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                        <!-- Nav Item - User Information -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                    <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60" width="32" height="32">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                        Profil
                                    </a>
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                        Pengaturan
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>
                                        Aktivitas
                                    </a>
                                    @endif
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                        Keluar
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </nav>
                <!-- End of Topbar -->
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    
    <script>
        // Toggle the sidebar
        document.getElementById('sidebarToggleTop').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('toggled');
        });
    </script>
    
    @stack('scripts')
</body>
</html>