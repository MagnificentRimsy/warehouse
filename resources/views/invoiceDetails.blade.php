<?php use Carbon\Carbon; ?>
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('notification')
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Invoice <b>#{{ str_pad( $invoice->invid, 6, "0", STR_PAD_LEFT)}} </b> - {{$invoice->Client->companyName}}</div>

                    <div class="box-typical-body panel-body">


                        <div class="row">
                            <div class="col-md-4 col-md-offset-1">

                                @if(isset($invoice->Client->companyName))
                                    CLIENT: <a href="{{url('client-details/' . $invoice->Client->clid)}}">
                                                {{$invoice->Client->companyName}}
                                            </a>
                                @else
                                    CLIENT: <a href="{{url('client-details/' . $invoice->Client->clid)}}">
                                                {{$invoice->Client->fname}} {{$invoice->Client->sname}}
                                            </a>
                                @endif
                                <br>
                                Date: {{Carbon::createFromFormat("Y-m-d H:i:s",$invoice->created_at)->toFormattedDateString() }} <br>
                                Address: {{$invoice->Client->address}} <br>
                                Sales Rep: <a href="{{url('sales-rep/'. $invoice->Client->SalesRep->srid)}}">{{$invoice->Client->SalesRep->name}}</a>
                            </div>
                            <div class="col-md-4">
                                Total Due: {{$invoice->currency}} {{ $invoice->total  }} <br>
                                Total Paid: {{$invoice->currency}} {{$paid}} <br>
                                Balance: {{$invoice->currency}} {{$invoice->total - $paid}}

                            </div>
                            <div class="col-md-1">
                                <a href="{{url('create-receipt?invoice=' . $invoice->invid)}}" class="btn btn-success">Add Payment</a><br> <br>
                                <a href="{{url('invoice/' . $invoice->invid)}}" class="btn" style="color:white;background-color: darkgreen">Download PDF</a>
                            </div>
                        </div>



                        <br>
                        <h4>Invoice Details</h4>
                        <table class="table table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Item Description</th>
                                <th>Price</th>
                            </tr>


                            <?php $count = 1; ?>
                                @foreach($invoice->Details as $item)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->price}}</td>
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
                                <th>Amount Paid ({{$invoice->currency}})</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th></th>
                            </tr>


                            <?php $count = 1; ?>
                            @foreach($invoice->Receipts as $item)
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

                                <?php $count++; ?>
                            @endforeach

                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
