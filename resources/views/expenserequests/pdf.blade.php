<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
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
    <tr>
        <td>IBAN</td>
        <td> {{$expenseRequest->iban}}</td>
    </tr>
</table>

<h5>Approvers</h5>
<table style="border: 1px solid black">
    <thead>
    <tr>
        <th>{{__('law.name')}}</th>
        <th>Status</th>
        <th>{{__('law.date')}}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$expenseRequest->requester->fullname}}</td>
        <td>{{__('law.requester')}}</td>
        <td></td>
    </tr>
    @foreach($expenseRequest->approvers as $approver)
        <tr>
            <td>{{$approver->user->fullname}}</td>
            <td>{!! getStatus($approver->status) !!}
                @if($approver->user_id === auth()->user()->id)
                    @foreach(getStatus2() as $key => $value)
                        @if($key !== 1)
                           {{ $value }}
                        @endif
                    @endforeach
                @endif

            </td>
            <td>
                @if($approver->status === 3 || $approver->status === 4 || $approver->status === 5)
                    {{$approver->updated_at->format('d/m/Y H:i')}}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
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
        <th>Total</th>
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
            <td>{!! showEUR2($request_item->price, $expenseRequest->currency) !!}</td>
            <td>{!! showEUR2(($request_item->quantity * $request_item->price), $expenseRequest->currency) !!}</td>
        </tr>
        @php
            $total += $request_item->quantity * $request_item->price ;
        @endphp
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>{!! showEUR2($total, $expenseRequest->currency) !!} </td>
    </tr>
    </tbody>
</table>
</html>
