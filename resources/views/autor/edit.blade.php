@extends('layout')

@section('title', 'Editar Autor')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Editar Autor</h1>
<a href="{{ route('autor_list') }}">&laquo; Torna</a>
<div style="margin-top: 20px">
    <form method="POST" enctype="multipart/form-data" action="{{ route('autor_edit', ['id' => $autor->id]) }}">
        @csrf
        <div>
            <label for="nom">Nom</label>
            <input type="text" name="nom" value="{{ $autor->nom }}" />
        </div>
        <div>
            <label for="cognoms">Cognoms</label>
            <input type="text" name="cognoms" value="{{ $autor->cognoms }}" />
        </div>
        @isset($autor->imatge)
        <div>
            <p> Imatge actual: <b> {{ $autor->imatge }} </b> </p>
        </div>
        <div>
            <label for="borrarImatge">Borrar imatge</label>
            <input type="checkbox" name="borrarImatge">
        </div>
        @endisset
        <div>
            <label for="imatge">Imatge</label>
            <input type="file" name="imatge"/>
        </div>

       
        <button type="submit">Desar</button>
    </form>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
</div>
@endsection