@extends('layouts.app')

@section('content')

<button onclick="window.history.go(-1)"; class="btn btn-primary text-right"><i class="fas fa-undo fa-sm"></i>  Back to shoping </button>
<hr/>
<h2>Client {{ $client_data['0']->name }} Cart :</h2>


<?php  
session_start();
    if(isset($_SESSION["kosara"])){
    $cart_count =  count($_SESSION["kosara"]);
    $total = 0;

    $baseArray = array();
    $invoiceData = array();
?>
    <table class="table b_margin_top30">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Kolicina</th>
                <th>Cijena</th>
            </tr>
        </thead>
        <tbody>   
            @foreach($resources as $ressss)
                        
            <?php
                if( isset( $_SESSION['kosara'][''.$ressss->id.''] ) ){
                    $total = $total + $_SESSION["kosara"][''.$ressss->id.'']['0']['resource_new_price'];
            ?>

            <tr>
                <td>{{ $_SESSION["kosara"][''.$ressss->id.'']['0']['resurs_id'] }}</td>
                <td>{{$ressss->name}}</td>
                <td>{{ $_SESSION["kosara"][''.$ressss->id.'']['0']['resource_quantity'] }}</td>
                <td>{{ $_SESSION["kosara"][''.$ressss->id.'']['0']['resource_new_price'] }}</td>
            </tr>
    
            <?php 
                    $baseArray[] = array(  
                        'product' => $_SESSION["kosara"][''.$ressss->id.'']['0']['resurs_id'], 
                        'quantity' => $_SESSION["kosara"][''.$ressss->id.'']['0']['resource_quantity'],
                        'amount' => $_SESSION["kosara"][''.$ressss->id.'']['0']['resource_new_price']
                    );
                            
                } 
        ?>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>Total: </td>
                <td>{{$total}}</td>
            </tr>
        </tbody>
    </table>
    <a href="/client/finish-order" class="btn btn-primary">Finish order </a>
<?php
    $invoiceData[] = array(  
        'clientId' => $client_data['0']->id,
        'invoiceSum' => $total,
        'registred_admin' => auth()->user()->id
    );


    $invoiceDataConverted = collect($invoiceData);
    $product = collect($baseArray);

    session()->put('orderList', ''.$product.'');
    session()->put('orderData', ''.$invoiceDataConverted.'');
    }
?>

@endsection