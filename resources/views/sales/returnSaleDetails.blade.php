@extends('layouts.app')

@section('content')

    <div class="container">

            @foreach($sale->Details as $item)
            <div class="box-typical panel panel-default">
            <div class="panel-heading">Product Details : {{$item->Product->name}}</div>
            <div class="box-typical-body panel-body">
                <p>
                <div class="col-md-12">
                    <b>Name</b> - <span>{{$item->Product->name}}</span><br>
                    <b>Unit Price</b> - <span>{{$item->amount}}</span><br>
                    <b>Quantity Sold</b> - <span>{{$item->quantity}}</span><br>
                    <b>Supplier</b> - <span>
                        <a href="{{url('supplier/' . $item->Product->Supplier->sid)}}">
                            {{$item->Product->Supplier->name}}
                        </a></span><br>
                    <b>Date Sold</b> - <span>{{$item->created_at}}</span><br>
                    <b>Sold To </b> - <span>{{$item->SalesRep->name}}</span><br>
                </div>

                <div class="col-md-4">
                    <b>Quantity In Stock</b> - <span>{{$item->Product->quantity}}</span>
                </div><div class="col-md-8">
                    <form style="float: left;" class="form-inline" method="post" action="{{url('return-sale')}}">

                        {{csrf_field()}}
                        <input class="form-control" type="number" name="quantity" min="0" max="{{$item->quantity}}">

                        <input type="hidden" name="salid" value="{{$item->salid}}">
                        <input type="hidden" name="pid" value="{{$item->Product->pid}}">
                        <input type="hidden" name="srid" value="{{$item->SalesRep->srid}}">
                        <input type="hidden" name="amount" value="{{$item->amount}}">

                        <button class="btn btn-success">Return Product</button>
                    </form>
                </div>
                <br>

                </p>

                <a href="{{url('/return-sale')}}" class="btn btn-warning">Back</a>
            </div>
            </div>
            @endforeach


    </div>

@endsection