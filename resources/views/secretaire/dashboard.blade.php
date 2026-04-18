
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Tableau de Bord - Secrétariat</h2>
            <p class="text-muted">Bienvenue, voici le résumé de l'activité du cabinet aujourd'hui.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('secretaire.appointments.index', ['filter' => 'today']) }}" class="text-decoration-none card-hover-effect">
                <div class="card border-0 shadow-sm bg-primary text-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9;">Rendez-vous du jour</h6>
                                <h2 class="mb-0 fw-bold">{{ $countToday ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('secretaire.patients.index') }}" class="text-decoration-none card-hover-effect">
                <div class="card border-0 shadow-sm bg-success text-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9;">Total Patients</h6>
                                <h2 class="mb-0 fw-bold">{{ $countPatients ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('secretaire.patients.index', ['filter' => 'month']) }}" class="text-decoration-none card-hover-effect">
                <div class="card border-0 shadow-sm bg-info text-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.9;">Nouveaux ce mois</h6>
                                <h2 class="mb-0 fw-bold">{{ $countMonth ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-user-plus fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white font-weight-bold border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fas fa-bolt text-warning me-2"></i>Actions Rapides</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('secretaire.appointments.create') }}" class="btn btn-outline-primary p-3 text-start shadow-sm btn-action">
                            <i class="fas fa-plus-circle me-2 text-primary"></i> Prendre un nouveau Rendez-vous
                        </a>
                        <a href="{{ route('secretaire.patients.create') }}" class="btn btn-outline-success p-3 text-start shadow-sm btn-action">
                            <i class="fas fa-user-plus me-2 text-success"></i> Inscrire un nouveau Patient
                        </a>
                        <a href="{{ route('secretaire.patients.index') }}" ...>

                        <a href="#" ...>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm text-center p-5 bg-light border-0 h-100 d-flex align-items-center justify-content-center" style="border-radius: 15px;">
                <div class="opacity-75">
                    <i class="fas fa-tasks fa-3x mb-3 text-secondary"></i>
                    <h5 class="text-dark fw-bold">Prête pour demain ?</h5>
                    <p class="mb-0 text-muted">Vérifiez les rappels téléphoniques pour les patients attendus demain matin.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-hover-effect {
        transition: all 0.3s ease;
        display: block;
    }
    .card-hover-effect:hover {
        transform: translateY(-5px);
    }
    .card-hover-effect:hover .card {
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        filter: brightness(1.05);
    }
    .btn-action {
        border-radius: 12px;
        transition: all 0.2s;
        font-weight: 500;
    }
    .btn-action:hover {
        background-color: #f8f9fa !important;
        transform: translateX(5px);
    }
    .card {
        border-radius: 15px;
    }
</style>
@endsection