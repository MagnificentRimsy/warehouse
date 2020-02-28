<?php use Illuminate\Support\Facades\Session; ?>
@extends('layouts.app')

@section('content')

<div align="center" class="container" style=" padding: 20px;">

    @include('notification')

    <div class="box-typical panel panel-default">
        <div class="panel-header">

        </div>
        <div class="box-typical-body panel-body">

            <form method="post" action="{{url('add-sale')}}"  class="form-horizontal" id="form" enctype="multipart/form-data" >
                <input type="hidden" name="_token" value="{{csrf_token()}}">


                <div class="form-group row">
                    <label class="col-md-4 control-label">Sale To:</label>

                    <div class="col-md-6">
                    <select class="form-control" id="choice" name="choice" onchange="check()" required>
                        <option disabled class="disabled"> Choose</option>
                        <option>Sales Rep</option>
                        <option>Client</option>
                    </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-md-4 control-label">Currency:</label>

                    <div class="col-md-6">
                        <select class="form-control" name="currency">
                            <option>GHC</option>
                            <option>USD</option>
                        </select>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-4 control-label">Title</label>
                    <div class="col-md-6">
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="row">

                <table id="table" class="col-md-10 table table-hover">
                    <tr>
                        <th>Item</th>
                        <th class="quantityTH">Price</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td>
                            <textarea class="form-control" name="item[]" required></textarea>
                        </td>

                        <td class="priceTD"><input class="form-control price" type="text" name="price[]" required></td>
                        <td><a  class="remove btn btn-danger">Remove</a> </td>
                    </tr>
                </table>

                </div>


                <a class="btn btn-primary" id="addItem">Add Item</a> <br><br>

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



                <div class="form-group">
                    <label class=" control-label">Total: GHC<span class="total">0</span> </label>
                    <input type="hidden" id="total" name="total" class="form-control" value="{{ old('total') }}">
                </div>

                <button  id="addDocument" class="btn btn-success">Create</button>


            </form>

        </div>
    </div>

</div>
@endsection