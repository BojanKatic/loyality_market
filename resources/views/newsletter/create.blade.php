@extends('layouts.app')
    @section('content')
            <div class="card">
                <div class="card-header"><h4>Newsletter/Create</h4></div>

                <div class="card-body">
                    <p  class="text-right"><a href="/newsletter" class="btn btn-primary"><i class="fas fa-undo fa-sm"></i> Back</a></p>
                    <form method="post" action="/newsletter" class="universe_form">
                    @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Message: </label></div>
                                <div class="col-5"><textarea name="text" class="form-control" required></textarea></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-8"><button class="btn btn-primary float-right">Create</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>        
    @endsection