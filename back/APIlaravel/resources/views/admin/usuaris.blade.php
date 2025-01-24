@extends('layout.index')

@section('content')
<div class="flex justify-center m-5">
    <table class="bg-white border-8 border-black min-w-[90%]">
        <thead class="bg-gray-800 text-white">
            <tr class="text-center">
                <th class="py-2 px-4 w-[5%]">ID</th>
                <th class="py-2 px-4 text-left w-[20%]">NOM</th>
                <th class="py-2 px-4 text-left w-[20%]">COGNOM</th>
                <th class="py-2 px-4">CORREU</th>
                <th class="py-2 px-4r w-[30%]"> ACCIÓ</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 bg-gray-100">
            @foreach($users as $user)
            <tr class="border-5 border-gray-200 text-center">
                <td class="py-2 px-4 border-5 border-gray-200">{{ $user->id }}</td>
                <td class="py-2 px-4 text-left">{{ $user->name }}</td>
                <td class="py-2 px-4 text-left">{{ $user->surname }}</td>
                <td class="py-2 px-4 border-r-5 border-gray-200">{{ $user->email }}</td>
                <td class="py-2 px-4 flex flex-row justify-center gap-2">
                    <button class="rounded-full bg-green-500 p-2 text-white cursor-pointer">Veure mes detalls</button>
                    <button class="rounded-full bg-orange-500 p-2 text-white cursor-pointer">Modificar</button>
                    <button class="rounded-full bg-red-500 p-2 text-white cursor-pointer">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection