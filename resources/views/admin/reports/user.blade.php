<table>
    <thead>
    <tr>
        <th style="background-color:#C4BD97;" rowspan="2">ID</th>
        <th style="background-color:#C4BD97;" rowspan="2">Name</th>
        <th style="background-color:#C4BD97;" rowspan="2">Email</th>
        <th style="background-color:#C4BD97;" rowspan="2">Join Date</th>
        <th style="background-color:#C4BD97;" rowspan="2">Phone Numbers</th>
        <th style="background-color:#C4BD97;" rowspan="2">Account Status</th>
        <th style="background-color:#C4BD97;" colspan="2">Addresses</th>
        <th style="background-color:#C4BD97;" rowspan="2">Total money spent</th>
    </tr>
    <tr>
        <th style="background-color:#C4BD97;">Address</th>
        <th style="background-color:#C4BD97;">City</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user -> id }}</td>
            <td>{{ $user -> name }}</td>
            <td>{{ $user -> email }}</td>
            <td>{{ $user -> created_at -> toDayDateTimeString() }}</td>
            <td>{{ $user -> phones -> pluck("phone") -> implode(", ") }}</td>
            <td style="background-color : {{ $user -> status ? "#00FF00" : "#FF0000" }}">{{ $user -> status ? "VERIFIED" : "NOT VERIFIED" }}</td>
            <td></td>
            <td></td>
            <td style="background-color : #7ab8ff">{{ $user -> money_spent }}</td>
        </tr>
        @foreach ($user -> addresses as $address)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $address -> address }}</td>
                <td>{{ $address -> city -> name }}</td>
                <td></td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9">Generated on {{ \Carbon\Carbon::now() -> toDayDateTimeString() }}</td>
        </tr>
    </tfoot>
</table>