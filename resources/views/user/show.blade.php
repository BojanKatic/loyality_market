@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-8">
            <p><strong>Username:</strong> {{ $user->name }}</p>
            <p><strong>E-mail:</strong> {{ $user->email }}</p> 
        </div>
        <div class="col-4">
            @if($user->image)
                <img class="img-fluid" src="/images/users/{{ $user->image }}" />
            @endif
        </div>
    </div>
    <a href="/user/{{auth()->user()->id}}/edit" class="btn btn-primary text-right"><i class="fas fa-user-edit"></i> Edit profil</a>
<hr/>

@endsection