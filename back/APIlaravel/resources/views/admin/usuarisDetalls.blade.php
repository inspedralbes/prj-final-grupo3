@extend('layout.index')

@section('content')
<div>
    <h1>Detalls de l'usuari</h1>
    <p>ID: {{ $user->id }}</p>
    <p>Nom: {{ $user->name }}</p>
    <p>Cognom: {{ $user->created_at }}</p>
    <p>Correu: {{ $user->email }}</p>
    <p>Correu alternatiu: {{ $user->email }}</p>
    <p>Conrasenya: {{ $user->password }}</p>
    <p>Phone number: {{ $user->created_at }}</p>
    <p>Created at: {{ $user->created_at }}</p>
    <p>Created at: {{ $user->created_at }}</p>
    <p>Created at: {{ $user->created_at }}</p>
</div>
@endsection