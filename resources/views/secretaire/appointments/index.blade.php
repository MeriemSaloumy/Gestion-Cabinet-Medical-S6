@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 font-weight-bold">📅 Gestion des Rendez-vous</h4>
            <a href="{{ route('secretaire.appointments.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm">
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
                                <span class="fw-bold text-primary">{{ $appointment->appointment_date->format('d/m/Y') }}</span><br>
                                <small class="text-muted">{{ $appointment->appointment_date->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $appointment->patient->nom }} {{ $appointment->patient->prenom }}</div>
                            </td>
                            <td>
                                <span class="text-secondary">Dr. {{ $appointment->medecin->name }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $appointment->motif ?? 'Non précisé' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $appointment->status == 'Confirmed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('secretaire.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ? Cette action est irréversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted italic">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                Aucun rendez-vous trouvé pour le moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles personnalisés pour peaufiner le rendu */
    .card { border-radius: 15px !important; overflow: hidden; }
    .table thead th { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        color: #6c757d;
        border-top: none;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    .badge { padding: 0.5em 1em; }
</style>
@endsection