@extends('layouts.app')

@section('content')

<div class="container">
    @include('notification')
    <div class="box-typical panel panel-default">
        <div class="panel-heading">Add a category</div>
        <div class="box-typical-body panel-body">
            <form method="post" action="{{url('add-category')}}">
                {{csrf_field()}}

                <div class="form-group">
                <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" >
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