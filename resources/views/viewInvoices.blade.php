@extends('layouts.app')

@section('content')


    <style>


        div.container {
            background-color: rgba(255,255,255,0.9);
            padding: 30px;
        }

    </style>

    <div class="container">
        <table class="table table-responsive table-hover">
            <tr>

                <th>Invoice ID</th>
                <th>Client</th>
                <th>Title</th>
                <th>Currency</th>
                <th>Total</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>

            <?php $index = 0; // variable used for looping through paid array ?>

            @foreach($invoices as $item)
                <tr>

                    <td>
                        <a href="{{url('invoice-details/' . $item->invid)}}">
                            {{ str_pad( $item->invid, 6, "0", STR_PAD_LEFT)}}
                        </a>

                    </td>
                    <td>

                        <a href="{{url('client-details/'. $item->clid)}}" >
                            @if(isset($item->Client->companyName))
                            {{$item->Client->companyName}}
                            @else
                            {{$item->Client->fname}} {{$item->Client->sname}}
                            @endif
                         </a>
                    </td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->currency}}</td>
                    <td>{{$item->total}}</td>
                    <td>

                        @if($paid[$index] >= $item->total)
                            Fully Paid
                        @endif

                        @if($paid[$index] < $item->total && $paid[$index] > 0)
                            Partially Paid
                        @endif

                        @if($paid[$index] == 0)
                            Un-Paid
                        @endif


                    </td>
                    <td>
                        <a href="{{url('invoice-details/' . $item->invid)}}">
                            View
                        </a>
                    </td>
                    <td>
                        <a href="{{url('create-receipt?invoice=' . $item->invid)}}">
                            Add Payment
                        </a>
                    </td>
                </tr>
                <?php $index++; ?>
            @endforeach
        </table>
    </div>

@endsection