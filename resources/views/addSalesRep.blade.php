@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-typical panel panel-default">
            @include('notification')
            <div class="panel-heading">Add Sales Rep</div>
            <div class="box-typical-body panel-body">
                <form method="post" action="{{url('/add-salesrep')}}">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" >
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Phone</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" >
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Email</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" >
                        </div>
                    </div>
                    <br><br>

                    <div class="col-md-6 col-md-offset-4">
                        <button class="btn btn-success">Save</button>
                        <button class="btn btn-warning" type="reset">Clear</button>

                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection