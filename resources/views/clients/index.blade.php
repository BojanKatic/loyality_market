@extends('layouts.app')

@section('content')
<?php
session_start();
?>
            <div class="card">
                <div class="card-header"> <h4>Clients</h4> </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="card-body">
                    <a href="/clients/create" class="btn btn-primary text-right">Create new client</a>

                    <table class="table b_margin_top30">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Shoping count</th>
                                <th>Average spent</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                      
                            @foreach($clients as $client)
                            <?php
                                if($client->spent != 0){
                                $averageSpending = round(($client->spent / $client->shopingSumCount),2);
                                }else{
                                    $averageSpending = 0;
                                }
                            ?>
                            <tr>
                                <td><a href="/clients/{{ $client->id }}">{{ $client->name }}</a></td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->spent }}</td>
                                <td>{{ $averageSpending }}</td>
                                <td class="resource_count_control">
                                    <a href="/clients/{{ $client->id }}/edit"><i class="fas fa-edit"></i> </a>
                                    <a href="/client-invoice/{{ $client->id }}"><i class="fas fa-file-invoice-dollar"></i> </a>
                                </td>
                            </tr> 
                            @endforeach                   
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
            <?php
 


 ?>
@endsection