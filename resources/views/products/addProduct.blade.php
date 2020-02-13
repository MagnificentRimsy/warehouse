@extends('layouts.app')

@section('content')

<div class="container">
    @include('notification')
    <div class="box-typical panel panel-default">
        <div class="panel-heading">Add a products</div>
        <div class="box-typical-body panel-body">
            <form method="post" action="{{url('add-product')}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label class="col-md-4 control-label">Supplier</label>
                    <div class="col-md-6">
                        <select name="sid" class="form-control">
                            @foreach($suppliers as $item)
                                <option value="{{$item->sid}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br><br>


                <div class="form-group">
                    <label class="col-md-4 control-label">Category</label>
                    <div class="col-md-6">
                        <select name="catid" class="form-control">
                            @foreach($categories as $item)
                                <option value="{{$item->catid}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br><br>

                <div class="form-group">
                <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" >
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label class="col-md-4 control-label">Quantity</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" >
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label class="col-md-4 control-label">Supply Price</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="supplyPrice" value="{{ old('supplyPrice') }}" >
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label class="col-md-4 control-label">Sale Price</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="salePrice" value="{{ old('salePrice') }}" >
                    </div>
                </div><br><br>


                <div class="form-group">
                    <label class="col-md-4 control-label">Description</label>
                    <div class="col-md-6">
                        <textarea name="description" class="form-control">{{old('description')}}</textarea>
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