@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="box-typical panel panel-default">
            @include('notification')
            <div class="panel-heading">Settings</div>
            <div class="box-typical-body panel-body">
                <p>
                    VAT - <span>{{$webSettings->vat}}</span><br>
                    Low Stock - <span>{{$webSettings->lowStock}}</span><br>
                </p>

                <form method="post" action="{{url('/settings')}}">
                    {{csrf_field()}}
                    <div class="form-group">

                        <div class="col-md-4">
                            <label>Top Menu</label>
                        </div>

                        <div class="col-md-8">
                            <input name="topMenu" type="checkbox" class="checkbox"

                                   @if(Session::get('settings')->topMenu == 1)
                                   checked
                                    @endif
                            >
                        </div>

                        <div class="form-group">
                        <label class="col-md-4 control-label">VAT</label>
                        <div class="col-md-6">
                            <input name="vat" value="{{$webSettings->vat}}" required placeholder="Enter VAT Percentage" class="form-control"><br>
                        </div>
                    </div> <br><br>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Low Stock Value</label>
                            <div class="col-md-6">
                                <input name="lowStock" value="{{$webSettings->lowStock}}" required placeholder="Enter the value for low stock" class="form-control">
                            </div>
                        </div> <br><br>

                        <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Change
                            </button>
                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>

@endsection