@extends('layouts.app')

@section('content')
    <a href="/user/{{auth()->user()->id}}" class="btn btn-primary float-right"><i class="fas fa-undo fa-sm"></i> Back</a>
    <h2>Edit user {{auth()->user()->name}}</h2>
        <form method="post" action="/user/{{ $user->id }}" enctype="multipart/form-data" class="universe_form">
        {{ method_field('patch') }}
        @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-3"><label> User name: </label></div>
                    <div class="col-5"><input type="text" name="name" class="form-control" value="{{ $user->name}}" required/></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-3"><label> User email: </label></div>
                    <div class="col-5"><input type="email" name="email" class="form-control" value="{{ $user->email}}" required/></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                        <div class="col-3"><label> User image: </label></div>
                        <div class="col-5"><input type="file" name="image" id="userImg" class="form-control input_border_none" value="{{ $user->image}}" required/></div>
                </div>
                <div class="row">
                        <div class="col-3"></div>
                        <div class="col-4">
                            @if($user->image)                                              
                                <img class="img-fluid b_margin_top30" src="/images/users/{{ $user->image }}" />
                                <p class="text-center">Curent profile image</p>
                            @endif
                        </div>
                        <div class="col-1"></div>
                        <div class="col-4">                                            
                            <img class="img-fluid b_margin_top30" id="userImgShow" src="#" alt="" />
                            <p class="image_paragraph_new text-center"></p>
                        </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary float-right">Update</button>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        
                        reader.onload = function (e) {
                            $('#userImgShow').attr('src', e.target.result);
                            $('.image_paragraph_new').html('New picked picture');
                        }
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                
                $("#userImg").change(function(){
                    readURL(this);
                });
            });
        </script>  
@endsection