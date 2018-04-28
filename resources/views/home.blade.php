@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Welcome to our resturant !
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                         <h2>My Orders</h2>
                        @foreach($orders as $order)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        @foreach($order->order->items as $item)
                                            <li class="list-group-item">
                                                <span class="badge">{{$item['price']}} $</span>
                                                {{$item['item']['title']}}|{{$item['qty']}} Units
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="panel-footer">
                                    <strong>Total Price: ${{ $order->order->totalPrice}}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
