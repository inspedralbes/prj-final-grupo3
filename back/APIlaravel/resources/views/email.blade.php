<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Benvingut a Triplan' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef4f8;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            color: #007BFF;
            margin-bottom: 10px;
        }

        h4 {
            font-size: 1.4rem;
            color: #007BFF;
            margin-bottom: 15px;
        }

        p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .footer {
            font-size: 0.8rem;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🌍 Descobreix el món amb Triplan!</h2>
    <h4>La teva pròxima aventura comença aquí</h4>
    <p>Hola, <strong>{{ $user['name'] ?? 'Viatger' }} {{ $user['surname'] }}</strong></p>
    
    <p>🎉 Gràcies per unir-te a Triplan! Ara pots explorar destinacions, descobrir activitats i crear records inoblidables. 🚀✈️</p>

    <a href="{{ env('API_URL') }}/login" class="btn">Accedeix a Triplan</a>

    <p class="footer">&copy; {{ date('Y') }} Triplan App. Tots els drets reservats.</p>
</div>
</body>
</html>