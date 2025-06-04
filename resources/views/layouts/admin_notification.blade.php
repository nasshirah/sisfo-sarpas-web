@if(auth()->check() && auth()->user()->role == 'admin')
    @php
        $pendingRequests = \App\Models\Peminjaman::where('status', 'requested')->count();
    @endphp
    
    @if($pendingRequests > 0)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $pendingRequests }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                <li>
                    <div class="dropdown-header">Permintaan Peminjaman</div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('request.index') }}">
                        <span class="text-danger"><i class="bi bi-exclamation-circle me-2"></i>{{ $pendingRequests }} permintaan menunggu persetujuan</span>
                    </a>
                </li>
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bell"></i>
            </a>
        </li>
    @endif
@endif