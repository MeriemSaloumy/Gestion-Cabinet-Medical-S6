@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Bienvenue, {{ Auth::user()->name }}</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📅 Mes Prochains Rendez-vous</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date & Heure</th>
                                <th>Médecin</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rendezVous as $rdv)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}</td>
                                <td>Dr. {{ $rdv->doctor->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $rdv->status == 'confirmé' ? 'success' : 'warning' }}">
                                        {{ ucfirst($rdv->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Aucun rendez-vous prévu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🩺 Mes Ordonnances & Documents</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($consultations as $consultation)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $consultation->created_at->format('d/m/Y') }}</strong><br>
                                <small class="text-muted">{{ $consultation->maladie }}</small>
                            </div>
                            <a href="{{ route('consultations.pdf', $consultation->id) }}" class="btn btn-sm btn-outline-danger">
                                📄 PDF
                            </a>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Aucun document disponible.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection