

@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Add A Client</div>

                    @include('notification')

                    <div class=" box-typical-body panel-body">
                      <form class="form-horizontal" role="form" method="POST" action="{{ url('add-client') }}">
                         {{csrf_field()}}

                          <div class="form-group">
                              <label class="col-md-4 control-label">Company Name</label>
                              <div class="col-md-6">
                                  <input name="companyName" value="{{old('companyName')}}" placeholder="Enter Company Name"class="form-control">
                              </div>
                          </div> <br><br><br>

                          <div class="form-group">
                              <label class="col-md-4 control-label">Phone Number</label>
                              <div class="col-md-6">
                                  <input name="phone" value="{{old('phone')}}" required class="form-control" placeholder="Enter Phone Number">
                              </div>
                          </div> <br><br>

                          <div class="form-group">
                                 <label class="col-md-4 control-label">Address</label>
                                 <div class="col-md-6">
                                 <textarea class="form-control" placeholder="Enter Address" name="address" >
                                     {{old('address')}}
                                 </textarea>
                                 </div>
                          </div> <br><br><br><br>


                             <div class="form-group">
                                 <label class="col-md-4 control-label">Email (Optional)</label>
                                 <div class="col-md-6">
                                    <input name="email" value="{{old('email')}}" required placeholder="Enter Email" class="form-control">
                                 </div>
                             </div> <br><br>


                              <div class="form-group">
                                  <label class="col-md-4 control-label">Sales Rep</label>
                                  <div class="col-md-6">
                                      <select name="srid" class="form-control">
                                          @foreach($salesreps as $item)
                                            <option value="{{$item->srid}}">{{$item->name}}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div><br><br>


                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Add
                                      </button>
                                  </div>
                              </div>

                      </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
