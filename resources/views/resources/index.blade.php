@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header">Resources</div>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="card-body">
                    <a href="/resources/create" class="btn btn-primary text-right">Create new resource</a>

                    <table class="table b_margin_top30">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Last time ordered</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                      
                            @foreach($resources as $resource)
                            <tr>
                                <td>{{ $resource->name }}</td>
                                <td>{{ $resource->price }}</td>
                                <td>{{ $resource->quantity }}</td>
                                <td>{{ date('d-m-Y', strtotime($resource->last_update)) }}</td>
                                <td class="resource_count_control">
                                    <a href="/resources/{{ $resource->id }}/edit"><i class="fas fa-edit"></i> </a>
                                </td>
                            </tr> 
                            @endforeach  
                            
                        </tbody>
                    </table>
                    <div class="float-right">
                    {{ $resources->links() }}
                    </div>
                </div>
            </div>
@endsection