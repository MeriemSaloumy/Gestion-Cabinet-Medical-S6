@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('medecin.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Retour au Dashboard
        </a>
        <button onclick="window.print()" class="btn btn-dark">
            <i class="fas fa-print me-2"></i>Imprimer l'Ordonnance
        </button>
    </div>

    <div class="card shadow border-0 mx-auto" style="max-width: 800px; min-height: 1000px;" id="ordonnance-card">
        <div class="card-body p-5">
            <div class="row border-bottom pb-4 mb-5">
                <div class="col-6">
                    <h3 class="text-uppercase fw-bold text-primary">Dr. {{ Auth::user()->name }}</h3>
                    <p class="mb-0 text-muted">Médecine Générale / Spécialisée</p>
                    <p class="mb-0 text-muted">Contact : {{ Auth::user()->email }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-0">Fait à le : <strong>{{ $consultation->created_at->format('d/m/Y') }}</strong></p>
                </div>
            </div>

            <div class="mb-5">
                <h5 class="mb-3">Patient : <strong>{{ $consultation->patient->name }} </strong></h5>
                @if($consultation->tension || $consultation->poids)
                    <p class="text-muted small">
                        @if($consultation->tension) Tension : {{ $consultation->tension }} | @endif
                        @if($consultation->poids) Poids : {{ $consultation->poids }} kg @endif
                    </p>
                @endif
            </div>

            <div class="ordonnance-content" style="min-height: 400px;">
                <h4 class="text-center text-decoration-underline mb-4">ORDONNANCE</h4>
                <div style="font-size: 1.2rem; line-height: 1.8; white-space: pre-line;">
                    {{ $consultation->ordonnance }}
                </div>
            </div>

            <div class="mt-5 pt-5 text-end">
                <div class="d-inline-block text-center" style="border-top: 1px solid #dee2e6; min-width: 200px;">
                    <p class="mt-2">Signature et Cachet</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .card { border: none !important; box-shadow: none !important; }
        .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
    }
</style>
@endsection