@extends('layouts.app')


@section('content')
            <div class="card">
                <div class="card-header">
                    <h3> Dashboard </h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="home_search_box float-right" >
                                <input type="text" id="search" name="search" class="form-control input_border_none"/>
                                <button id="focus_search"  class="btn btn-primary"><i class="fas fa-search"></i> Find client</button>
                            </div>
                        </div>
                        <div class="col-12 search_result">
                             <ul id="showSearchResult"></ul>                           
                        </div>
                    </div>

                    <div class="row dashboard_section_title">
                        <div class="col-4">
                            <div class="card card-body">
                                <div class="col-12 text-center">
                                    <i class="fas fa-users"></i> {{ $countingData['0']['clients'] }}<br/>
                                </div>
                                <div class="col-12 text-center">
                                    Total number of clients
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-body">
                                <div class="col-12 text-center">
                                    <i class="fas fa-boxes"></i> {{ $countingData['0']['resources'] }}<br/>
                                </div>
                                <div class="col-12 text-center">
                                    Total number of resources
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-body">
                                <div class="col-12 text-center">
                                    <i class="fas fa-file-invoice-dollar"></i> {{ $countingData['0']['invoiceSevenDays'] }}
                                </div>
                                <div class="col-12 text-center">
                                    Transactions in last 7 days
                                </div>
                            </div>
                        </div>
                        <div class="col-12 b_margin_top20 b_margin_btm20 dashboard_log_conent">
                            <div class="card card-body">
                                <span class="text-center">Last five doings</span>
                                
                                    @foreach($log as $logOpis)
                                        <p>{{$logOpis->created_at }} / {{$logOpis->description}} </p>
                                    @endforeach  

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-body dashboard_half_div">
                                <span class="text-center"> Most 5 active users  </span>
                                <ul style="list-style:none">
                                    @foreach($client_activity as $client_activity_list)
                                        <li>- {{$client_activity_list->name}} spent {{ $client_activity_list->spent }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-body dashboard_half_div">
                                <span class="text-center">Top 5 sold resources:</span>
                                    <ul style="list-style:none">
                                        @foreach($most_used_resources as $most_used_resource)

                                            <li>- {{$most_used_resource['resource_name'] }} is bought  <strong>{{$most_used_resource['resource_used_sum'] }}</strong> time's !</li>

                                        @endforeach  
                                    </ul>
                            </div>
                        </div>
                        <div class="col-12 b_margin_top20 b_margin_btm20 dashboard_log_conent">
                            <div class="card card-body">
                                <span class="text-center">Latest transactions</span>
                                
                                    @foreach($last_invoices as $last_invoices_list)
                                        <p>{{$last_invoices_list['invoice_creation_date'] }} user <strong>{{$last_invoices_list['client_name'] }}</strong> spent <strong>{{$last_invoices_list['invoice_sum'] }} BAM</strong>  </p>
                                    @endforeach  

                            </div>
                        </div>
                    </div>  <!-- end of Row --->                 
                </div>
            </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#focus_search').click(function(){
                $('#search').focus();
            });
            $('#search').on('keyup',function(){
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });	

                if( $(this).val().length === 0 ) {
                    $value = '-';
                }else{
                    $value=$(this).val();
                }
                $.ajax({
                    type : 'get',
                    url : '{{URL::to('search')}}',
                    data:{'search':$value},
                    success:function(data){
                    $('#showSearchResult').html(data);
                    }
                });
            });
        });
    </script>
@endsection


