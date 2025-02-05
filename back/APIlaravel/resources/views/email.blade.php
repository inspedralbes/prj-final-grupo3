<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject ?? 'Example App' }}</title>
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
            background-color: #e3e3e3; 
            border-radius: 8px; 
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); 
            text-align: center;
        }
 
 
        h4 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #58C4DC; 
            margin-bottom: 20px;
        }
 
 
        p {
            margin-bottom: 15px;
            color: #555; 
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
    <h4>{{ $subject ?? 'Example App' }}</h4>
    <p>Bienvenido: <strong>{{ $name ?? 'User' }} {{$lastname ?? 'User' }}</strong></p>
    <p>Pulsa en el siguiente enlace para acceder al cuestionario:</p>
    <p>
        <a href="{{ $quizUrl ?? '#' }}" style="text-decoration: none; color: #58C4DC; font-weight: bold;"
           onmouseover="this.style.textDecoration='underline'"
           onmouseout="this.style.textDecoration='none'">
            Acceder al cuestionario
        </a>
    </p>
 
    <footer>
        <p>&copy; {{ date('Y') }} Example App. Todos los derechos reservados.</p>
    </footer>
</div>
</body>
</html>