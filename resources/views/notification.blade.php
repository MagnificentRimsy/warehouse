<?php use Illuminate\Support\Facades\Session; ?>
        @if(Session::has('success'))
         <div class="alert alert-success"  align="center">{{Session::get('success')}}</div>
            @endif

             @if(Session::has('error'))
                 <div class="alert alert-danger"  align="center">{{Session::get('error')}}</div>
             @endif
