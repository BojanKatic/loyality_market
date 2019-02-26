@extends('layouts.app')
    @section('content')

    <?php session_start();
#cart.php - A simple shopping cart with add to cart, and remove links
 //---------------------------
 //initialize sessions

//Define the products and cost
$products = array();
$amounts = array();

    if(isset($_SESSION["kosara"])){

        $cart_count  = count($_SESSION["kosara"]);
    }else{
        $cart_count  = 0;
    }
 ?>

            <div class="card">
                <div class="card-header"><h4> Clients/ {{ $client->name}} / Create Invoice </h4></div>

                <div class="card-body">
                    <a href="/clients" class="btn btn-primary text-right"><i class="fas fa-undo fa-sm"></i>  Back</a> 
                    <table class="table b_margin_top30">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity in storage</th>
                                <th class="text-center">Control</th>
                            </tr>
                        </thead>
                        <tbody>                      
                            @foreach($resources as $resource)
                            <?php
                            //Define the products and cost <a href="?add={{ $idOfResource }}" class="dodavanje" data-index="{{ $resource->quantity  }}" name="tab">Add to cart</a> 
                                $products []=  $resource->name ;
                                $amounts []= $resource->price;
                                $idOfResource = $resource->id -1;
                            ?>
                            <tr>
                                <td>{{ $resource->id }}</td>
                                <td>{{ $resource->name }}</td>
                                <td>{{ $resource->price }}</td>
                                <td class="text-center">{{ $resource->quantity }}  </td>
                            <?php if($resource->quantity > 0){ ?>

                                <td class="text-center">
                                    <button class="cart_button" onClick="decrement_quantity(<?php echo $resource->id; ?>, '<?php echo  $resource->price; ?>')"> - </button>
                                    <input class="cart_input" type="number" id="resource_input_<?php echo $resource->id; ?>" value="0" />
                                    <button class="cart_button" onClick="increment_quantity(<?php echo $resource->id; ?>, '<?php echo  $resource->price; ?>')"> + </button>
                                </td>
                            <?php }else{ ?>

                                <td class="disabled"><span>Add to cart</span>  <span class="float-right" disabled>Delete from cart</span></td>
                            <?php } ?>   
                            </tr> 
                            @endforeach  
                 
                        </tbody>
                    </table>

                        {{ $resources->links() }}

                    <button onClick="reset_cart()" class="btn btn-primary float-right"> Reset Cart </button>
                                    
            </div>   
        <div class="shoping_basket">   
            <a <?php if(!isset($_SESSION["kosara"])){?> style="display:none"<?php }?> href="/cart/{{$client->id}}" id="basket" class="btn btn-success"><i class="fas fa-shopping-basket"></i> (  <span id="result"><?php echo $cart_count; ?></span> )</a>
        </div>
<?php

?>

 <script>
 var increment_quantity;
 var decrement_quantity;
 var reset_cart
    $(document).ready(function(){

        increment_quantity = function(resource_id, price) {
            var inputQuantityElement = $("#resource_input_"+resource_id);
            var newQuantity = parseInt($(inputQuantityElement).val())+1;
            var newPrice = newQuantity * price;
            save_to_db(resource_id, newQuantity, newPrice);
        }

        decrement_quantity = function(resource_id, price) {
            var inputQuantityElement = $("#resource_input_"+resource_id);
            if($(inputQuantityElement).val() > 1) 
            {
            var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
            var newPrice = newQuantity * price;
            save_to_db(resource_id, newQuantity, newPrice);
            }
        }

        function save_to_db(resource_id, new_quantity, newPrice) {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });	
            var inputQuantityElement = $("#resource_input_"+resource_id);

            $.ajax({
                url : "/resources/ajax",
                data : {resource_id: resource_id, new_quantity: new_quantity, newPrice: newPrice },
                type : 'post',
                success:function(response) {
                    $(inputQuantityElement).val(new_quantity);
                    $("#result").html(response);
                    if (response) {
                        $('#basket').show();
                    } else {
                        $('#basket').hide();
                    }
                }
            });
        }
        reset_cart = function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                url : "/resources/reset_cart",
                type : 'post',
                success:function(response) {
                    $('#basket').hide();
                }
            });
        }

});
 </script>

    @endsection

