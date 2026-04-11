<!DOCTYPE html>
<html>
<head>
    <title>Annulation de rendez-vous</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f44336; color: white; padding: 10px; text-align: center; }
        .content { padding: 20px; border: 1px solid #ddd; }
        .footer { text-align: center; padding: 10px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Annulation de rendez-vous</h2>
        </div>
        <div class="content">
            <h3>Bonjour {{ $appointment->patient->name }},</h3>
            <p>Votre rendez-vous du <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y à H:i') }}</strong> a été <strong>annulé</strong>.</p>
            <p>Vous pouvez prendre un nouveau rendez-vous en contactant le secrétariat.</p>
            <p>Cordialement,<br>Cabinet Médical</p>
        </div>
        <div class="footer">
            <p>Ceci est un email automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>