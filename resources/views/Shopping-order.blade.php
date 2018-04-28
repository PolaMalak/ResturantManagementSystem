@extends('layouts.app')

@section('title')
	Laravel Shopping Order
@endsection

@section('content')
	@if(Session::has('order'))
		<div class="row">
			<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
				<ul class='list-group'>
					@foreach($items as $item)
						<li class="list-group-item">
							<span class="badge">{{ $item['qty']}}</span>
							<strong>{{ $item['item']['title']}}</strong>
							<span class="label label-success">{{$item['price']}}</span>
							<div class="btn-group"><button type="button" class="btn btn-primary btn-xs dropdown-toggle"
							data-toggle="dropdown">Action<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#">Reduce by 1</a></li>
								<li><a href="#">Reduce All</a></li>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
				<Strong>Total:{{$totalPrice}}</Strong>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
				<a href="{{route('checkout')}}" type="button" class="btn btn-success">Checkout</a>
			</div>
		</div>

	@else
		<div class="row">
			<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
				<h2>No items in the Order</h2>
			</div>
		</div
	@endif
@endsection	