@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-bg: #f8f9fc;
    }
    body { background-color: var(--secondary-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    /* Barre de recherche */
    .top-search-bar {
        background: white;
        border-radius: 12px;
        padding: 5px 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border: 1px solid #e3e6f0;
        width: 100%;
        max-width: 500px;
    }
    .top-search-bar input { border: none; outline: none; width: 100%; padding: 8px; font-size: 0.95rem; }
    
    /* Cartes Statistiques */
    .stat-card-link { text-decoration: none !important; color: inherit; display: block; }
    .stat-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important; }
    .active-filter { border: 3px solid #2e59d9 !important; }

    /* Tableau */
    .table-card { border-radius: 15px; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    .table thead th { background: #f8f9fc; color: #4e73df; text-transform: uppercase; font-size: 0.8rem; border: none; }
</style>

<div class="container-fluid py-4">
    
    <div class="row align-items-center mb-4">
        <div class="col-md-4">
            <h3 class="fw-bold mb-0">Bonjour, Dr. {{ Auth::user()->name }}</h3>
            <p class="text-muted small">Gestion du cabinet médical</p>
        </div>
        <div class="col-md-8 d-flex justify-content-end">
            <form action="{{ route('medecin.dashboard') }}" method="GET" class="top-search-bar d-flex align-items-center">
                <i class="fas fa-search me-2 text-muted"></i>
                <input type="text" name="search" placeholder="Rechercher un patient par CIN..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">Chercher</button>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('medecin.dashboard', ['filter' => 'waiting']) }}" class="stat-card-link">
                <div class="card stat-card bg-danger text-white h-100 {{ request('filter') == 'waiting' ? 'active-filter' : '' }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75">Patients Attendus</h6>
                            <h2 class="fw-bold mb-0">{{ $rdvAujourdhui ?? 0 }}</h2>
                        </div>
                        <span class="display-5 opacity-50">⏳</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('medecin.dashboard') }}" class="stat-card-link">
                <div class="card stat-card bg-warning text-white h-100 {{ !request('filter') ? 'active-filter' : '' }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75">Agenda Total (Jour)</h6>
                            <h2 class="fw-bold mb-0">{{ $fileAttente->count() ?? 0 }}</h2>
                        </div>
                        <span class="display-5 opacity-50">📅</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('medecin.patients.index') }}" class="stat-card-link">
                <div class="card stat-card bg-primary text-white h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75">Total Dossiers</h6>
                            <h2 class="fw-bold mb-0">{{ $totalPatientsSuivis ?? 0 }}</h2>
                        </div>
                        <span class="display-5 opacity-50">📁</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card table-card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 fw-bold text-primary">
                @if(request('filter') == 'waiting') Liste des patients en attente @else Agenda complet du jour @endif
            </h5>
            @if(request('filter') || request('search'))
                <a href="{{ route('medecin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill">Effacer les filtres</a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">Heure</th>
                            <th>Patient / CIN</th>
                            <th>Statut</th>
                            <th class="text-end px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fileAttente as $rdv)
                        <tr>
                            <td class="px-4 fw-bold text-primary">{{ \Carbon\Carbon::parse($rdv->appointment_date)->format('H:i') }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</div>
                                <small class="text-muted">{{ $rdv->patient->cin }}</small>
                            </td>
                            <td>
                                @if($rdv->status == 'termine')
                                    <span class="badge bg-success text-white px-3 rounded-pill">Terminé</span>
                                @else
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">En attente</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                @if($rdv->status != 'termine')
                                    <a href="{{ route('medecin.consultations.create', $rdv->patient_id) }}" class="btn btn-danger btn-sm rounded-pill px-4">Examiner</a>
                                @else
                                    <span class="text-success small fw-bold">Traité <i class="fas fa-check-circle ms-1"></i></span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-info-circle me-2"></i> Aucun rendez-vous trouvé pour aujourd'hui.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection