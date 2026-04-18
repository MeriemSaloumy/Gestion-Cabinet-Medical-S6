@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4 class="mb-0">Ajouter un Nouveau Patient</h4>
            <a href="{{ route('medecin.patients.index') }}" class="btn btn-light btn-sm">Retour</a>
        </div>
        <div class="card-body">
            <form action="{{ route('medecin.patients.store') }}" method="POST">
                @csrf {{-- Protection obligatoire --}}
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nom du patient" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" placeholder="Prénom du patient" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">CIN</label>
                        <input type="text" name="cin" class="form-control" placeholder="Ex: AB123456" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" placeholder="06..." required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de Naissance</label>
                        <input type="date" name="date_naissance" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="adresse" class="form-control" rows="2" placeholder="Adresse complète..."></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success w-100">Enregistrer le Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection