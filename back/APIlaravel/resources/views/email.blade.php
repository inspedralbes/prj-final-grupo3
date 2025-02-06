<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Bienvenido a Triplan' }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F4F4F4;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h4 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007BFF;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 15px;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        footer {
            margin-top: 30px;
            font-size: 0.875rem;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h4>Triplan</h4>
    <p>Bienvenido: <strong>{{ $name ?? 'User' }} {{$lastname ?? 'User' }}</strong></p>

    <!-- Recuperar variable de la URL del front del .env API_URL -->
    <p>
        
    </p>

    <footer>
        <p>&copy; {{ date('Y') }} Triplan App. Todos los derechos reservados.</p>
    </footer>
</div>
</body>
</html>