@extends('layouts.app')

@section('content')
<?php
if ( isset($_GET["page"]) )
{
    $page = $_GET["page"];
}else{
    $page= "";
}
?>
    <div class="row">
        <div class="col-8">
            <p><strong>Ime i prezime:</strong> {{ $client->name }}</p>
            <p><strong>E-mail:</strong> {{ $client->email }}</p>
            <p><strong>Datum rodjenja:</strong> {{ $client->date_of_birth }}</p>
        </div>
        <div class="col-4 client_profile">
            <img src="/images/{{ $client->image }}" alt="" />
        </div>
    </div>
<hr/>
<h2>Računi korisnika:</h2>


                    <table class="table b_margin_top30">
                        <thead class="thead-light">
                            <tr>
                                <th>id</th>
                                <th>Suma</th>
                                <th>Datum narudzbe</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                      
                            @foreach($racuni as $racun)
                            <tr>
                                <td><a href="/show-invoice/{{ $racun->id }}">{{ $racun->id }}</a></td>
                                <td>{{ $racun->invoice_order_sum }}</td>
                                <td>{{ $racun->invoice_order_date }}</td>
                                <td class="resource_count_control">
                                    <a href="/show-invoice/{{ $racun->id }}"><i class="fas fa-eye"></i> </a>
                                </td>
                            </tr> 
                            @endforeach                   
                        </tbody>
                    </table>
                        @if($pagination_list_count != 1)
                            <ul id="scrolToPaginationTable" class="list-inline float-right client_invoice_pagination">
                                @for ($i = 0; $i < $pagination_list_count; $i++)
                                    <a href="?page={{$i}}" <?php if($page == $i){?> class="active" <?php } ?>><li class="list-inline-item"> {{$i}}</li></a>
                                @endfor
                            <ul>
                        @endif
<?php
    if(isset($_GET['page']))
    {
?>
    <script>
        $(function() {
            $('html, body').animate({
                scrollTop: $("#scrolToPaginationTable").offset().top
            }, 2000);
         });
    </script>
<?php 
    } 
?>
@endsection