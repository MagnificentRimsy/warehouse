<?php use Carbon\Carbon; ?>
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('notification')
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Rent Expense <b>#{{ str_pad( $expense->exid, 6, "0", STR_PAD_LEFT)}} </b> - {{$expense->department}}

                        <a class="btn btn-default" style="float: right;margin-top:-5px;" href="{{url('expenses')}}">Back</a>
                    </div>

                    <div class="box-typical-body panel-body">


                        <div class="row">
                            <div class="col-md-4 col-md-offset-1">
                                <b>Title:</b> {{$expense->shortDesc}}<br>
                                <b>Date:</b> {{Carbon::createFromFormat("Y-m-d H:i:s",$expense->created_at)->toFormattedDateString() }} <br>
                                <b>Total Spent:</b> {{$expense->currency}}  {{$expense->amount}} <br>
                                <b>Recurring Payment?:</b>
                                @if($expense->isRecurring == 1)
                                    Yes<br>
                                    <b>Next Payment:</b> {{Carbon::createFromFormat("Y-m-d H:i:s",$expense->nextPayment)->toFormattedDateString() }} <br>
                                @else
                                    No
                                @endif
                                <br>

                            </div>
                            <div class="col-md-4">
                                <b>Description:</b> {{$expense->longDesc}}

                            </div>
                            <div class="col-md-1">
{{--                                <a href="{{url('create-receipt?invoice=' . $invoice->invid)}}" class="btn btn-success">Add Payment</a><br> <br>--}}
                                {{--<a href="{{url('invoice/' . $invoice->invid)}}" class="btn" style="color:white;background-color: darkgreen">Download PDF</a>--}}
                            </div>
                        </div>



                        <br>
                        <h4>Rent Expense Items</h4>
                        <table class="table table-hover">
                            <tr>
                                <th>S/N</th>
                                <th>Item Description</th>
                                <th>Price</th>
                            </tr>


							<?php $count = 1; ?>
                            @foreach($expense->items as $item)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{$item->item}}</td>
                                    <td>{{$item->amount}}</td>
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
