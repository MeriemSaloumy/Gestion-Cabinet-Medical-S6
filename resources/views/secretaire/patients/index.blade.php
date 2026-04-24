
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0 text-primary"><i class="fas fa-users me-2"></i> "Liste des Patients";</h4>
            <a href="{{ route('secretaire.patients.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-1"></i> Nouveau Patient
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>CIN</th>
                            <th>Nom & Prénom</th>
                            <th>Téléphone</th>
                            <th>Sexe</th>
                            <th>Date de Naissance</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr>
                            <td><span class="badge bg-light text-dark border">{{ $patient->cin }}</span></td>
                            <td class="fw-bold">{{ $patient->name }} {{ $patient->prenom }}</td>
                            <td>{{ $patient->telephone }}</td>
                            <td>
                                @if($patient->sexe == 'M')
                                    <span class="badge bg-info-subtle text-info">Homme</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Femme</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('secretaire.patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Aucun patient trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $patients->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection