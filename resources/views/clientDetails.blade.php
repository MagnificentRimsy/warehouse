<?php use Carbon\Carbon; ?>
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Client -

                        @if(isset($client->companyName))
                            {{$client->companyName}}
                        @else
                            {{$client->fname}} {{$client->sname}}
                        @endif
                    </div>

                    <div class="box-typical-body panel-body">

                        <div class="row">
                            <div class="col-md-4 col-md-offset-1">

                                @if(isset($client->companyName))
                                    CLIENT: {{$client->companyName}}
                                @else
                                    CLIENT: {{$client->fname}} {{$client->sname}}
                                @endif
                                <br>
                                Date Created: {{Carbon::createFromFormat("Y-m-d H:i:s",$client->created_at)->toFormattedDateString() }} <br>
                                Address: {{$client->address}} <br>
                                Sales Rep : <a href="{{url('sales-rep/'. $client->SalesRep->srid)}}"> {{$client->SalesRep->name}}</a><br>
                                Email: {{$client->email}}
                            </div>
                            <div class="col-md-4">
                                Total Invoices: {{count($client->Invoice)}} <br>
                                Total Billed:
                                @if($billedNGN > 0)
                                NGN {{$billedNGN}}
                                @endif

                                @if($billedUSD > 0)
                                | USD {{$billedUSD}}
                                @endif

                                @if($billedGHC > 0)
                                | GHC{{$billedGHC}}
                                @endif


                                <br>

                            </div>
                            <div class="col-md-1">

                                <a href="{{url('create-invoice')}}" class="btn btn-primary">Create Invoice</a>
                            </div>
                        </div>



                        <br>
                        <h4>Invoices </h4>
                        <table class="table table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Invoice ID</th>
                                <th>Title</th>
                                <th>Total</th>
                                <th>Currency</th>
                                <th>Date</th>
                            </tr>


                            <?php $count = 1; ?>
                            @foreach($client->Invoice as $item)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>
                                        <a href="{{url('invoicing/invoice-details/' . $item->invid)}}">
                                        {{str_pad($item->invid,6,"0",STR_PAD_LEFT)}}
                                        </a>
                                    </td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->total}}</td>
                                    <td>{{$item->currency}}</td>
                                    <td>{{Carbon::createFromFormat("Y-m-d H:i:s",$item->created_at)->toFormattedDateString() }}</td>
                                </tr>

                                <?php $count++; ?>
                            @endforeach

                        </table>


                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
