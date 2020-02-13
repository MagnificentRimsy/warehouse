<?php use Illuminate\Support\Facades\Input; ?>
@extends('layouts.app')

@section('content')

    <div class="container">

        <button data-toggle="collapse" class="btn btn-primary" data-target="#filter">Filter</button> <br><br>

        <div id="filter" class="collapse">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-8">
                    <form class="form-inline" style="padding-top: 14px">
                        <label>SEARCH:</label>
                        <input name="term" value="{{Input::get('term')}}" class="form-control">
                        <select name="by" class="form-control">

                            <option value="companyName">Name</option>
                            <option value="phone">Phone</option>
                            <option value="email">Email</option>
                        </select>

                        <button class="btn btn-primary">GO</button>
                        <br>
                    </form>
                </div>

            </div>



            <div class="col-md-7">

            </div>

        </div>

        <div class="row">
            <div class="col-md-12 ">
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">View Clients
                        <br>
                        @if(Input::has('term') && Input::has('by'))
                            <span class="label label-success">
                         Filtered by Search ({{Input::get('by')}}) - {{Input::get('term')}}
                    </span>
                        @endif

                    </div>

                    <div class="box-typical-body panel-body">

                        <table class="table table-hover">

                            <th>Client</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Total Invoices</th>


                           @foreach($clients as $client)
                               <tr>

                                   <td>
                                       <a href="{{url('client-details/' . $client->clid)}}" >
                                           @if(isset($client->companyName))
                                               {{$client->companyName}}
                                           @else
                                               {{$client->fname}} {{$client->sname}}
                                           @endif


                                       </a>
                                   </td>
                                   <td>{{$client->phone}}</td>
                                   <td>{{$client->email}}</td>
                                   <td>{{count($client->Invoice)}}</td>

                               </tr>
                           @endforeach
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
