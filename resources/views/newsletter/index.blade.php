@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header"><h4>Newsletter</h4></div>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="card-body">
                    <a href="/newsletter/create" class="btn btn-primary text-right">Create newsletter message</a>

                    <table class="table b_margin_top30">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Textual message</th>

                            </tr>
                        </thead>
                        <tbody>     
                            @foreach($newsletter as $newsletter_listed)
                            <tr>
                                <td>{{ $newsletter_listed->created_at }}</td>
                                <td>{{ $newsletter_listed->text }}</td>

                            </tr> 
                            @endforeach                                                
                        </tbody>
                    </table>
                    <div class="float-right">
                    </div>
                </div>
            </div>
@endsection