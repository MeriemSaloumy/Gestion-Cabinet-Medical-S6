<h3>Dossier de : {{ $patient->nom }} {{ $patient->prenom }}</h3>
<hr>

<div class="timeline">
    @forelse($patient->consultations as $consultation)
        <div class="card mb-3 border-left-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="text-primary">Consultation du {{ $consultation->created_at->format('d/m/Y') }}</h5>
                    <span class="badge bg-secondary">Dr. {{ $consultation->user->name }}</span>
                </div>
                <p><strong>Diagnostic :</strong> {{ $consultation->diagnostic }}</p>
                <p><strong>Notes :</strong> {{ $consultation->compte_rendu }}</p>
                
                <div class="text-end">
                    <a href="{{ route('consultations.pdf', $consultation->id) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Télécharger l'Ordonnance
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center">Aucun historique pour ce patient.</p>
    @endforelse
</div>
