@extends('layouts.app')

@section('content')
    <a href="/clients/{{ $invoice->invoice_client_id}}" class="btn btn-primary text-right b_margin_btm20">Back to client profile</a>
    <h3>Invoice: <strong>{{ $invoice->id}} </strong> </h3>

        <table class="table b_margin_top30">
            <thead class="thead-light">
                <tr>
                    <th>Resource</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>              
                @foreach($invoice_content_data as $content_data)
                <tr>
                    <td>{{ $content_data['invoice_resource_name'] }}</td>
                    <td>{{ $content_data['invoice_product_sum'] }}</td>
                    <td>{{ $content_data['invoice_resource_price'] }}</td>
                    <td>{{ $content_data['invoice_product_price'] }}</td>
                </tr> 
                @endforeach         
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right"><strong> Total: </strong></td>
                    <td class="table_border_bottom">{{ $invoice->invoice_order_sum}}</td>
                </tr>           
            </tbody>
        </table>
@endsection