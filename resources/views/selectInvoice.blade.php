@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('notification')
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Find Invoice</div>
                    <div class="box-typical-body panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('invoicing/select-invoice') }}">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('invid') ? ' has-error' : '' }}">
                                <label for="invid" class="col-md-4 control-label">Enter the Invoice ID</label>

                                <div class="col-md-6">
                                    <input id="invid" type="text" class="form-control" name="invid" value="{{ old('invid') }}" required autofocus>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
