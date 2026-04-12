@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4>Mes prochains rendez-vous</h4>
                </div>
                <div class="card-body">
                    @if($upcomingAppointments->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Médecin</th>
                                    <th>Date et heure</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                <tr>
                                    <td>Dr. {{ $appointment->medecin->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $appointment->motif ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status == 'confirmed' ? 'success' : 'warning' }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        95
                    @else
                        <p class="text-center">Aucun rendez-vous à venir</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4>Historique de mes rendez-vous</h4>
                </div>
                <div class="card-body">
                    @if($pastAppointments->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Médecin</th>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pastAppointments as $appointment)
                                <tr>
                                    <td>Dr. {{ $appointment->medecin->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $appointment->motif ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        95
                    @else
                        <p class="text-center">Aucun historique</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection