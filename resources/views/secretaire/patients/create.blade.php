@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-success text-white py-3" style="border-radius: 20px 20px 0 0;">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i> Inscrire un nouveau Patient</h4>
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

                    <form action="{{ route('secretaire.patients.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-user me-1 text-success"></i> Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" placeholder="Nom du patient" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-user me-1 text-success"></i> Prénom</label>
                                <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" placeholder="Prénom du patient" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-id-card me-1 text-success"></i> CIN</label>
                                <input type="text" name="cin" class="form-control" value="{{ old('cin') }}" placeholder="Numéro de CIN" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-calendar-alt me-1 text-success"></i> Date de Naissance</label>
                                <input type="date" name="date_naissance" id="date_naissance" class="form-control" value="{{ old('date_naissance') }}" required>
                            </div>
                            <script>
   
                               var today = new Date().toISOString().split('T')[0];
    
                              document.getElementById('date_naissance').setAttribute('max', today);
                            </script>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fas fa-phone me-1 text-success"></i> Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="06XXXXXXXX" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="fas fa-envelope me-1 text-success"></i> Email (Optionnel)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="patient@example.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold"><i class="fas fa-venus-mars me-1 text-success"></i> Sexe</label>
                            <select name="sexe" class="form-select" required>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('secretaire.dashboard') }}" class="btn btn-outline-secondary px-4">Retour</a>
                            <button type="submit" class="btn btn-success px-5 shadow-sm fw-bold">Enregistrer le Patient</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection