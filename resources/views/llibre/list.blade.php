@extends('layout')

@section('title', 'Llistat de llibres')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Llistat de llibres</h1>
    @if(Auth::check())
        <a href="{{ route('llibre_new') }}">+ Nou llibre</a>
    @endif

    @if (session('status'))
        <div>
            <strong>Success!</strong> {{ session('status') }}  
        </div>
    @endif

    <table style="margin-top: 20px;margin-bottom: 10px;">
        <thead>
            <tr>
                <th>Títol</th><th>Data de publicació</th><th>Vendes</th><th>Autor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($llibres as $llibre)
                <tr>
                    <td>{{ $llibre->titol }}</td><td>{{ $llibre->dataP->format('d-m-Y') }}</td><td>{{ $llibre->vendes }}</td><td>@isset($llibre->autor_id){{ $llibre->autor->nomCognoms() }} @endisset</td>
                    @if(Auth::check())
                        <td>
                            <a href="{{ route('llibre_edit', ['id' => $llibre->id]) }}">Editar</a>
                            <a href="{{ route('llibre_delete', ['id' => $llibre->id]) }}">Eliminar</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
@endsection