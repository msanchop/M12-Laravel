@extends('layout')

@section('title', 'Llistat d\'autors')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Llistat d'autors</h1>
    @if(Auth::check())
        <a href="{{ route('autor_new') }}">+ Nou autor</a>
    @endif

    @if (session('status'))
        <div>
            <strong>Success!</strong> {{ session('status') }}  
        </div>
    @endif

    <table style="margin-top: 20px;margin-bottom: 10px;">
        <thead>
            <tr>
                <th>Nom</th><th>Cognoms</th><th>Imatge</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($autors as $autor)
                <tr>
                    <td>{{ $autor->nom }}</td><td>{{ $autor->cognoms }}</td>
                    <td><img src="{{ asset('uploads/imatges/' . $autor->imatge) }}" alt="" width="100px" height="100px"></td>
                        @if(Auth::check())
                            <td>
                                <a href="{{ route('autor_edit', ['id' => $autor->id]) }}">Editar</a>
                                <a href="{{ route('autor_delete', ['id' => $autor->id]) }}">Eliminar</a>
                            </td>
                        @endif     
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
@endsection