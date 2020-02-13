<?php use Illuminate\Support\Facades\Input; ?>
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
                            <option value="contactPersonName">Contact Person Name</option>
                            <option value="contactPersonPhone">Contact Person Phone</option>
                            <option value="contactPersonEmail">Contact Person Email</option>
                        </select>

                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>
                </div>

            </div>



                <div class="col-md-7">

                </div>

            </div>

        </div>

        <div class="box-typical panel panel-default">
            <div class=" panel-heading">View Suppliers
                <br>
                @if(Input::has('term') && Input::has('by'))
                    <span class="label label-success">
                         Filtered by Search ({{Input::get('by')}}) - {{Input::get('term')}}
                    </span>
                @endif
            </div>
            <div class="box-typical-body panel-body">
                <span style="float:right;">There are {{count($suppliers)}} suppliers</span>

                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>No Of Products</th>
                        <th></th>
                    </tr>

                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{$supplier->name}}</td>
                            <td>{{$supplier->phone}}</td>
                            <td>{{$supplier->email}}</td>
                            <td>{{count($supplier->Products)}}</td>
                            <td>
                                <a href="{{url('supplier/' . $supplier->sid)}}" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection