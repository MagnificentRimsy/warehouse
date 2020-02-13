<?php use Carbon\Carbon; ?>
@extends('layouts.app')


@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">View Receipt</div>
                    <div class="box-typical-body panel-body">
                        <table id="table" class="table table-hover table-hover">
                            <tr>
                                <th>Receipt ID</th>
                                <th>Invoice ID</th>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>


                                @foreach($receipts as $receipt)
                                <tr>
                                    <td>{{str_pad( $receipt->recid, 6, "0", STR_PAD_LEFT)}} </td>
                                    <td>
                                        <a href="{{url('sale-details/' . $receipt->salid)}}">
                                            {{str_pad( $receipt->salid, 6, "0", STR_PAD_LEFT)}}
                                        </a>
                                    </td>
                                    <td>
                                        {{--@if(isset($receipt->Invoice->Client))--}}
                                            {{--{{$receipt->Invoice->Client->companyName}}--}}
                                        {{--@else--}}
                                            {{$receipt->Invoice->Details[0]->SalesRep->name}}
                                        {{--@endif--}}
                                    </td>
                                    <td>{{$receipt->amount}}</td>
                                    <td>{{Carbon::createFromFormat("Y-m-d H:i:s",$receipt->created_at)->toFormattedDateString()}}</td>
                                </tr>
                                @endforeach


                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection