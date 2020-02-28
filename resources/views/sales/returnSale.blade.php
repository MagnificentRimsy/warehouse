<?php use Carbon\Carbon; use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

    <div class="container">

        @include('notification')
        <button data-toggle="collapse" class="btn btn-primary" data-target="#filter">Filter</button> <br><br>

        <div id="filter" class="collapse">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-inline" style="padding-top: 14px">

                        <div class="col-md-5">
                            <label>SALES FROM LAST:</label>
                            <input  name="days" type="number" value="{{Input::get('days')}}" class="form-control">
                            DAYS
                            <button class="btn btn-primary">GO</button>
                        </div>
                        <div class="col-md-7">
                            <label>SEARCH:</label>
                            <input name="term" value="{{Input::get('term')}}" class="form-control">
                            <select name="by" class="form-control">

                                <option value="name">Name</option>
                            </select>

                            <button class="btn btn-primary">GO</button>

                        </div>
                        <br>
                    </form>
                </div>

            </div>


            <div class="row">
                <div class="col-md-12">

                    <form class="form-inline" style="padding-top: 14px">
                        SALES WHERE
                        <select name="by" class="form-control">
                            <option value="quantity">Quantity</option>
                            <option value="amount">Amount</option>
                        </select>
                        BETWEEN
                        <input name="min" type="number" value="{{Input::get('min')}}" required class="form-control">
                        AND
                        <input name="max" type="number" value="{{Input::get('max')}}" required class="form-control">
                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <form class="form-inline" style="padding-top: 14px">
                        SALES BETWEEN
                        <input name="from" onchange="console.log(this.value)" type="text" class="form-control" id="from">

                        AND
                        <input name="to" onchange="console.log(this.value)" type="text" class="form-control" id="to">

                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>

                    <script>
                        $(document).ready( function() {

                            console.log($.datepicker.formatDate( "yy-mm-dd", new Date( 2007, 1 - 1, 26 ) ));

                            var dateFormat = "mm/dd/yy",
                                from = $( "#from" )
                                    .datepicker({
                                        defaultDate: "+1w",
                                        changeMonth: true,
                                        numberOfMonths: 1
                                    })
                                    .on( "change", function() {
                                        to.datepicker( "option", "minDate", getDate( this ) );
                                    }),
                                to = $( "#to" ).datepicker({
                                    defaultDate: "+1w",
                                    changeMonth: true,
                                    numberOfMonths: 1
                                })
                                    .on( "change", function() {
                                        from.datepicker( "option", "maxDate", getDate( this ) );
                                    });

                            function getDate( element ) {
                                var date;
                                try {
                                    date = $.datepicker.parseDate( dateFormat, element.value );
                                } catch( error ) {
                                    date = null;
                                }

                                return date;
                            }

                        } );
                    </script>


                </div>

            </div>


        </div>

        <div class="box-typical panel">
            <div class="panel-heading">View Sales
                <br>
                @if(Input::has('term') && Input::has('by'))
                    <span class="label label-success">
                         Filtered by Search ({{Input::get('by')}}) - {{Input::get('term')}}
                    </span>
                @endif


                @if(Input::has('min') && Input::has('max'))

                    @if(Input::get('by') != "quantity")
                        <span class="label label-success">
                        Filtered by {{Input::get('by')}} - Between &#x20B5;{{Input::get('min')}} and &#x20B5;{{Input::get('max')}}
                    </span>
                    @else
                        <span class="label label-success">
                        Filtered by {{Input::get('by')}} - Between {{Input::get('min')}} and {{Input::get('max')}} units
                    </span>
                    @endif
                @endif


            </div>
            <div class="box-typical-body panel-body">
                <div style="font-size: 20px;">
                    <span style="float: right">&nbsp;Vat:&#x20B5;{{$vat}}</span> <span style="float: right;">Total Sales: &#x20B5;{{$totalSales}}</span>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Sales Rep</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th></th>
                    </tr>

                    @foreach($sales as $sale)
                        <tr>
                            <td>#{{ str_pad( $sale->salid, 6, "0", STR_PAD_LEFT)}} </td>
                            <td>
                                <a href="{{url('sales-rep/' . $sale->Details[0]->SalesRep->srid)}}">{{$sale->Details[0]->SalesRep->name}}</a>
                            </td>
                            <td>{{$sale->total}}</td>
                            <td>{{Carbon::createFromFormat("Y-m-d H:i:s",$sale->created_at)->toDateTimeString()}}</td>
                            <td>
                                <a href="{{url('return-sale/' . $sale->salid)}}" class="btn btn-primary">Return</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection