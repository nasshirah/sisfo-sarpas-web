<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
        <h4 class="text-center">Laravel App</h4>
        <hr>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white">🏠 Dashboard</a>
            </li>

            @role('admin')
            <li class="nav-item">
                <a href="#" class="nav-link text-warning">⚙️ Admin Panel</a>
            </li>
            @endrole

            <li class="nav-item mt-3">
                <span class="text-muted">👤 {{ Auth::user()->name }} ({{ Auth::user()->getRoleNames()->first() }})</span>
            </li>

            <li class="nav-item mt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Content Area -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
</div>
