@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-typical panel panel-default">
            <div class="panel-heading">SalesRep Details : {{$salesRep->name}}</div>
            <div class="box-typical-body panel-body">
                <p>
                    Name - <span>{{$salesRep->name}}</span><br>
                    Phone - <span>{{$salesRep->phone}}</span><br>
                    Email - <span>{{$salesRep->email}}</span><br>
                    Total Credit - <span>{{$salesRep->credit}}</span><br>
                    Total Value of Sales By Client - <span>&#x20B5;{{$totalValue}}</span><br>
                    Number of Clients - <span>{{count($salesRep->Clients)}}</span>
                </p>


            </div>
        </div>

        <div class="box-typical panel panel-default">
            <div class="panel-heading">{{$salesRep->name}}'s Clients</div>
            <div class="box-typical-body panel-body">

                <table class="table table-hover">

                    <th>Client</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Total Invoices</th>


                    @foreach($salesRep->Clients as $client)
                        <tr>

                            <td>
                                <a href="{{url('client-details/' . $client->clid)}}" >
                                    @if(isset($client->companyName))
                                        {{$client->companyName}}
                                    @else
                                        {{$client->fname}} {{$client->sname}}
                                    @endif


                                </a>
                            </td>
                            <td>{{$client->phone}}</td>
                            <td>{{$client->email}}</td>
                            <td>{{count($client->Invoice)}}</td>

                        </tr>
                    @endforeach

                </table>

            </div>
        </div>


    </div>

@endsection