@extends('layouts.app')
    @section('content')
            <div class="card">
                <div class="card-header"> <h4>Clients/Create </h4></div>

                <div class="card-body">
                    <p class="text-right"><a href="/clients" class="btn btn-primary"><i class="fas fa-undo"></i> Back</a></p>
                    <form method="post" action="/clients" enctype="multipart/form-data" class="universe_form">
                    @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client name: </label></div>
                                <div class="col-5"><input type="text" name="name" class="form-control" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client image: </label></div>
                                <div class="col-5"><input type="file" name="image" id="clientImg" class="form-control"/></div>
                                <div class="col-4"><img class="img-fluid" id="clientImgShow" src="#" alt="" /></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client email: </label></div>
                                <div class="col-5"><input type="email" name="email" step="0.01" class="form-control" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Client date of birth: </label></div>
                                <div class="col-5"><input type="date" name="date_of_birth" class="form-control" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-8"><button class="btn btn-primary float-right"><i class="fas fa-user-plus"></i> Create</button></div>
                            </div>                
                        </div>
                    </form>
                </div>
            </div>        
            <script>
                $(document).ready(function(){
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            
                            reader.onload = function (e) {
                                $('#clientImgShow').attr('src', e.target.result);
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