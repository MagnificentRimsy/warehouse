@extends('layouts.app')


@section('content')
<?php use \Illuminate\Support\Facades\Input; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
               @include('notification')
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Create Receipt</div>
                    <div class="box-typical-body panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('create-receipt') }}">
                            {{ csrf_field() }}


                                @if(Input::has('invoice'))
                                <label>Sale Invoice #{{str_pad(Input::get('invoice'),6,"0",STR_PAD_LEFT)}}</label>
                                    <input type="hidden" name="salid" value="{{Input::get('invoice')}}">

                                    @else
                                <label>Select Invoice #</label>
                                <select name="salid">
                                        @foreach($sales as $invoice)
                                            <option value="{{$invoice->salid}}"> {{str_pad($invoice->salid,6,"0",STR_PAD_LEFT)}}</option>
                                        @endforeach
                                </select>
                                @endif



                            <table id="table" class="table table-hover" >
                                <tr>
                                    <th>Amount <td><input class="form-control" type="number" name="amount" max="{{Input::get('total')}}"></td>

                                </tr>
                                <tr>
                                    <th>Details<td><input class="form-control" type="text" name="details"></td>

                                </tr>

                            </table>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create Receipt
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection