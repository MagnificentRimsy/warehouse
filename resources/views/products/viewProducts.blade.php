<?php
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
?>
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
                        </select>

                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">

                    <form class="form-inline" style="padding-top: 14px">
                        PRODUCTS WHERE
                        <select name="numBy" class="form-control">
                            <option value="quantity">Quantity</option>
                            <option value="supplyPrice">Supply Price</option>
                            <option value="salePrice">Sale Price</option>
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

        </div>

        <div class="box-typical panel">
            <div class="panel-heading">View Products
                <br>
                @if(Input::has('term') && Input::has('by'))
                    <span class="label label-success">
                         Filtered by Search ({{Input::get('by')}}) - {{Input::get('term')}}
                    </span>
                @endif

                @if(Input::has('min') && Input::has('max'))

                    @if(Input::get('numBy') != "quantity")
                    <span class="label label-success">
                        Filtered by {{Input::get('numBy')}} - Between &#x20B5;{{Input::get('min')}} and &#x20B5;{{Input::get('max')}}
                    </span>
                        @else
                        <span class="label label-success">
                        Filtered by {{Input::get('numBy')}} - Between {{Input::get('min')}} and {{Input::get('max')}} units
                    </span>
                    @endif
                @endif

            </div>
            <div class="box-typical-body panel-body">

                <span style="float:right;">There are {{count($products)}} products</span>
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Supply Price</th>
                        <th>Sale Price</th>
                        <th>Supplier</th>
                        <th></th>
                    </tr>

                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->supplyPrice}}</td>
                            <td>{{$product->salePrice}}</td>
                            <td>
                                <a href="{{url('supplier/' . $product->Supplier->sid)}}">{{$product->Supplier->name}}</a>
                            </td>
                            <td>
                                <a href="{{url('product/' . $product->pid)}}" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection