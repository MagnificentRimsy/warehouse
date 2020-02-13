<?php use Carbon\Carbon; use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

    <div class="box-typical panel panel-default">
        <div class="panel-heading"> Expenses Dashboard  </div>

        <div class="box-typical-body panel-body">

            <div class="col-md-6 col-md-offset-3">
                <form class="form-inline" style="padding-top: 14px">
                    <label >SEARCH:</label>
                    <input name="term" type="text" value="{{Input::get('term')}}" class="form-control">
                    <select name="by" class="form-control">
                        <option value="shortDesc">Title</option>
                        <option value="longDesc">Details</option>
                        <option value="department">Department</option>
                        <option value="amount">Amount</option>
                    </select>

                    <button class="btn btn-primary">GO</button>
                    <br>
                </form>

            </div>

            <table id="table" class="table table-hover table-stripped  ">

                <tr>
                    <th>Expense</th>
                    <th>Dept</th>
                    <th>Amount</th>
                    <th>Next Due Date</th>
                    <th></th>
                </tr>

                @foreach($expenses as $item)

                <tr class="table table-striped">

                    <td>
                        <a href="{{url('view/' . $item->exid)}}">
                        {{$item->shortDesc}}
                        </a>
                    </td>
                    <td>{{$item->longDesc}}</td>
                    <td>{{$item->amount}}</td>
                    <td>{{  Carbon::createFromFormat("Y-m-d H:i:s",$item->nextPayment)->toFormattedDateString()}}</td>


                </tr>
                @endforeach
            </table>

        </div>
    </div>




@endsection