<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { shadow-sm; }
        .nav-link { font-weight: 500; transition: 0.3s; }
        .nav-link:hover { color: #fff !important; opacity: 0.8; }
        .active-link { border-bottom: 2px solid white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ Auth::user()->role == 'medecin' ? route('medecin.dashboard') : route('secretaire.dashboard') }}">
                <i class="fas fa-hospital-user me-2"></i>Cabinet Médical
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item px-2">
                            {{-- SI C'EST UN MEDECIN --}}
                            @if(Auth::user()->role == 'medecin')
                                <a class="nav-link {{ request()->routeIs('medecin.dashboard') ? 'active-link text-white' : '' }}" href="{{ route('medecin.dashboard') }}">
                                    <i class="fas fa-chart-line me-1"></i> Dashboard
                                </a>
                            {{-- SI C'EST UNE SECRETAIRE --}}
                            @else
                                <a class="nav-link {{ request()->routeIs('secretaire.dashboard') ? 'active-link text-white' : '' }}" href="{{ route('secretaire.dashboard') }}">
                                    <i class="fas fa-chart-line me-1"></i> Dashboard
                                </a>
                            @endif
                        </li>

                        {{-- LIEN RENDEZ-VOUS (Affiché seulement pour la secrétaire) --}}
                        @if(Auth::user()->role == 'secretaire')
                        <li class="nav-item px-2">
                            <a class="nav-link {{ request()->routeIs('secretaire.appointments.*') ? 'active-link text-white' : '' }}" href="{{ route('secretaire.appointments.index') }}">
                                <i class="fas fa-calendar-alt me-1"></i> Rendez-vous
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item ms-lg-3 py-2 py-lg-0">
                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </span>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-white-50 border-0">
                                    <i class="fas fa-sign-out-alt ms-2"></i>
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>