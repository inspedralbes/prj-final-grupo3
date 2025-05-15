<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>{{ $planning['viatge']['titol'] ?? 'Planificació del viatge' }}</title>
    <style>
        @page {
            margin: 40px 40px 60px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            position: relative;
        }

        header {
            position: fixed;
            top: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: right;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        .logo {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 60px;
        }

        h1, h2, h3 {
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        .day-title {
            margin-top: 30px;
            font-size: 18px;
        }

        .activity {
            margin-bottom: 15px;
        }

        .activity strong {
            display: block;
        }

        .no-activities {
            font-style: italic;
        }

        .price {
            color: #444;
        }
    </style>
</head>
<body>

    {{-- Header y Footer --}}
    <header>
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
    </header>

    <footer>
        Pla de viatge generat automàticament
    </footer>

    {{-- Portada --}}
    <h1>{{ $planning['viatge']['titol'] ?? 'Planificació del viatge' }}</h1>
    <h3>Preu total estimat: {{ $planning['viatge']['preuTotal'] ?? 'No disponible' }}€</h3>

    <div class="page-break"></div>

    {{-- Dies del viatge --}}
    @foreach ($planning['viatge']['dies'] ?? [] as $index => $dia)
        <h2 class="day-title">Dia {{ $index + 1 }}</h2>

        @if (!empty($dia['activitats']))
            @foreach ($dia['activitats'] as $act)
                <div class="activity">
                    <strong>{{ $act['horari'] ?? 'Sense horari' }} | {{ $act['nom'] ?? 'Activitat' }}</strong>
                    <div>{{ $act['descripcio'] ?? '' }}</div>
                    <div class="price">Preu: {{ $act['preu'] ?? 'Preu no disponible' }}</div>
                </div>
            @endforeach
        @else
            <div class="no-activities">No hi ha activitats definides per aquest dia.</div>
        @endif

        <div class="page-break"></div>
    @endforeach

</body>
</html>
