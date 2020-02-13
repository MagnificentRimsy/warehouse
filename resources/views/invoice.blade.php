<?php use Carbon\Carbon; ?>
<!doctype html>

<html >
<head>
</head>
<style>
    *{padding: 5px;
        margin: 10px;
    }
    body {background-color: white; padding: 30px;
    }
    h1   {color: lightgreen; text-align:center; font-family: sans-serif Arial, Helvetica; font-size: 50px;}
    h2   {color: lightcoral; font-family: sans-serif; font-size:40px; }
    .add{
        text-align: center;
    }
    p{
        margin-bottom: 0px;
        padding-bottom: 0px;
        line-height: 2px;
    }
    .add p{
        color: black;
        font-size: 20px;
        padding: 5px;


    }
    table, th, td {

        border: 1px solid black;
        border-collapse: collapse;

    }

    th, td{
        padding: 15px;
        margin: 5px;

    }
    .info p{
        font-family: sans-serif;
        font-size: 16px;

    }

    .policy p{
        color: orange;
        padding: 10px;

    }

</style>


<body>


<h1 id="h1"> Bronko Housing Agency</h1>
<div class="add">
    <p>Spintex, Accra</p>
    <p>Tel: 0238855069</p>
    <p>E-mail: bronkowa@gmail.com</p>
    <h2> INVOICE </h2>
</div>


<div class="info" >
    <p><strong>Sale Invoice NO. :</strong> #{{ str_pad( $sale->salid, 6, "0", STR_PAD_LEFT)}} </p>

    @if(isset($sale->Details[0]->clid))
    <p> <strong>Customer's Name:  </strong> {{$sale->Details[0]->Client->companyName}} </p>
    <p><strong>Address:</strong> {{$sale->Details[0]->Client->address}}</p>
    @endif
    <p>  <strong>Date:</strong> {{Carbon::createFromFormat("Y-m-d H:i:s",$sale->created_at)->toFormattedDateString() }} </p>
</div>

<div>
    <table style="width:100%">
        <thead>

        <tr class="header">
            <th>S/N</th>
            <th>DESCRIPTION</th>
            <th>QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
        </tr>
        </thead>
        <tbody>

        <?php $count = 1; ?>
        @foreach($sale->Details as $item)
            <tr>
                <td>{{$count}}</td>
                <td>
                    {{$item->Product->name}}
                </td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->amount}}</td>
                <td>{{$item->amount * $item->quantity }}</td>

            </tr>
	        <?php $count++; ?>
        @endforeach

        <tr>
            <td align="right" colspan="5"><b>TOTAL: GHC{{$sale->total}}</b></td>
        </tr>

        </tbody>


    </table>



</div>
<div class="policy">
    <p> The goods delivered are in good condition </p>
    <p> No refund of money after payment</p>
</div>

<div>
    <div class="row">

        <h5>Amount in Words</h5>
        <p style="text-decoration: underline">
            <?php

	        $f = new \NumberFormatter("en", NumberFormatter::SPELLOUT);
	        echo strtoupper($f->format($sale->total));
            ?> NAIRA ONLY
        </p>
    </div>
</div>

<div class="row" style="bottom: 70px;">
    <span  style=" margin-left:70px;">Manager Sign</span>
    <span style="float:right; margin-right:70px;">Customer Sign</span>
</div>




</body>
</html>
