<?php
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('content')

     <div class="container">
         @include('notification')
         <button data-toggle="collapse" class="btn btn-primary" data-target="#filter">Filter</button> <br><br>

         <div id="filter" class="collapse">
             <div class="row">
                 <div class="col-md-3"></div>
                 <div class="col-md-8">
                     <form class="form-inline" style="padding-top: 14px">
                         <label>SEARCH:</label>
                         <input name="term" value="{{Input::get('term')}}" class="form-control">
                         <select name="by" class="form-control">

                             <option value="name">Name</option>
                         </select>

                         <button class="btn btn-primary">GO</button>
                         <br>
                     </form>
                 </div>

             </div>

         </div>

             <div class="box-typical panel panel-default">
             <div class="panel-heading">View Categories
                 <br>
                 @if(Input::has('term') && Input::has('by'))
                     <span class="label label-success">
                         Filtered by Search ({{Input::get('by')}}) - {{Input::get('term')}}
                    </span>
                 @endif

             </div>
             <div class="box-typical-body panel-body">
                 <span style="float:right;">There are {{count($categories)}} categories</span>
                 <table class="table table-hover">
                     <tr>
                         <th>Name</th>
                         <th>Date Created</th>
                         <th></th>
                     </tr>

                     @foreach($categories as $category)
                         <tr>
                             <td>{{$category->name}}</td>
                             <td>{{Carbon::createFromFormat("Y-m-d H:i:s",$category->created_at)->toDateTimeString()}}</td>
                             <td>
                                 <a href="{{url('delete-category/' . $category->catid)}}" class="btn btn-danger">Delete</a>
                             </td>
                         </tr>
                     @endforeach
                 </table>
             </div>
         </div>
     </div>

@endsection