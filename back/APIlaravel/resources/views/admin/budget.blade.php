@extends('layout.index')

@section('content')
    <div class="flex flex-col justify-center m-5 gap-5 mb-20">
        {{-- <div class="flex justify-end" id="toggle-form">
    <p class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer"
        id="register-button">Afegir tipus de viatge</p>
</div> --}}

        {{-- <div id="register-form" class="hidden">
        @include('admin.travel-type-register')
    </div> --}}

        <div class="overflow-x-auto bg-white shadow-md rounded-lg max-w-[1000px] mx-auto">
            <table class="w-full min-w-[70vh] border border-gray-300">
                <thead class="bg-gray-800 text-white text-sm md:text-base">
                    <tr class="text-center">
                        <th class="py-2 px-4 w-[5%]">ID</th>
                        <th class="py-2 px-4 w-[30%]">MINIM BUDGET</th>
                        <th class="py-2 px-4 w-[30%]">MAXIM BUDGET</th>
                        <th class="py-2 px-4 w-[30%]">FINAL PRICE</th>
                        {{-- <th class="py-2 px-4 w-[10%]">ACCIÓ</th> --}}
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-gray-100 text-sm md:text-base">
                    @foreach ($budgets as $budget)
                        <tr class="border-b border-gray-300 text-center">
                            <td class="py-2 px-4 break-words">{{ $budget->id }}</td>
                            <td class="py-2 px-4 break-words">{{ $budget->min_budget }}</td>
                            <td class="py-2 px-4 break-words">{{ $budget->max_budget }}</td>
                            <td class="py-2 px-4 break-words">{{ $budget->final_price }}</td>
                            {{-- <td class="py-2 px-4">
                        <div class="flex flex-nowrap justify-center gap-2">
                            <button
                                class="rounded-full bg-orange-500 px-2 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                onclick="editCountry('{{ $country->id }}')">
                                Modificar
                            </button>
                            <button class="rounded-full bg-orange-500 p-2 text-white md:hidden"
                                onclick="editCountry('{{ $country->id }}')">
                                <img src="{{ asset('icons/edit.svg') }}" alt="Editar" class="w-5 h-5">
                            </button>
                            <button
                                class="rounded-full bg-red-500 px-2 py-1 text-white text-xs md:text-sm hidden md:inline-block"
                                onclick="deleteType('{{ $traveltype->id }}')">
                                Eliminar
                            </button>
                            <button class="rounded-full bg-red-500 p-2 text-white md:hidden"
                                onclick="deleteCountry('{{ $country->id }}')">
                                <img src="{{ asset('icons/delete.svg') }}" alt="Eliminar" class="w-5 h-5">
                            </button>
                        </div>
                    </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
