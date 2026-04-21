@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de bord Administrateur</h1>
    
    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Patients</h5>
                    <h2 class="card-text">{{ $totalPatients }}</h2>
                    <p class="card-text">Total patients enregistrés</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Consultations</h5>
                    <h2 class="card-text">{{ $totalConsultations }}</h2>
                    <p class="card-text">Consultations réalisées</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Médecins</h5>
                    <h2 class="card-text">{{ $totalMedecins }}</h2>
                    <p class="card-text">Médecins actifs</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Rendez-vous</h5>
                    <h2 class="card-text">{{ $totalRendezVous }}</h2>
                    <p class="card-text">Total rendez-vous</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Graphiques -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Évolution des rendez-vous (12 mois)</h5>
                </div>
                <div class="card-body">
                    <canvas id="rdvChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Évolution des consultations (12 mois)</h5>
                </div>
                <div class="card-body">
                    <canvas id="consultationChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
    
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
                                    <td>{{ Carbon\Carbon::parse($rdv->appointment_date)->format('d/m/Y H:i') }}</td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des rendez-vous
    const rdvCtx = document.getElementById('rdvChart').getContext('2d');
    new Chart(rdvCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($rdvParMois, 'mois')) !!},
            datasets: [{
                label: 'Nombre de rendez-vous',
                data: {!! json_encode(array_column($rdvParMois, 'total')) !!},
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    
    // Graphique des consultations
    const consultationCtx = document.getElementById('consultationChart').getContext('2d');
    new Chart(consultationCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($consultationsParMois, 'mois')) !!},
            datasets: [{
                label: 'Nombre de consultations',
                data: {!! json_encode(array_column($consultationsParMois, 'total')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>
@endpush