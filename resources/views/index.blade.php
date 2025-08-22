@extends('layouts.app')

@section('content')
    <div class="table">
        <tbody>
        <div class="card-body">

            <table>
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            @if(!is_null($approvers))
                                <table id="datatable" class="table table-bordered table-striped table-sm dataTable">
                                    <thead>
                                    <tr>
                                        <th>{{__('law.title')}}</th>
                                        <th>Status</th>
                                        <th>Requester</th>
                                        <th>eID Expires</th> <!-- NEW COLUMN -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($approvers as $approver)
                                        @if(!is_null($approver->approvers))
                                            @php
                                                $isExpired = $approver->approvers->eid_expires && \Carbon\Carbon::now()->gt($approver->approvers->eid_expires);
                                            @endphp
                                            <tr class="{{ $isExpired ? 'table-danger' : '' }}"> <!-- ADDED ROW STYLING -->
                                                <td>
                                                    @if(get_class($approver->approvers) === 'App\Models\ExpenseRequest')
                                                        <a href="{{route('expenserequest.edit', $approver->approvers).'?tab=approvers'}}">{{$approver->approvers->uniqueid}}</a>
                                                    @else
                                                        <a href="{{route('rfa.edit', $approver->approvers).'?tab=approvers'}}">{{$approver->approvers->uniqueid}}</a>
                                                    @endif

                                                </td>
                                                <td>{!! getStatus($approver->status) !!}</td>
                                                <td>{!! ($approver->user->fullname) !!}</td>
                                                <td> <!-- NEW CELL FOR eID EXPIRATION -->
                                                    @if($approver->approvers->eid_expires)
                                                        {{ $approver->approvers->eid_expires->format('Y-m-d') }}
                                                        @if($isExpired)
                                                            <span class="badge badge-danger">EXPIRED</span>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                    @endif
                                    @endforeach

                                </table>
                                <div class="card-body">
                                    <div class="card-title">{{__('law.invoicerequest')}}</div>
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{__('law.requester')}}</th>
                                            <th>{{__('law.requested')}}</th>
                                            <th>Info</th>
                                            <th>{{__('law.amount')}}</th>
                                            <th>{{__('law.final_amount')}}</th>
                                            <th>{{__('law.category')}}</th>
                                            <th>Status</th>
                                            <th>eID Expires</th> <!-- NEW COLUMN -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoiceRequests as $invoiceRequest)
                                            @php
                                                $isExpired = $invoiceRequest->eid_expires && \Carbon\Carbon::now()->gt($invoiceRequest->eid_expires);
                                            @endphp
                                            <tr class="{{ $isExpired ? 'table-danger' : '' }}"> <!-- ADDED ROW STYLING -->
                                                <td> <a href="{{route('rfa.edit', $invoiceRequest)}}">{{$invoiceRequest->uniqueid }}</a></td>
                                                <td>{{ $invoiceRequest->requester->fullname }}</td>
                                                <td>{{ $invoiceRequest->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $invoiceRequest->internal_information }}</td>
                                                <td>{!! showEUR2($invoiceRequest->total_invoice_amount, $invoiceRequest->currency) !!}</td>
                                                <td>{!! showEUR2($invoiceRequest->final_amount, $invoiceRequest->currency) !!}</td>
                                                <td>{{  $invoiceRequest->category->name }}</td>
                                                <td>{!! getStatus($invoiceRequest->status) !!}</td>
                                                <td> <!-- NEW CELL FOR eID EXPIRATION -->
                                                    @if($invoiceRequest->eid_expires)
                                                        {{ $invoiceRequest->eid_expires->format('Y-m-d') }}
                                                        @if($isExpired)
                                                            <span class="badge badge-danger">EXPIRED</span>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="card-title">{{__('law.expenserequest')}}</div>

                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{__('law.requester')}}</th>
                                            <th>{{__('law.requested')}}</th>
                                            <th>Info</th>
                                            <th>{{__('law.amount')}}</th>
                                            <th>{{__('law.category')}}</th>
                                            <th>Status</th>
                                            <th>{{__('law.beneficiary')}}</th>
                                            <th>eID Expires</th> <!-- NEW COLUMN -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($expenseRequests as $expenseRequest)
                                            @php
                                                $isExpired = $expenseRequest->eid_expires && \Carbon\Carbon::now()->gt($expenseRequest->eid_expires);
                                            @endphp
                                            <tr class="{{ $isExpired ? 'table-danger' : '' }}"> <!-- ADDED ROW STYLING -->
                                                <td><a href="{{route('expenserequest.edit', $expenseRequest)}}">{{$expenseRequest->slug }}</a></td>
                                                <td>{{ $expenseRequest->requester->fullname }}</td>
                                                <td>{{ $expenseRequest->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $expenseRequest->internal_information }}</td>
                                                <td>{!! showEUR2($expenseRequest->total_cost, $expenseRequest->currency) !!}</td>
                                                <td>{{  $expenseRequest->category->name }}</td>
                                                <td>{!! getStatus($expenseRequest->status) !!}</td>
                                                <td>{{ !is_null($expenseRequest->user_id) ? $expenseRequest->user->fullname : "" }}</td>
                                                <td> <!-- NEW CELL FOR eID EXPIRATION -->
                                                    @if($expenseRequest->eid_expires)
                                                        {{ $expenseRequest->eid_expires->format('Y-m-d') }}
                                                        @if($isExpired)
                                                            <span class="badge badge-danger">EXPIRED</span>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                        </div>

                    </div></div></table></div></tbody></div></table>
    @endif

    <style>
        .table-danger {
            background-color: #f8d7da !important;
        }
        .table-danger:hover {
            background-color: #f5c6cb !important;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.75em;
        }
    </style>

@endsection
