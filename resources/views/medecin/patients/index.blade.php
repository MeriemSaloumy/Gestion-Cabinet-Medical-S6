@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Patients</h2>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Ajouter un nouveau patient</a>
    </div>

    <form action="{{ route('patients.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Rechercher par nom ou CIN..." value="{{ request('query') }}">
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
    </form>

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Patient</th>
                        <th>CIN</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->nom }} {{ $patient->prenom }}</td>
                        <td>{{ $patient->cin }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info text-white">
                                Voir Historique
                            </a>
                            <a href="{{ route('consultations.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-success">
                                Nouvelle Consultation
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">Aucun patient trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection