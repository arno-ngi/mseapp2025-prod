<h1>Expense Request - {{ $expenseRequest->uniqueid }} - {!! getStatus($expenseRequest->status) !!}</h1>
<hr/>
<table>
    <tr>
        <td>Date</td>
        <td> {{$expenseRequest->created_at->format('Y-m-d')}}</td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td> {{$expenseRequest->supplier}}</td>
    </tr>
    <tr>
        <td>Category</td>
        <td> {{$expenseRequest->category->name}}</td>
    </tr>
    <tr>
        <td>Info</td>
        <td> {{$expenseRequest->internal_information}}</td>
    </tr>
    <tr>
        <td>Total cost</td>
        @php
            $number = '';
            if(isset($expenseRequest) && !is_null($expenseRequest->total_cost)) {
                            $number = number_format($expenseRequest->total_cost, 2, ',', '.');
            }
        @endphp
        <td> {{$number}}</td>
    </tr>
    <tr>
        <td>Payment type</td>
        <td> {{$expenseRequest->payment_type}}</td>
    </tr>

    <tr>
        <td>User</td>
        <td> {{\App\Models\User::find($expenseRequest->user_id)->fullname}}</td>
    </tr>


</table>
<br/>
<br/>
<br/>
<table style="border: 1px solid black">
    <thead>
    <tr>
        <th>Quantity</th>
        <th>Descriptions</th>
        <th>Price per unit</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total = 0;
    @endphp
    @foreach($expenseRequest->requestitems as $request_item)
        <tr>
            <td>{{$request_item->quantity}}</td>
            <td>
                {{$request_item->description}}
            </td>
            <td>{!! showEUR2($request_item->price, $invoiceRequest->currency) !!}</td>
        </tr>
        @php
            $total += $request_item->quantity * $request_item->price ;
        @endphp
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td>{!! showEUR2($total, $expenseRequest->currency) !!} </td>
    </tr>
    </tbody>
</table>
