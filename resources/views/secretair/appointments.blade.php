@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Gestion des rendez-vous</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('secretaire.appointments.create') }}" class="btn btn-primary mb-3">
                + Nouveau rendez-vous
            </a>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Date et heure</th>
                        <th>Motif</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                        <td>Dr. {{ $appointment->medecin->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ $appointment->motif ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $appointment->status == 'confirmed' ? 'success' : 
                                ($appointment->status == 'cancelled' ? 'danger' : 'warning') 
                            }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('secretaire.appointments.cancel', $appointment) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Annuler ce rendez-vous ?')">Annuler</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucun rendez-vous</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection