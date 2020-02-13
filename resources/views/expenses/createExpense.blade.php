@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box-typical panel panel-default">
                    <div class="panel-heading">Create Rent Expense</div>

                    @include('notification')

                    <div class="box-typical-body panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('create-expense') }}">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Title</label>
                                    <div class="col-md-6">
                                        <input name="shortDesc" value="{{old('shortDesc')}}" placeholder="Enter a brief description" maxlength="100" required class="form-control">
                                    </div>
                                </div> <br><br>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Details</label>
                                    <div class="col-md-6">
                                 <textarea class="form-control" placeholder="Enter full details" name="longDesc" >
                                     {{old('longDesc')}}
                                 </textarea>
                                    </div>
                                </div> <br><br><br>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Is it recurring?</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="isRecurring">
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div><br><br>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Schedule</label>
                                    <div class="col-md-6">
                                        <input name="schedule" value="{{old('schedule')}}" required placeholder="Enter the period of recurrence in days" class="form-control">
                                    </div>
                                </div><br><br>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Rent Product Category</label>
                                    <div class="col-md-6">
                                        <select name="department" class="form-control">
                                            <option>Automobiles</option>
                                            <option>Frozen Foods and Consumables</option>
                                            <option>Building Materials and Funitures</option>
                                            <option>Wood Timbers</option>
                                            <option>Construction Materials</option>
                                            <option>Electronics</option>
                                            <option>Educational Materials</option>
                                            <option>Health Materials</option>
                                            <option>Computer and Accessories</option>
                                        </select>
                                    </div>
                                </div><br><br>

                                <table id="table" class="col-md-10 table table-hover">
                                    <tr style="background-color: #006400; color:white">
                                        <th>Item</th>
                                        <th class="priceTH">Price</th>
                                        <th></th>
                                    </tr>

                                    <tr>
                                        <td><textarea class="form-control" name="item[]" required></textarea></td>
                                        <td class="priceTD"><input class="form-control price" type="text" name="price[]" required></td>
                                        <td><a  class="remove btn btn-danger">Remove</a> </td>
                                    </tr>
                                </table>


                                <div class="form-group">
                                    <div class="col-md-12" align="center">
                                        <a class="btn btn-primary" id="addItem">Add Item</a> <br><br>
                                        <button type="submit" class="btn btn-success" >
                                            Create
                                        </button>

                                    </div>
                                </div>


                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){

            function updateTotal(){
                var price = $('.price');

                var totalPrice = 0;

                for(var i =0; i < price.length; i++){
                    totalPrice += Number($(price[i]).val());
                }

                $('#total').val(totalPrice);
                $('.total').text(totalPrice);


                console.log("called");
            };

            function removeItem(){
                $(this).parent().parent().remove();
                updateTotal();
            }

            $(document).on('keyup','.price',updateTotal);
            $(document).on('click','.remove',removeItem);

            $('#addItem').on('click',function(){
                var tr = '<tr> ' +
                    '<td><textarea class="form-control" name="item[]" required></textarea></td> ' +
                    '<td><input class="form-control price" type="text"  name="price[]" required></td> ' +
                    ' <td><a  class="remove btn btn-danger">Remove</a> </td>' +
                    '</tr>';

                $('#table').append(tr); // adds a new row


            });
        });
    </script>



@endsection