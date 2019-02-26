@extends('layout')

    @section('content')
    <h1>Edituj projekat !!</h1>

    <a href="/projects/{{$project->id}}">Nazad</a>
    
    <form method="post" action="/projects/{{$project->id}}">
        {{ method_field('patch') }}
        @csrf
        <input name="title" value="{{$project->title}}" required />
        <textarea name="description" required>{{$project->description}}</textarea>
        <button type="submit">Kreiraj</button>
    </form>
    <form method="post" action="/projects/{{$project->id}}">
        @method('delete')
        @csrf
        <button type="submit">Obrisi</button>
    </form>
    @endsection