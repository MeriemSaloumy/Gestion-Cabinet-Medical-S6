@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="fas fa-notes-medical me-2"></i>Nouvelle Consultation : {{ $patient->nom }} {{ $patient->prenom }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('medecin.consultations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tension Artérielle</label>
                                <input type="text" name="tension" class="form-control" placeholder="ex: 12/8">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Poids (kg)</label>
                                <input type="number" step="0.1" name="poids" class="form-control" placeholder="ex: 75.5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Diagnostic <span class="text-danger">*</span></label>
                            <textarea name="diagnostic" class="form-control" rows="2" required placeholder="Le problème principal..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Compte Rendu / Observations <span class="text-danger">*</span></label>
                            <textarea name="compte_rendu" class="form-control" rows="4" required placeholder="Détails de l'examen..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ordonnance <span class="text-danger">*</span></label>
                            <textarea name="ordonnance" class="form-control" rows="5" required placeholder="Liste des médicaments et posologie..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('medecin.dashboard') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-success px-5">
                                <i class="fas fa-save me-2"></i>Enregistrer la consultation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection