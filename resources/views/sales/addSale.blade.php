<?php use Illuminate\Support\Facades\Session; ?>
@extends('layouts.app')

@section('content')

    <div align="center" class="container" style=" padding: 20px;">


        @if(Session::has('success'))
            <div class="alert alert-success"  align="center">{!! Session::get('success') !!}</div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger"  align="center">{{Session::get('error')}}</div>
        @endif


        <div class="box-typical panel panel-default">
            <div class="panel-heading">

            </div>
            <div class="box-typical-body panel-body">

                <form method="post" action="{{url('add-sale')}}"  class="form-horizontal" id="form" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                    <div class="form-group row">
                        <label class="col-md-4 control-label">Sale To:</label>

                        <div class="col-md-6">
                            <select class="form-control" required id="choice" name="choice" onchange="check()">
                                    <option disabled class="disabled" selected>Choose</option>
                                    <option>Sales Rep</option>
                                    <option>Client</option>
                            </select>
                        </div>
                    </div>

                    <script>
                        function check(){
                            var client = $('#client');
                            var salesRep = $('#salesrep');
                            var choice = $('#choice');

                            if(choice.val() === "Sales Rep"){
                                client.addClass('hidden');
                                salesRep.removeClass('hidden');
                            } else {
                                salesRep.addClass('hidden');
                                client.removeClass('hidden');
                            }
                        }
                    </script>


                    <div class="form-group row hidden" id="client">
                        <label class="col-md-4 control-label">Client:</label>

                        <div class="col-md-6">
                            <select class="form-control" name="clid">
                                @foreach ($clients as $client)
                                    <option value="{{$client->clid}}">{{$client->companyName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row hidden" id="salesrep">
                        <label class="col-md-4 control-label">Sales Rep:</label>

                        <div class="col-md-6">
                            <select name="srid" class="form-control">
                                @foreach($salesReps as $item)
                                    <option value="{{$item->srid}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-4 control-label">Payment:</label>

                        <div class="col-md-6" align="left">

                            <select class="form-control" name="payment">
                                <option>Cash</option>
                                <option>Credit</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">

                        <table id="table" class="col-md-10 table table-hover">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th class="quantityTH">Quantity</th>
                                <th></th>
                            </tr>

                            <tr>
                                <td>
                                    <select class="productSelect form-control" name="pid[]" data-serial="0">
                                        <option disabled selected>Select a product</option>

                                        @foreach($products as $item)
                                        <option data-price="{{$item->salePrice}}"  value="{{$item->pid}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="priceTD price" id="price0"></td>
                                <td class="quantityTD">
                                    <input class="form-control quantity" type="number" min="1" name="quantity[]" required>
                                </td>
                                <td><a  class="remove btn btn-danger">Remove</a> </td>
                            </tr>
                        </table>

                    </div>


                    <a class="btn btn-primary" id="addItem">Add Item</a> <br><br>

                    <script>
                        $(document).ready(function(){
    
                            var count = 0;
                            function updateTotal(data){
                                var price = $('.price');
                                var quantity = $('.quantity');
    
                                var totalPrice = 0;
    
                                for(var i =0; i < price.length; i++){
                                    totalPrice += Number($(quantity[i]).val()) * Number($(price[i]).text());
                                }
    
                                $('#total').val(totalPrice);
                                $('.total').text(totalPrice);
                                console.log("Datavalue", data);
                                    let total = 0;
                               data.filter(item =>{
                                total += item.quantity * item.salePrice
                               }) 
                                document.querySelector('.total').innerHTML = total
                                console.log("Data", Math.abs(total));
                        
                            };
    
                            function removeItem(){
                                $(this).parent().parent().remove();
                                updateTotal();
                            }
    
                            function showPrice(item){
                                var serial = item.target.parentElement.dataset.serial;
                                var price = item.target.dataset.price;
    
                                console.log(item.target);
                                console.log(item.target.parentElement);
                                $('#price' + serial).text(price);
                            }
    
    
                            $(document).on('click','.productSelect',showPrice);
                            $(document).on('keyup','.quantity',updateTotal);
                            $(document).on('click','.remove',removeItem);
    
                            $('#addItem').on('click',function(){
    
                                count++;
                                var data;
                                $.ajax({
                                    url:"<?php echo url('api/products'); ?>",
                                    method: "get",
                                    success: function (success) {
    
                                        console.log(count);
                                        var options = '';
                                        var products = success;
    
                                        for(var i = 0; i < products.length; i++){
                                            options += '+ <option data-price="'+ products[i].salePrice +'"  value="'+ products[i].pid +'">'+ products[i].name +'</option>'
                                        }
                                        console.log(success);
                                        updateTotal(success);
    
                                        var tr = '<tr> <td>' +
                                            '<select class="productSelect form-control" name="pid[]" data-serial="'+ count +'">' +
                                            '<option disabled selected>Select a product</option>'+
                                            options +
                                            '</select>' +
                                            '</td>' +
                                            '<td  class="priceTD price" id="price'+ count + '"></td> ' +
                                            '<td class="quantityTD">' +
                                            '<input class="form-control quantity" min="1" type="number" name="quantity[]">' +
                                            '</td>' +
                                            ' <td><a  class="remove btn btn-danger">Remove</a> </td>' +
                                            '</tr>';
    
                                        $('#table').append(tr); // adds a new row
    
    
                                    },
                                    error: function (error) {
                                        console.log(error);
                                    }
                                });
    
    
                            });
                        });
                    </script>
                    
                    <div class="form-group">
                        <label class=" control-label">Total: &#x20B5;<span class="total">0</span> </label>
                        <input type="hidden" id="total" name="total" class="form-control" value="{{ old('total') }}">
                    </div>

                    <button  id="addDocument" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>

    </div>
@endsection