@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Dossier médical de {{ $patient->nom }} {{ $patient->prenom }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>CIN :</strong> {{ $patient->cin }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Email :</strong> {{ $patient->email ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Téléphone :</strong> {{ $patient->telephone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Date de naissance :</strong> {{ $patient->date_naissance ?? 'Non renseignée' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Adresse :</strong> {{ $patient->adresse ?? 'Non renseignée' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4>Historique des consultations</h4>
                </div>
                <div class="card-body">
                    @if($historique && $historique->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Diagnostic</th>
                                        <th>Compte-rendu</th>
                                        <th>Tension</th>
                                        <th>Poids</th>
                                        <th>Ordonnance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historique as $consultation)
                                    <tr>
                                        <td>{{ $consultation->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ Str::limit($consultation->diagnostic, 50) }}</td>
                                        <td>{{ Str::limit($consultation->compte_rendu, 80) }}</td>
                                        <td>{{ $consultation->tension ?? '-' }}</td>
                                        <td>{{ $consultation->poids ? $consultation->poids . ' kg' : '-' }}</td>
                                        <td>
                                            <a href="{{ route('ordonnance.pdf', $consultation->id) }}" 
                                            class="btn btn-sm btn-success" 
                                            target="_blank">
                                            📄 Voir l'ordonnance
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucune consultation trouvée pour ce patient.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{ route('medecin.patients.index') }}" class="btn btn-secondary">
                ← Retour à la liste des patients
            </a>
            <a href="{{ route('medecin.consultations.create', $patient->id) }}" class="btn btn-primary">
                + Nouvelle consultation
            </a>
        </div>
    </div>
</div>
@endsection