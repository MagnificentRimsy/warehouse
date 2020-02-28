<?php use Carbon\Carbon; ?>
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('notification')
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Sale <b>#{{ str_pad( $sale->salid, 6, "0", STR_PAD_LEFT)}} </b> - {{$sale->Details[0]->SalesRep->name}}</div>

                    <div class="box-typical-body panel-body">


                        <div class="row">
                        <div class="col-md-4 col-md-offset-1">


                        @if(isset($sale->Details[0]->clid))
                        CLIENT: <a href="{{url('client-details/' . $sale->Details[0]->Client->clid)}}">
                        {{$sale->Details[0]->Client->companyName}}
                        </a>
                            Address: {{$sale->Details[0]->Client->address}} <br>
                        @endif


                        SALES REP: <a href="{{url('sales-rep/' . $sale->Details[0]->SalesRep->srid)}}">
                        {{$sale->Details[0]->SalesRep->name}}
                        </a> <br>
                        TYPE: {{$sale->type}}
                        <br>
                        Date: {{Carbon::createFromFormat("Y-m-d H:i:s",$sale->created_at)->toFormattedDateString() }} <br>


                        </div>
                        <div class="col-md-4">

                            Total Due:  &#x20B5;{{ $sale->total  }} <br>
                            Total Paid: &#x20B5; {{$paid}} <br>
                            Balance: &#x20B5; {{$sale->total - $paid}} @if($sale->total - $paid < 0 ) (Company Owes Sales Rep) @endif

                        </div>
                        <div class="col-md-1">
                        <a href="{{url('create-receipt?invoice=' . $sale->salid) . '&total=' . $sale->total}}" class="btn btn-success">Add Payment</a><br> <br>
                        <a href="{{url('invoice/' . $sale->salid)}}" class="btn" style="color:white;background-color: darkgreen">Download Invoice PDF</a>
                        </div>
                        </div>



                        <br>
                        <h4>Sale Details</h4>
                        <table class="table table-hover">
                        <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th></th>
                        </tr>

                        <?php $count = 1; ?>
                        @foreach($sale->Details as $sale)
                        <tr>
                        <td>{{$count}}</td>
                        <td>
                            <a href="{{url('product/' . $sale->Product->pid)}}" >
                                {{$sale->Product->name}}
                            </a>
                        </td>
                        <td>{{$sale->quantity}}</td>
                        <td>{{$sale->amount}}</td>
                        <td>{{Carbon::createFromFormat("Y-m-d H:i:s",$sale->created_at)->toDateTimeString()}}</td>

                        </tr>
                        <?php $count++; ?>
                        @endforeach
                        </table>



                    </div>
                </div>


                <div class="box-typical panel panel-default">
                    <div class="panel-heading">
                        Payments
                    </div>
                    <div class="box-typical-body panel-body">
                        <table class="table table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Receipt ID</th>
                                <th>Amount Paid (&#x20B5;)</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th></th>
                            </tr>



							<?php $count = 1; ?>
                            @foreach($receipts as $item)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{str_pad( $item->recid, 6, "0", STR_PAD_LEFT)}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->details}}</td>
                                    <td>{{Carbon::createFromFormat("Y-m-d H:i:s",$item->created_at)->toFormattedDateString()}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{url('receipt/' . $item->recid)}}">Download Receipt</a>
                                    </td>
                                </tr>

                                <?php //$count++; ?>
                            @endforeach

                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
