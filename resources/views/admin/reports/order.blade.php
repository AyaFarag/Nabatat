<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
	<thead>
		<tr>
			<th style="background-color:#C4BD97;" rowspan="2">ID</th>
			<th style="background-color:#C4BD97;" rowspan="2">City</th>
			<th style="background-color:#C4BD97;" rowspan="2">Status</th>
			<th style="background-color:#C4BD97;" colspan="4">Client</th>
			<th style="background-color:#C4BD97;" colspan="5">Products</th>
		</tr>
		<tr>
			<th style="background-color:#C4BD97;">Name</th>
			<th style="background-color:#C4BD97;">Email</th>
			<th style="background-color:#C4BD97;">Phone Numbers</th>
			<th style="background-color:#C4BD97;">Address</th>
			<th style="background-color:#C4BD97;">Name</th>
			<th style="background-color:#C4BD97;">Regular Price</th>
			<th style="background-color:#C4BD97;">Discounted Price</th>
			<th style="background-color:#C4BD97;">Quantity</th>
			<th style="background-color:#C4BD97;">Total</th>
		</tr>
	</thead>
	<tbody>
		@php
			$grand_total = 0;
		@endphp
		@foreach ($orders as $order)
			<tr>
				<td>{{ $order -> id }}</td>
				<td>{{ $order -> address -> city -> name }}</td>
				@if ($order -> status == \App\Models\Order::PENDING)
                 	<td style="background-color:#ffff00;">PENDING</td>
                @elseif ($order -> status == \App\Models\Order::CONFIRMED)
                 	<td style="background-color:#0000ff; color : #FFF;">CONFIRMED</td>
                @elseif ($order -> status == \App\Models\Order::ON_THE_WAY)
					<td style="background-color:#87cefa;">ON THE WAY</td>
                @elseif ($order -> status == \App\Models\Order::RETURNED)
                 	<td style="background-color:#b22222; color : #FFF;">RETURNED</td>
                @elseif ($order -> status == \App\Models\Order::DELIVERED)
                 	<td style="background-color:#20da20; color : #FFF;">DELIVERED</td>
                @endif
				<td>{{ $order -> user -> name }}</td>
				<td>{{ $order -> user -> email }}</td>
				<td>{{ $order -> user -> phones -> pluck("phone") -> implode(" , ") }}</td>
				<td>{{ $order -> address -> address }}</td>
			</tr>
			@php
				$products_total_price = 0;
			@endphp
			@forelse ($order -> products as $product)
				@php
					$single_product_total = $product -> pivot -> price * $product -> pivot -> quantity;
					$products_total_price += $single_product_total;
				@endphp
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $product -> name }}</td>
					<td>{{ $product -> pivot -> regular_price }}</td>
					<td>{{ $product -> pivot -> price }}</td>
					<td>{{ $product -> pivot -> quantity }}</td>
					<td style="background-color: #e7ff7c;">{{ $single_product_total }}</td>
				</tr>
				@if ($loop -> last)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="background-color: #7ab8ff">Total</td>
						<td style="background-color: #7ab8ff"><b>{{ $products_total_price }}</b></td>
					</tr>
				@endif
			@empty
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td colspan="5">No products</td>
				</tr>
			@endforelse
			@php
				$grand_total += $products_total_price;
			@endphp
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="12" style="background-color:#ff60f9;"><b>Grand Total : {{ $grand_total }}</b></td>
		</tr>
		<tr>
			<td colspan="12">Generated on {{ \Carbon\Carbon::now() -> toDayDateTimeString() }}</td>
		</tr>
	</tfoot>
</table>