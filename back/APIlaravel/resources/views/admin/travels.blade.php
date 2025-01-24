@extends('layout.index')

@section('content')
<div class="flex justify-center m-5">
    <table class="bg-white border-8 border-black min-w-[90%]">
        <thead class="bg-gray-800 text-white">
            <tr class="text-center">
                <th class="py-2 px-4 w-[5%]">ID</th>
                <th class="py-2 px-4 text-left w-[40%]">NOM</th>
                <th class="py-2 px-4 w-[10%]">CODI</th>
                <th class="py-2 px-4r w-[20%]"> ACCIÓ</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 bg-gray-100">
            @foreach($countries as $country)
            <tr class="border-5 border-gray-200 text-center">
                <td class="py-2 px-4 border-5 border-gray-200">{{ $country->id }}</td>
                <td class="py-2 px-4 text-left">{{ $country->name }}</td>
                <td class="py-2 px-4 border-r-5 border-gray-200">{{ $country->code }}</td>
                <td class="py-2 px-4 flex flex-row justify-center gap-2">
                    <button class="rounded-full bg-blue-800 p-2 text-white cursor-pointer">Modificar</button>
                    <button class="rounded-full bg-red-500 p-2 text-white cursor-pointer">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection