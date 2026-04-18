<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .doctor-name { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .patient-info { margin-top: 30px; }
        .content { margin-top: 50px; min-height: 300px; font-size: 18px; line-height: 1.6; }
        .footer { margin-top: 50px; text-align: right; }
        .date { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="doctor-name">Dr. {{ auth()->user()->name }}</div>
        <div>Médecine Générale</div>
        <div>Contact: 05XXXXXXXX</div>
    </div>

    <div class="date">
        Fait à Le {{ date('d/m/Y') }}
    </div>

    <div class="patient-info">
        <strong>Patient :</strong> {{ $consultation->patient->nom }} {{ $consultation->patient->prenom }} <br>
        <strong>Âge :</strong> {{ \Carbon\Carbon::parse($consultation->patient->date_naissance)->age }} ans
    </div>

    <div class="content">
        <h3 style="text-decoration: underline;">ORDONNANCE :</h3>
        <p>{!! nl2br(e($consultation->ordonnance)) !!}</p>
    </div>

    <div class="footer">
        <p><em>Signature et Cachet</em></p>
        <div style="margin-top: 60px;">_______________________</div>
    </div>
</body>
</html>