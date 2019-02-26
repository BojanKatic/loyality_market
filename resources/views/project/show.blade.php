@extends('layout')
    @section('content')

        <h1>{{$project->title}}</h1>
        <p>{{$project->description}}</p>
        <a href="/projects/{{$project->id}}/edit"> Edit </a>
        @if($project->tasks->count())
        <div>
            <ul> 
                @foreach($project->tasks as $task)
                    <li>
                        <form method="post" action="/tasks/{{$task->id}}">
                        @method('patch')
                        @csrf
                            <label for="checkbox" class="checkbox">
                                <input type="checkbox" name="completed" onChange="this.form.submit()" {{$task->completed ? 'checked' : ''}}/>
                            <label>
                        </form>
                            {{ $task->description }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
            <form method="post" action="/projects/{{$project->id}}/task">
            @csrf
                <label> Novi zadatak</label>
                <input type="text" name="description" />
                <button type="submit" class="btn btn-primary">Dodaj </button>
            </form>
            @include('layouts.error')
    @endsection