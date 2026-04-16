@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0 text-primary font-weight-bold">Tableau de Bord Médecin</h2>
                </div>
                <div class="card-body">
                    <h3 class="h4">Bienvenue Docteur {{ Auth::user()->name }} !</h3>
                    <p class="text-muted">Choisissez une action ci-dessous pour commencer.</p>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-primary shadow-sm">
                                <div class="card-body text-center">
                                    <div class="fs-1 mb-2">👥</div>
                                    <h5 class="card-title">Gestion des Patients</h5>
                                    <p class="card-text text-muted small">Consulter, ajouter ou modifier les dossiers patients.</p>
                                    <a href="{{ route('patients.index') }}" class="btn btn-primary">Accéder à la liste</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-success shadow-sm">
                                <div class="card-body text-center">
                                    <div class="fs-1 mb-2">🩺</div>
                                    <h5 class="card-title">Consultations</h5>
                                    <p class="card-text text-muted small">Effectuer un diagnostic et générer une ordonnance PDF.</p>
                                    <a href="{{ route('patients.index') }}" class="btn btn-success">Nouvelle Consultation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection