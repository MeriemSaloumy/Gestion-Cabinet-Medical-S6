<div class="card shadow">
    <div class="card-header bg-success text-white">
        Nouvelle Consultation : {{ $patient->nom }}
    </div>
    <div class="card-body">
        <form action="{{ route('consultations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            
            <div class="mb-3">
                <label class="form-label">Diagnostic</label>
                <input type="text" name="diagnostic" class="form-control" placeholder="Ex: Grippe saisonnière" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Compte-rendu (Notes)</label>
                <textarea name="compte_rendu" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Enregistrer la consultation</button>
        </form>
    </div>
</div>