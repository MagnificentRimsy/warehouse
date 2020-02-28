@extends('layouts.app')

@section('content')
<div class="container">
    @include('notification')
    <div class="row">
        <div class="col-md-12 col-md-offset-2">

            <div class="row">

                <div class="col-md-12">
                    <div class="row">
                        <a href="{{url('view-products')}}">
                            <div class="col-sm-6">
                                <article class="statistic-box red">
                                    <div>
                                        <div class="number">{{$products}}</div>
                                        <div class="caption"><div>Products</div></div>
                                    </div>
                                </article>
                            </div><!--.col-->
                        </a>

                        <a href="{{url('view-salesreps')}}">
                            <div class="col-sm-6">
                                <article class="statistic-box purple">
                                    <div>
                                        <div class="number">{{$salesReps}}</div>
                                        <div class="caption"><div>Sales Reps</div></div>
                                    </div>
                                </article>
                            </div><!--.col-->
                        </a>

                        <a href="{{url('view-sales')}}">
                            <div class="col-sm-6">
                                <article class="statistic-box yellow">
                                    <div>
                                        <div class="number">&#x20B5;{{number_format($sales)}}</div>
                                        <div class="caption"><div>Total Sales</div></div>
                                        <div class="percent">
                                            {{--<div class="arrow down"></div>--}}
                                            {{--<p>5%</p>--}}
                                        </div>
                                    </div>
                                </article>
                            </div><!--.col-->
                        </a>

                        <a href="{{url('view-products?numBy=quantity&min=0&max='. Session::get('settings')->lowStock)}}">
                            <div class="col-sm-6">
                                <article class="statistic-box green">
                                    <div>
                                        <div class="number">{{$lowStock}}</div>
                                        <div class="caption"><div>Products with Low Stock</div></div>
                                        <div class="percent">
                                            {{--<div class="arrow up"></div>--}}
                                            {{--<p>84%</p>--}}
                                        </div>
                                    </div>
                                </article>
                            </div><!--.col-->
                        </a>
                    </div><!--.row-->
                </div><!--.col-->
            </div><!--.row-->


            {{-- <div class="box-typical panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="box-typical-body panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{url('export')}}" class="btn btn-primary">Export</a>

                            <button data-toggle="collapse" class="btn btn-primary" data-target="#filter">Import</button> <br><br>

                            <div id="filter" class="collapse">
                                <form class="form-inline" enctype="multipart/form-data" method="post" action="{{url('import')}}" style="padding-top: 14px">
                                    {{csrf_field()}}
                                        <label>SELECT EXPORT FILE:</label>
                                        <input required name="file" type="file" class="form-control">
                                        <button class="btn btn-primary">GO</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


        </div>

    </div>
</div>
@endsection
