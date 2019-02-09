<table>
    <thead>
    <tr>
        <th style="background-color:#C4BD97;" rowspan="2">ID</th>
        <th style="background-color:#C4BD97;" rowspan="2">Name</th>
        <th style="background-color:#C4BD97;" rowspan="2">Price</th>
        <th style="background-color:#C4BD97;" rowspan="2">Quantity</th>
        <th style="background-color:#C4BD97;" rowspan="2">Height</th>
        <th style="background-color:#C4BD97;" rowspan="2">Width</th>
        <th style="background-color:#C4BD97;" colspan="3">Offer</th>
        <th style="background-color:#C4BD97;" rowspan="2">Total earnings (through delivered orders)</th>
    </tr>
    <tr>
        <th style="background-color:#C4BD97;">Percentage</th>
        <th style="background-color:#C4BD97;">Price after discount</th>
        <th style="background-color:#C4BD97;">Ends at</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product -> id }}</td>
            <td>{{ $product -> name }}</td>
            <td>{{ $product -> price }}</td>
            <td>{{ $product -> quantity }}</td>
            <td>{{ $product -> height }}</td>
            <td>{{ $product -> width }}</td>
            @if ($product -> offer)
                <td>{{ $product -> offer -> discount }}</td>
                <td>{{ $product -> price - $product -> offer -> discount * $product -> price }}</td>
                <td>{{ $product -> offer -> ended_at -> toDateString() }}</td>
            @else
                <td colspan="3" style="text-align: center">--</td>
            @endif
            <td style="background-color : #7ab8ff">{{ array_key_exists($product -> id, $totals) ? $totals[$product -> id] : 0 }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">Generated on {{ \Carbon\Carbon::now() -> toDayDateTimeString() }}</td>
        </tr>
    </tfoot>
</table>