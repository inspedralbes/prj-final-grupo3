<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>El teu pla de viatge</title>
</head>
<body>
    <h2>Hola {{ $user->name }},</h2>

    <p>Ja tens preparat el teu pla de viatge! T'adjuntem un PDF amb tota la planificació.</p>

    <p><strong>Títol:</strong> {{ $planning['viatge']['titol'] ?? 'Sense títol' }}</p>
    <p><strong>Preu estimat:</strong> {{ $planning['viatge']['preuTotal'] ?? 'No disponible' }} €</p>
    <p><strong>Dies:</strong> {{ count($planning['viatge']['dies'] ?? []) }}</p>

    <p>Bon viatge! 🌍</p>
</body>
</html>
