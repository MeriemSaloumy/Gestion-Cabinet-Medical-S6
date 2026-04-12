@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Prendre un rendez-vous</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('secretaire.appointments.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Patient *</label>
                            <select name="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un patient --</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->email }})</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Médecin *</label>
                            <select name="medecin_id" class="form-control @error('medecin_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un médecin --</option>
                                @foreach($medecins as $medecin)
                                <option value="{{ $medecin->id }}">Dr. {{ $medecin->name }}</option>
                                @endforeach
                            </select>
                            @error('medecin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Date et heure *</label>
                            <input type="datetime-local" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" required>
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Motif</label>
                            <input type="text" name="motif" class="form-control" placeholder="Consultation, suivi, urgence...">
                        </div>

                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Créer le rendez-vous</button>
                        <a href="{{ route('secretaire.appointments') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection