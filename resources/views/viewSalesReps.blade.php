<?php use Carbon\Carbon; use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

    <div class="container">

        <button data-toggle="collapse" class="btn btn-primary" data-target="#filter">Filter</button> <br><br>

        <div id="filter" class="collapse">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-8">
                    <form class="form-inline" style="padding-top: 14px">
                        <label>SEARCH:</label>
                        <input name="term" value="{{Input::get('term')}}" class="form-control">
                        <select name="by" class="form-control">

                            <option value="name">Name</option>
                            <option value="phone">Phone</option>
                            <option value="email">Email</option>
                        </select>

                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">

                    <form class="form-inline" style="padding-top: 14px">
                        AMOUNT OWED BETWEEN
                        <input name="min" type="number" value="{{Input::get('min')}}" required class="form-control">
                        AND
                        <input name="max" type="number" value="{{Input::get('max')}}" required class="form-control">
                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>


                </div>

            </div>

        </div>

        <div class="box-typical panel panel-default">
            <div class="panel-heading">View Sales Reps
            <br>
                @if(Input::has('min') && Input::has('max'))
                     <span class="label label-success">
                        Filtered by Amount Owed - Between GHC{{Input::get('min')}} and ₦{{Input::get('max')}}
                    </span>
                @endif

                @if(Input::has('term') && Input::has('by'))
                    <span class="label label-success">
                         Filtered by Search ({{Input::get('by')}}) - {{Input::get('term')}}
                    </span>
                @endif


            </div>
            <div class="box-typical-body panel-body">
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Amount Owed (GHC)</th>
                        <th></th>
                    </tr>

                    @foreach($salesReps as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->credit}}</td>
                            <td>
                                <a href="{{url('sales-rep/' . $item->srid)}}" class="btn btn-primary">View</a>
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection