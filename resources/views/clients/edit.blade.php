@extends('layouts.app')
    @section('content')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-5"><h4> Client <i class="fas fa-angle-double-right fa-xs"></i> Edit <i class="fas fa-angle-double-right fa-xs"></i> {{ $client->name}} </h4></div>
                        <div class="col-7"><a href="/clients" class="btn btn-primary float-right"><i class="fas fa-undo fa-sm"></i> Back</a></div>
                    </div>    
                </div>

                <div class="card-body">
                    <form method="post" action="/clients/{{ $client->id }}" enctype="multipart/form-data" class="universe_form">
                    {{ method_field('patch') }}
                    @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client name: </label></div>
                                <div class="col-5"><input type="text" name="name" class="form-control" value="{{ $client->name}}" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client email: </label></div>
                                <div class="col-5"><input type="email" name="email" class="form-control" value="{{ $client->email}}" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client date of birth: </label></div>
                                <div class="col-5"><input type="date" name="date_of_birth" class="form-control" value="{{ $client->date_of_birth}}" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                    <div class="col-3"><label> Profil image: </label></div>
                                    <div class="col-5"><input type="file" name="image" id="clientImg" class="form-control" value="{{ $client->image}}" required/></div>
                            </div>
                            <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-4">
                                        @if($client->image)                                              
                                            <img class="img-fluid b_margin_top30" src="/images/{{ $client->image }}" />
                                            <p class="text-center">Curent profile image</p>
                                        @endif
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-4">                                            
                                        <img class="img-fluid b_margin_top30" id="clientImgShow" src="#" alt="" />
                                        <p class="image_paragraph_new text-center"></p>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-8"><button class="btn btn-primary float-right">Update</button></div>                                
                            </div>
                        </div>
                    </form>
<hr/>

                    <button class="btn btn-danger b_margin_top30 float-right"  data-toggle="modal" data-target="#exampleModalCenter"> <i class="fas fa-user-slash"></i> Delete client</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete client<strong> {{ $client->name }} </strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="/clients/{{ $client->id }}">
                                    @method('delete')
                                    @csrf
                                        <button type="submit" class="btn btn-danger float-right"><i class="fas fa-trash-alt"></i> Delete</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>      
            <script>
                $(document).ready(function(){
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            
                            reader.onload = function (e) {
                                $('#clientImgShow').attr('src', e.target.result);
                                $('.image_paragraph_new').html('New picked picture');
                            }
                            
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    
                    $("#clientImg").change(function(){
                        readURL(this);
                    });
                });
            </script>  
    @endsection