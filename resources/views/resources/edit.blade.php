@extends('layouts.app')
    @section('content')
            <div class="card">
                <div class="card-header"> Resources <i class="fas fa-angle-double-right fa-xs"></i> Edit <i class="fas fa-angle-double-right fa-xs"></i> {{ $resource->name}}
                <a href="/resources" class="btn btn-primary float-right"><i class="fas fa-undo fa-sm"></i> Back</a>
                </div>

                <div class="card-body">
                    <form method="post" action="/resources/{{ $resource->id }}" class="universe_form">
                    {{ method_field('patch') }}
                    @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Resource name: </label></div>
                                <div class="col-5"><input type="text" name="name" class="form-control" value="{{ $resource->name}}" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3"><label> Resource price: </label></div>
                                <div class="col-5"><input type="number" name="price" step="0.01" class="form-control"  value="{{ $resource->price}}" required/></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-8"><button class="btn btn-primary float-right">Update resource</button></div>
                            </div>
                        </div>
                    </form>
<hr/>
                                <div class="form-group universe_form">
                                    <div class="row">
                                        <div class="col-3"><label> Resource quantity: </label></div>
                                        <div class="col-3"><input type="text" name="quantity" class="form-control" value="{{ $resource->quantity}}" disabled/></div>
                                        <div class="col-2"><button class="btn btn-primary float-right"  data-toggle="modal" data-target="#exampleModalCenter"> <i class="fas fa-plus-square"></i> Quantity</button></div>
                                    </div>
                                </div>
                        
                            <!-- Modal for resource quantity update-->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">New resource sum</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="/resources/{{ $resource->id }}/sumUpdate">
                                        @method('patch')
                                        @csrf
                                            <input type="hidden" name="name" value="{{ $resource->name }}"/>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 b_margin_btm20">Quantity of new resources for product <strong>{{ $resource->name }} </strong></div><br>
                                                    <div class="col-12"><input type="number" name="quantity" /></div>
                                                    <div class="col-12"><button type="submit" class="btn btn-primary float-right">Save changes</button></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <button class="btn btn-danger float-right"  data-toggle="modal" data-target="#deleteResourceModal"><i class="fas fa-trash-alt"></i> Delete resource</button>

                            <!-- Modal for resource quantity update-->
                            <div class="modal fade" id="deleteResourceModal" tabindex="-1" role="dialog" aria-labelledby="deleteResourceModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure for deleting resource {{ $resource->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form  method="post" action="/resources/{{ $resource->id }}">
                                            @method('delete')
                                            @csrf
                                                <button type="submit" class="btn btn-danger float-right"><i class="fas fa-trash-alt"></i> Delete resource</button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>        
    @endsection