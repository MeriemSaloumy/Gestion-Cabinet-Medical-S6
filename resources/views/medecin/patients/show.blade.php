@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h5 class="fw-bold mb-4"><i class="fas fa-history text-danger me-2"></i>Historique des Visites</h5>
            
            @forelse($patient->consultations as $cons)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold text-danger">Consultation du {{ $cons->created_at->format('d/m/Y') }}</h6>
                        <span class="badge bg-light text-dark border">Diagnostic: {{ $cons->diagnostic }}</span>
                    </div>
                    
                    <p class="mb-1 text-muted small"><strong>Observations :</strong> {{ $cons->observations }}</p>

                    <div class="bg-light p-3 rounded mt-2 d-flex justify-content-between align-items-center border">
                        <div>
                            <p class="mb-0 text-dark small"><strong>Prescription :</strong> {{ $cons->ordonnance }}</p>
                        </div>
                        <a href="{{ route('medecin.ordonnance.pdf', $cons->id) }}" class="btn btn-sm btn-outline-dark shadow-sm">
                            <i class="fas fa-print me-1"></i> Imprimer l'ordonnance
                        </a>
                    </div>
                    </div>
            </div>
            @empty
            <div class="text-center py-5 bg-white rounded shadow-sm">
                <p class="text-muted mb-0">Aucun historique médical pour ce patient.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection