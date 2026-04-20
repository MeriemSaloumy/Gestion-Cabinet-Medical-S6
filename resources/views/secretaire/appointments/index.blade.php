@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 font-weight-bold">📅 {{ $title ?? 'Gestion des Rendez-vous' }}</h4>
            <a href="{{ route('secretaire.appointments.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm rounded-pill px-3">
                <i class="bi bi-plus-lg"></i> Nouveau RDV
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Date & Heure</th>
                            <th>Patient</th>
                            <th>Médecin</th>
                            <th>Motif</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td class="px-4">
                                <span class="fw-bold text-primary">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                </span><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $appointment->patient->nom ?? 'Patient inconnu' }} {{ $appointment->patient->prenom ?? '' }}</div>
                            </td>
                            <td>
                                <span class="text-secondary"><i class="bi bi-person-badge me-1"></i> Dr. {{ $appointment->medecin->name }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ Str::limit($appointment->motif ?? 'Non précisé', 20) }}</span>
                            </td>
                            <td class="text-center">
                                @if($appointment->status == 'confirmed' || $appointment->status == 'confirmé')
                                    <span class="badge rounded-pill bg-success px-3">
                                        <i class="bi bi-check-all"></i> Confirmé
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-warning text-dark px-3">
                                        <i class="bi bi-clock"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($appointment->status != 'confirmé')
                                    <form action="{{ route('appointments.confirm', $appointment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-envelope-check"></i> Confirmer
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('secretaire.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce RDV ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted italic">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                Aucun rendez-vous trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 15px !important; overflow: hidden; }
    .table thead th { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        color: #6c757d;
        border-top: none;
    }
    .badge { font-weight: 500; font-size: 0.85rem; }
</style>
@endsection