@extends('layouts.app')

@section('content')

    <div class="container">
        @include('notification')
        <div class="box-typical panel panel-default">
            <div class="panel-heading">Product Details : {{$product->name}}</div>
            <div class="box-typical-body panel-body">
                <p>
                <div class="col-md-12">
                    <b>Name</b> - <span>{{$product->name}}</span><br>
                    <b>Supply Price</b> - <span>{{$product->supplyPrice}}</span><br>
                    <b>Sale Price</b> - <span>{{$product->salePrice}}</span><br>
                    <b>Supplier</b> - <span> <a href="{{url('supplier/' . $product->Supplier->sid)}}">
                            {{$product->Supplier->name}}
                        </a> </span><br>
                    <b>Date Created</b> - <span>{{$product->created_at}}</span><br>
                </div>

                    <div class="col-md-4">
                    <b>Quantity In Stock</b> - <span>{{$product->quantity}}</span>
                </div><div class="col-md-8">
                    <form style="float: left;" method="post" action="{{url('add-stock')}}" class="form-inline">
                        {{csrf_field()}}
                        <input type="hidden" name="pid" value="{{$product->pid}}">
                        <input class="form-control" type="number" min="0" name="quantity">
                    <button class="btn btn-success">Add Stock</button>
                    </form>
                </div>
                <br>


                </p>

                <a href="{{url('/view-products')}}" class="btn btn-warning">Back</a>
            </div>
        </div>

        <div class="box-typical panel">
            <div class="panel-heading">Update Product</div>
            <div class="box-typical-body panel-body">

                <form method="post" action="{{url('update-product')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="pid" value="{{$product->pid}}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">Supplier</label>
                        <div class="col-md-6">
                            <select class="form-control" name="sid">
                                @foreach($suppliers as $item)
                                    <option value="{{$item->sid}}"
                                    @if($product->Supplier->name == $item->name)
                                        selected
                                    @endif
                                    >{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><br><br>


                    <div class="form-group">
                        <label class="col-md-4 control-label">Category</label>
                        <div class="col-md-6">
                            <select class="form-control" name="catid">
                                @foreach($categories as $item)
                                    <option value="{{$item->catid}}"
                                            @if($product->catid == $item->catid)
                                            selected
                                            @endif

                                    >{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><br><br>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}" >
                        </div>
                    </div><br><br>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Supply Price</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="supplyPrice" min="0" value="{{ $product->supplyPrice }}" >
                        </div>
                    </div><br><br>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Sale Price</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="salePrice" min="0" value="{{ $product->salePrice }}" >
                        </div>
                    </div><br><br>


                    <div class="form-group">
                        <label class="col-md-4 control-label">Description</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                        </div>
                    </div><br><br>

                    <div class="col-md-6 col-md-offset-4">
                        <button class="btn btn-success">Save</button>
                        <button class="btn btn-warning" type="reset">Clear</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection