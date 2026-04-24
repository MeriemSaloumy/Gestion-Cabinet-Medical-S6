@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="bi bi-calendar-plus me-2"></i> Prendre un nouveau Rendez-vous</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('secretaire.appointments.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">
                                    <i class="bi bi-person me-1"></i> Choisir le Patient
                                </label>
                                <select name="patient_id" class="form-select border-primary-subtle shadow-sm" required>
                                    <option value="">-- Sélectionner un patient --</option>
                                   
                                    @foreach($patients as $patient)
                                          <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">
                                    <i class="bi bi-person-badge me-1"></i> Choisir le Médecin
                                </label>
                                <select name="medecin_id" class="form-select border-primary-subtle shadow-sm" required>
                                    <option value="">-- Sélectionner un médecin --</option>
                                    @foreach($medecins as $medecin)
                                        <option value="{{ $medecin->id }}"> {{ $medecin->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">
                                <i class="bi bi-clock me-1"></i> Date et Heure du Rendez-vous
                            </label>
                            <input type="date" name="appointment_date" id="date_rdv" class="form-control" required>
                        </div>
                        <script>
                             today = new Date().toISOString().split('T')[0];
                             document.getElementById('date_rdv').setAttribute('min', today);
                        Q2</script>
                        

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">
                                <i class="bi bi-chat-left-text me-1"></i> Motif de la consultation
                            </label>
                            <textarea name="motif" rows="3" class="form-control border-primary-subtle shadow-sm" placeholder="Ex: Consultation de routine, urgence, etc."></textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('secretaire.appointments.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Confirmer le Rendez-vous
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    /* Personnalisation pour un look plus moderne */
    .card { border-radius: 20px !important; }
    .card-header { border-radius: 20px 20px 0 0 !important; }
    .form-select, .form-control {
        border-radius: 10px;
        padding: 0.75rem;
    }
    .form-select:focus, .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    .btn { border-radius: 10px; padding: 0.6rem 1.5rem; }
</style>
@endsection