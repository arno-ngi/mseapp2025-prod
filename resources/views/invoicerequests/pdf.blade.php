<h1>RFA - {{ $invoiceRequest->uniqueid }} - {!! getStatus($invoiceRequest->status) !!}</h1>
<hr/>
<table>
    <tr>
        <td>Date</td>
        <td> {{$invoiceRequest->created_at->format('Y-m-d')}}</td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td> {{$invoiceRequest->supplier}}</td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td> {{$invoiceRequest->supplier}}</td>
    </tr>
    <tr>
        <td>Category</td>
        <td> {{$invoiceRequest->category->name}}</td>
    </tr>
    <tr>
        <td>Info</td>
        <td> {{$invoiceRequest->internal_information}}</td>
    </tr>
    <tr>
        <td>Budget</td>
        @php
            $number = '';
            if(isset($invoiceRequest) && !is_null($invoiceRequest->total_invoice_amount)) {
                            $number = number_format($invoiceRequest->total_invoice_amount, 2, ',', '.');
            }
        @endphp
        <td> {{$number}}</td>
    </tr>
    <tr>
        <td>Extra info</td>
        <td> {{$invoiceRequest->extra_info}}</td>
    </tr>
    <tr>
        <td>Factuurbedrag</td>
        @php
            $number2 = '';
            if(isset($invoiceRequest) && !is_null($invoiceRequest->final_amount)) {
                            $number2 = number_format($invoiceRequest->final_amount, 2, ',', '.');
            }
        @endphp
        <td> {{$number2}}</td>
    </tr>
     <tr>
        <td>Final amount reason</td>
        <td> {{$invoiceRequest->final_amount_reason}}</td>
    </tr>

     <tr>
        <td>Environment assesment</td>
        <td> {{$invoiceRequest->environment_assesment}}</td>
    </tr>

     <tr>
        <td>Safety assesment</td>
        <td> {{$invoiceRequest->safety_assesment}}</td>
    </tr>

</table>
<br/>
<br/>
<br/>
<table style="border: 1px solid bl">
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
    @foreach($invoiceRequest->requestitems as $request_item)
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
        <td>{!! showEUR2($total, $invoiceRequest->currency) !!} </td>
    </tr>
    </tbody>
</table>
