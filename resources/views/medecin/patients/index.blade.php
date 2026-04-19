@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Répertoire des Patients</h3>
        <form action="{{ route('medecin.patients.index') }}" method="GET" class="d-flex w-50">
            <input type="text" name="search" class="form-control me-2 shadow-sm" placeholder="Rechercher par Nom ou CIN..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary shadow-sm">Chercher</button>
        </form>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Patient</th>
                        <th>CIN</th>
                        <th>Âge</th>
                        <th class="text-end px-4">Historique</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td class="px-4">
                            <span class="fw-bold text-dark">{{ $patient->nom }} {{ $patient->prenom }}</span>
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $patient->cin }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($patient->date_naissance)->age }} ans</td>
                        <td class="text-end px-4">
                            <a href="{{ route('medecin.patients.dossier', $patient->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-folder-open me-1"></i> Dossier Médical
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $patients->links() }}
    </div>
</div>
@endsection