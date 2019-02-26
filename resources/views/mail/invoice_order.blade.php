@component('mail::message')
# Introduction

                    <table class="table b_margin_top30">
                        <thead class="thead-light">
                            <tr>
                                <th>Resource name</th>
                                <th>Quantity</th>
                                <th>Sum</th>
                            </tr>
                        </thead>
                        <tbody>    
                        <?php
                            $a =-1;
                        ?>
                            @foreach($meil_array as $meil)
                        <?php
                            $a++;                           
                        ?>
                            <tr>
                                <td>{{ $meil_array[''.$a.'']['0']['resource_name'] }}</td>
                                <td>{{ $meil_array[''.$a.'']['0']['resource_price'] }}</td>
                                <td>{{ $meil_array[''.$a.'']['0']['resource_sum'] }}</td>
                            </tr> 
                            @endforeach  

                            <tr>
                                <td></td>
                                <td style="text-align:right;">Total:</td>
                                <td>{{ $total_invoice_sum }}</td>
                            </tr>                  
                        </tbody>
                    </table>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
