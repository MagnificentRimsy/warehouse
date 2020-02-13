@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-typical panel panel-default">
            <div class="panel-heading">Supplier Details : {{$supplier->name}}</div>
            <div class="box-typical-body panel-body">
                <p>
                    Name - <span>{{$supplier->name}}</span><br>
                    Phone - <span>{{$supplier->phone}}</span><br>
                    Email - <span>{{$supplier->email}}</span><br>
                    Contact Person Name - <span>{{$supplier->contactPersonName}}</span><br>
                    Contact Person Phone - <span>{{$supplier->contactPersonPhone}}</span><br>
                    Contact Person Email - <span>{{$supplier->contactPersonEmail}}</span><br>
                    Number of Products - <span>{{count($supplier->Products)}}</span>
                </p>
            </div>
        </div>

        <div class="box-typical panel">
            <div class="panel-heading">View Products</div>
            <div class="box-typical-body panel-body">
                <table class="table ">
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Supply Price</th>
                        <th>Sale Price</th>
                        <th>Supplier</th>
                        <th></th>
                    </tr>

                    @foreach($supplier->Products as $product)
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