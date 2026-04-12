<style>
    body { font-family: sans-serif; }
    .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 30px; }
    .content { margin-top: 20px; }
    .date { text-align: right; }
</style>

<div class="header">
    <h1>ORDONNANCE MÉDICALE</h1>
    <p>Cabinet Médical S6 - Dr. {{ Auth::user()->name ?? 'Consultant' }}</p>
</div>

<div class="date">Fait le : {{ $consultation->created_at->format('d/m/Y') }}</div>

<div class="content">
    <p><strong>Patient :</strong> {{ $consultation->patient->nom }} {{ $consultation->patient->prenom }}</p>
    <p><strong>Diagnostic :</strong> {{ $consultation->diagnostic }}</p>
    <hr>
    <h3>Prescription / Notes :</h3>
    <p>{{ $consultation->compte_rendu }}</p>
</div>