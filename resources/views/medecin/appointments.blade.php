@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>Mes rendez-vous à venir</h4>
                </div>
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Date et heure</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $appointment->motif ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $appointment->status }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('consultation.create', $appointment->id) }}" class="btn btn-sm btn-info">Compte-rendu</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">Aucun rendez-vous à venir</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4>Historique des consultations</h4>
                </div>
                <div class="card-body">
                    @if($pastAppointments->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pastAppointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $appointment->motif ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">Aucun historique</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection