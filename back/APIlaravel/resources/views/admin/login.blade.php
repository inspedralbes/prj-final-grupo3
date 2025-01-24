@extends('layout.index')

@section('content')
<div class="login-container shadow-lg rounded-lg p-10 w-2xs">
    <p class="text-2xl font-bold text-center mb-4">Admin | Login</p>
    <form action="" class="flex flex-col gap-4">
        <label for="username" class="font-medium">Username</label>
        <input type="text" name="username" id="username" class="w-full p-2 border rounded-md">
        <label for="password" class="font-medium">Password</label>
        <input type="password" name="password" id="password" class="w-full p-2 border rounded-md">
        <button type="submit" class="border-solid text-black p-2 rounded-md bg-blue-500 hover:bg-blue-700 hover:text-white">
            Iniciar sesión
        </button>
    </form>
</div>
@endsection