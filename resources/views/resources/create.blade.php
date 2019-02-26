@extends('layouts.app')
    @section('content')
            <div class="card">
                <div class="card-header"> <h4>Resource /Create</h4> </div>

                <div class="card-body">
                    <p class="text-right"><a href="/resources" class="btn btn-primary"><i class="fas fa-undo fa-sm"></i> Back</a></p>
                    <form method="post" action="/resources" class="universe_form">
                    @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Resource name: </label></div>
                                <div class="col-5"><input type="text" name="name" class="form-control" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Resource price: </label></div>
                                <div class="col-5"><input type="number" name="price" step="0.01" class="form-control" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Resource quantity: </label></div>
                                <div class="col-5"><input type="number" name="quantity" class="form-control" required/></div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-8"><button class="btn btn-primary float-right">Create</button></div>
                            </div>
                    </form>
                </div>
            </div>        
    @endsection