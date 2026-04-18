@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 20px 20px 0 0;">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i> 
                        Modifier le Patient : <span class="fw-light">{{ $patient->nom }} {{ $patient->prenom }}</span>
                    </h4>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('secretaire.patients.update', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{ old('nom', $patient->nom) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">Prénom</label>
                                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $patient->prenom) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">CIN</label>
                                <input type="text" name="cin" class="form-control" value="{{ old('cin', $patient->cin) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark text-danger">Date de Naissance</label>
                                <input type="date" name="date_naissance" id="date_naissance" 
                                       class="form-control" 
                                       value="{{ old('date_naissance', $patient->date_naissance) }}" 
                                       max="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $patient->telephone) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Sexe</label>
                            <select name="sexe" class="form-select" required>
                                <option value="M" {{ old('sexe', $patient->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe', $patient->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('secretaire.patients.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sécurité supplémentaire en JS pour bloquer les dates futures sur le calendrier
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('date_naissance').setAttribute('max', today);
</script>
@endsection