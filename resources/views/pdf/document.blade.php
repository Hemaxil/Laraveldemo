<h1>Orders</h1>

<table class="table">
	<tr>
		<th>Order Id</th>
		<th>Order Amount</th>
		<th>Payment Method</th>
		<th>Order Status</th>
	</tr>

	@foreach($orders as $order)
	<tr>
	<td>{{$order->id}}</td>
	<td>{{$order->grand_total}}</td>
	<td>@if($order->payment_gateway_id==1)COD @else Paypal @endif</td>
	<td>{{$order->status}}</td>
	</tr>
	@endforeach


</table>
<style type="text/css">
	table,th,td{
		border:1px solid;

	}
	th,td{
		width:100%;
	}
</style>