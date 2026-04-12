<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de rendez-vous</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4CAF50; color: white; padding: 10px; text-align: center; }
        .content { padding: 20px; border: 1px solid #ddd; }
        .footer { text-align: center; padding: 10px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Confirmation de rendez-vous</h2>
        </div>
        <div class="content">
            <h3>Bonjour {{ $patient->name }},</h3>
            <p>Votre rendez-vous a été confirmé :</p>
            <ul>
                <li><strong>Médecin :</strong> Dr. {{ $medecin->name }}</li>
                <li><strong>Date :</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</li>
                <li><strong>Heure :</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}</li>
                <li><strong>Motif :</strong> {{ $appointment->motif ?? 'Non spécifié' }}</li>
            </ul>
            <p>Pour toute modification ou annulation, veuillez contacter le secrétariat.</p>
            <p>Cordialement,<br>Cabinet Médical</p>
        </div>
        <div class="footer">
            <p>Ceci est un email automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>