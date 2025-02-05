@extends('layout.index')

@section('content')
    <div class="budget-info">
        <p class="text-xl font-bold">BUDGET</p>
        <div class="flex gap-10">
            <p>Pressupost min: {{ $travel->budget->min_budget }}€</p>
            <p>Pressupost max: {{ $travel->budget->max_budget }}€</p>
            <p>Precio final: {{ $travel->budget->final_price }}€</p>
        </div>
    </div>
    <div class="box">
        <div class="ticket">
            <span class="absolute text-2xl font-bold font-['Arial'] text-blue-950 top-1.5 left-3">TRIPLAN</span>
            <span class="absolute text-sm font-bold font-['Arial'] text-blue-950 top-1.5 right-3">VIATGE
                #{{ $travel->id }}</span>
            <span class="absolute text-xl font-['Arial'] text-gray-100 left-50 top-1.5">Informació del viatge</span>
            <div class="content">
                <span class="jfk">{{ strtoupper(substr($travel->user->name, 0, 3)) }}</span>
                <span class="absolute left-27 top-1">
                    <img src="{{ asset('icons/plane.svg') }}" alt="" class="w-15 h-15">
                </span>
                <span class="sfo">{{ $travel->country->code }}</span>
                {{-- Desti --}}

                <span class="jfk jfkslip">{{ strtoupper(substr($travel->user->name, 0, 3)) }}</span>
                <span class="absolute right-20 top-5">
                    <img src="{{ asset('icons/plane.svg') }}" alt="" class="w-10 h-10">
                </span>
                <span class="sfo sfoslip">{{ $travel->country->code }}</span>
                <div class="sub-content">
                    <span class="watermark">TriPlan</span>
                    <span class="absolute font-mono text-sm top-2 left-3 text-gray-500 font-bold" style="width: 12vh; word-wrap: break-word;">NOM USUARI<br><span
                            class="font-[Arial] text-base text-black">{{ $travel->user->surname }},
                            {{ $travel->user->name }}</span></span>
                    <span class="absolute font-mono text-sm top-2 left-35 text-gray-500 font-bold">MOVILITAT<br><span
                            class="font-[Arial] text-black">{{ strtoupper($travel->movility->type) }}</span></span>
                    <span class="absolute font-mono text-sm top-2 left-60 text-gray-500 font-bold">DESTÍ<br><span
                            class="font-[Arial] text-black">{{ $travel->country->name }}</span></span>
                    <span class="absolute font-mono text-sm top-2 left-80 text-gray-500 font-bold"># DIES<br><span
                            class="font-[Arial] text-black">{{ $travel->qunt_date }}</span></span>
                    <span class="absolute font-mono text-sm top-18 left-3 text-gray-500 font-bold">DATA:
                        <span class="font-[Arial] text-black">{{ $travel->date_init }} fins a
                            {{ $travel->date_end }}</span>
                    </span>

                    {{-- <span class="absolute font-mono text-sm top-14 left-3 text-gray-500">
                        BUDGET
                        <span></span>
                        <span></span>
                        <span></span>
                    </span> --}}
                    {{-- <span class="font-mono text-sm">BUDGET<span></span></span> --}}
                    <span class="absolute font-mono text-sm top-2 right-33 text-gray-500 font-bold">PAIS<br><span
                            class="font-[Arial] text-black">{{ $travel->country->name }}</span></span>
                    <span class="absolute font-mono text-sm top-2 right-5 text-gray-500 font-bold">ID PAIS<br><span
                            class="font-[Arial] text-black">{{ $travel->country->id }}</span></span>
                    <span class="absolute font-mono text-sm top-13 right-25 text-gray-500 font-bold">NOM USUARI</span>
                    <span
                        class="absolute text-sm top-18 left-104 font-bold font-[Arial] text-black">{{ $travel->user->surname }},
                        {{ $travel->user->name }}</span></span>
                </div>
            </div>
            <span class="absolute font-mono text-sm bottom-2 left-30 text-gray-100 font-bold">Data de creació: <span
                    class="font-[Arial]">{{ $travel->created_at->format('H:i d/m/Y') }}</span></span>
            <div class="barcode"></div>
            <div class="barcode slip"></div>
        </div>
    </div>
    <div class="description">
        <p class="text-xl font-bold">Descipció</p>
        <div class="flex gap-10">
            <p>{{ $travel->description }}</p>
        </div>
    </div>
    <button id="close-form" class="absolute bottom-30 left-0 right-0 flex items-center justify-center">
        <img src="{{ asset('icons/close_icon.svg') }}" alt="Cerrar" class="w-15 h-15 duration-300 hover:rotate-180 hover:scale-120">
    </button>

    <script>
        document.getElementById('close-form').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/travels';
        });
    </script>

    <style>
        .budget-info {
            position: absolute;
            top: calc(45% - 180px);
            /* Ajusta la posición según sea necesario */
            left: calc(50% - 300px);
            width: 600px;
            background: #FFB300;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .box {
            position: absolute;
            top: calc(50% - 125px);
            top: -webkit-calc(50% - 125px);
            left: calc(50% - 300px);
            left: -webkit-calc(50% - 300px);
        }

        .description {
            position: absolute;
            bottom: calc(45% - 180px);
            /* Ajusta la posición según sea necesario */
            left: calc(50% - 300px);
            width: 600px;
            background: #FFB300;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .ticket {
            width: 600px;
            height: 250px;
            background: #FFB300;
            border-radius: 3px;
            box-shadow: 0 0 50px #aaa;
            border-top: 1px solid #E89F3D;
            border-bottom: 1px solid #E89F3D;
        }

        .ticket:after {
            content: '';
            position: absolute;
            right: 200px;
            top: 0px;
            width: 2px;
            height: 250px;
            box-shadow: inset 0 0 0 #FFB300,
                inset 0 -10px 0 #B56E0A,
                inset 0 -20px 0 #FFB300,
                inset 0 -30px 0 #B56E0A,
                inset 0 -40px 0 #FFB300,
                inset 0 -50px 0 #999999,
                inset 0 -60px 0 #E5E5E5,
                inset 0 -70px 0 #999999,
                inset 0 -80px 0 #E5E5E5,
                inset 0 -90px 0 #999999,
                inset 0 -100px 0 #E5E5E5,
                inset 0 -110px 0 #999999,
                inset 0 -120px 0 #E5E5E5,
                inset 0 -130px 0 #999999,
                inset 0 -140px 0 #E5E5E5,
                inset 0 -150px 0 #B0B0B0,
                inset 0 -160px 0 #EEEEEE,
                inset 0 -170px 0 #B0B0B0,
                inset 0 -180px 0 #EEEEEE,
                inset 0 -190px 0 #B0B0B0,
                inset 0 -200px 0 #EEEEEE,
                inset 0 -210px 0 #B0B0B0,
                inset 0 -220px 0 #FFB300,
                inset 0 -230px 0 #B56E0A,
                inset 0 -240px 0 #FFB300,
                inset 0 -250px 0 #B56E0A;
        }

        .content {
            position: absolute;
            top: 40px;
            width: 100%;
            height: 170px;
            background: #eee;
        }

        .airline {
            position: absolute;
            top: 10px;
            left: 10px;
            font-family: Arial;
            font-size: 20px;
            font-weight: bold;
            color: rgba(0, 0, 102, 1);
        }

        .boarding {
            position: absolute;
            top: 10px;
            right: 220px;
            font-family: Arial;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.6);
        }

        .jfk {
            position: absolute;
            top: 10px;
            left: 20px;
            font-family: Arial;
            font-size: 38px;
            color: #222;
        }

        .sfo {
            position: absolute;
            top: 10px;
            left: 180px;
            font-family: Arial;
            font-size: 38px;
            color: #222;
        }

        .plane {
            position: absolute;
            left: 105px;
            top: 0px;
        }

        .sub-content {
            background: #e5e5e5;
            width: 100%;
            height: 100px;
            position: absolute;
            top: 70px;
        }

        .watermark {
            position: absolute;
            left: 5px;
            top: -10px;
            font-family: Arial;
            font-size: 110px;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.2);
        }

        .name {
            position: absolute;
            top: 10px;
            left: 10px;
            font-family: Arial Narrow, Arial;
            font-weight: bold;
            font-size: 14px;
            color: #999;
        }

        .name span {
            color: #555;
            font-size: 17px;
        }

        .flight {
            position: absolute;
            top: 10px;
            left: 180px;
            font-family: Arial Narrow, Arial;
            font-weight: bold;
            font-size: 14px;
            color: #999;
        }

        .flight span {
            color: #555;
            font-size: 17px;
        }

        .gate {
            position: absolute;
            top: 10px;
            left: 280px;
            font-family: Arial Narrow, Arial;
            font-weight: bold;
            font-size: 14px;
            color: #999;
        }

        .gate span {
            color: #555;
            font-size: 17px;
        }


        .seat {
            position: absolute;
            top: 10px;
            left: 350px;
            font-family: Arial Narrow, Arial;
            font-weight: bold;
            font-size: 14px;
            color: #999;
        }

        .seat span {
            color: #555;
            font-size: 17px;
        }

        .boardingtime {
            position: absolute;
            top: 60px;
            left: 10px;
            font-family: Arial Narrow, Arial;
            font-weight: bold;
            font-size: 14px;
            color: #999;
        }

        .boardingtime span {
            color: #555;
            font-size: 17px;
        }

        .barcode {
            position: absolute;
            left: 8px;
            bottom: 6px;
            height: 30px;
            width: 90px;
            background: #222;
            box-shadow: inset 0 1px 0 #FFB300, inset -2px 0 0 #FFB300,
                inset -4px 0 0 #222,
                inset -5px 0 0 #FFB300,
                inset -6px 0 0 #222,
                inset -9px 0 0 #FFB300,
                inset -12px 0 0 #222,
                inset -13px 0 0 #FFB300,
                inset -14px 0 0 #222,
                inset -15px 0 0 #FFB300,
                inset -16px 0 0 #222,
                inset -17px 0 0 #FFB300,
                inset -19px 0 0 #222,
                inset -20px 0 0 #FFB300,
                inset -23px 0 0 #222,
                inset -25px 0 0 #FFB300,
                inset -26px 0 0 #222,
                inset -26px 0 0 #FFB300,
                inset -27px 0 0 #222,
                inset -30px 0 0 #FFB300,
                inset -31px 0 0 #222,
                inset -33px 0 0 #FFB300,
                inset -35px 0 0 #222,
                inset -37px 0 0 #FFB300,
                inset -40px 0 0 #222,
                inset -43px 0 0 #FFB300,
                inset -44px 0 0 #222,
                inset -45px 0 0 #FFB300,
                inset -46px 0 0 #222,
                inset -48px 0 0 #FFB300,
                inset -49px 0 0 #222,
                inset -50px 0 0 #FFB300,
                inset -52px 0 0 #222,
                inset -54px 0 0 #FFB300,
                inset -55px 0 0 #222,
                inset -57px 0 0 #FFB300,
                inset -59px 0 0 #222,
                inset -61px 0 0 #FFB300,
                inset -64px 0 0 #222,
                inset -66px 0 0 #FFB300,
                inset -67px 0 0 #222,
                inset -68px 0 0 #FFB300,
                inset -69px 0 0 #222,
                inset -71px 0 0 #FFB300,
                inset -72px 0 0 #222,
                inset -73px 0 0 #FFB300,
                inset -75px 0 0 #222,
                inset -77px 0 0 #FFB300,
                inset -80px 0 0 #222,
                inset -82px 0 0 #FFB300,
                inset -83px 0 0 #222,
                inset -84px 0 0 #FFB300,
                inset -86px 0 0 #222,
                inset -88px 0 0 #FFB300,
                inset -89px 0 0 #222,
                inset -90px 0 0 #FFB300;
        }

        .slip {
            left: 455px;
        }

        .nameslip {
            top: 60px;
            left: 410px;
        }

        .flightslip {
            left: 410px;
        }

        .seatslip {
            left: 540px;
        }

        .jfkslip {
            font-size: 30px;
            top: 20px;
            left: 410px;
        }

        .sfoslip {
            font-size: 30px;
            top: 20px;
            left: 530px;
        }

        .planeslip {
            top: 10px;
            left: 475px;
        }

        .airlineslip {
            left: 455px;
        }
    </style>
@endsection
