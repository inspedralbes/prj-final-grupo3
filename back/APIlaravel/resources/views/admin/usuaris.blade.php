@extends('layout.index')

@section('content')
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-2 px-4 text-left">ID</th>
                <th class="py-2 px-4 text-left">NOM</th>
                <th class="py-2 px-4 text-left">COGNOM</th>
                <th class="py-2 px-4 text-left">CORREU</th>
                <th></th>
                <th class="py-2 px-4 text-left"> ACCIÓ</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <tr class="border-b border-gray-200">
                <td class="py-2 px-4">1</td>
                <td class="py-2 px-4">Dato 1</td>
                <td class="py-2 px-4">Dato 2</td>
                <td class="py-2 px-4">Dato 3</td>
                <td class="py-2 px-4">
                    <button class="rounded-full bg-gray-800 p-2 text-white">Ver mes detalls</button>
                </td>
                <td class="py-2 px-4">
                    <button class="rounded-full bg-gray-800 p-2 text-white">Modificar</button>
                    <button class="rounded-full bg-gray-800 p-2 text-white">Eliminar</button>
                </td>
            </tr>
            <tr class="border-b border-gray-200">
                <td class="py-2 px-4">1</td>
                <td class="py-2 px-4">Dato 1</td>
                <td class="py-2 px-4">Dato 2</td>
                <td class="py-2 px-4">Dato 3</td>
                <td class="py-2 px-4">
                    <button class="rounded-full bg-gray-800 p-2 text-white">Ver mes detalls</button>
                </td>
                <td class="py-2 px-4">
                    <button class="rounded-full bg-gray-800 p-2 text-white">Modificar</button>
                    <button class="rounded-full bg-gray-800 p-2 text-white">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection