@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de bord Administrateur</h1>
    
    <!-- Cartes de statistiques cliquables -->
    <div class="row mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.users.index') }}?role=patient" class="text-decoration-none">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Patients</h5>
                        <h2 class="card-text">{{ $totalPatients }}</h2>
                        <p class="card-text">Total patients enregistrés</p>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="{{ route('admin.consultations.index') }}" class="text-decoration-none">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Consultations</h5>
                        <h2 class="card-text">{{ $totalConsultations }}</h2>
                        <p class="card-text">Consultations réalisées</p>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="{{ route('admin.users.index') }}?role=medecin" class="text-decoration-none">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Médecins</h5>
                        <h2 class="card-text">{{ $totalMedecins }}</h2>
                        <p class="card-text">Médecins actifs</p>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3">
            <a href="{{ route('secretaire.appointments.index') }}" class="text-decoration-none">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Rendez-vous</h5>
                        <h2 class="card-text">{{ $totalRendezVous }}</h2>
                        <p class="card-text">Total rendez-vous</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Le reste du code (graphiques et derniers rendez-vous) reste identique -->
    
    <!-- Derniers rendez-vous -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Derniers rendez-vous</h5>
                </div>
                <div class="card-body">
                    @if($derniersRendezVous->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($derniersRendezVous as $rdv)
                                <tr>
                                    <td>{{ $rdv->patient->nom ?? 'N/A' }} {{ $rdv->patient->prenom ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rdv->appointment_date)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $rdv->status == 'completed' ? 'success' : ($rdv->status == 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ $rdv->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Aucun rendez-vous enregistré.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection