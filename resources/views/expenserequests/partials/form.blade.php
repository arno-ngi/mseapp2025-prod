@if(Request::has('rfa'))
    @php
        $ir = \App\Models\InvoiceRequest::whereUuid(Request::query('rfa'))->first();
    @endphp
    {{ Form::hidden('invoice_request_id', $ir->id) }}
@endif
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            @if(isset($expenseRequest))
            {{__('law.request_date')}}<br/>
                {{$expenseRequest->created_at->format('Y-m-d')}}
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('supplier', __('law.supplier') , ['class' => 'form-label']) }}
            @if(isset($ir))
                {{ Form::text('supplier', isset($ir) ? $ir->supplier : '', ['class' => $errors->has('supplier') ? 'form-control is-invalid' : 'form-control']) }}
            @else
                {{ Form::text('supplier', isset($expenseRequest) ? $expenseRequest->supplier : '', ['class' => $errors->has('supplier') ? 'form-control is-invalid' : 'form-control']) }}
            @endif
            @if ($errors->has('supplier'))
                <div class="invalid-feedback">{{ $errors->first('supplier') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mt-3 mt-lg-0">
            <div class="mb-3">
                {{ Form::label('category_id', __('law.category'), ['class' => 'form-label']) }}

                <select class="form-select" id="category_id" name="category_id">
                    @if(isset($ir))
                        @foreach(getCategoryArray() as $key => $value)
                            <option value="{{$key}}"{{$ir->category_id == $key ? ' selected': ''}}>{{$value}}</option>
                        @endforeach
                    @else
                        @foreach(getCategoryArray() as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach

                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mt-3 mt-lg-0">
            <div class="mb-3">
                {{ Form::label('currency', __('law.currency'), ['class' => 'form-label']) }}
                {{ Form::select('currency', getCurrencyArray(), null, ['class' => 'form-select']) }}
                @if ($errors->has('currency'))
                    <div
                        class="invalid-feedback">{{ $errors->first('currency') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('internal_information', __('law.internal_information') , ['class' => 'form-label']) }}
            @if(isset($ir))
                {{ Form::text('internal_information', isset($ir) ? $ir->internal_information : '', ['class' => $errors->has('supplier') ? 'form-control is-invalid' : 'form-control']) }}
            @else
                {{ Form::text('internal_information', isset($expenseRequest) ? $expenseRequest->internal_information : '', ['class' => $errors->has('internal_information') ? 'form-control is-invalid' : 'form-control']) }}
            @endif
            @if ($errors->has('internal_information'))
                <div class="invalid-feedback">{{ $errors->first('internal_information') }}</div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('iban', 'IBAN' , ['class' => 'form-label']) }}
            {{ Form::text('iban', isset($expenseRequest) ? $expenseRequest->iban : '', ['class' => $errors->has('total_invoice_amount') ? 'form-control is-invalid' : 'form-control']) }}
            @if ($errors->has('iban'))
                <div class="invalid-feedback">{{ $errors->first('iban') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('total_cost', __('law.total_cost') , ['class' => 'form-label']) }}
            @if(isset($ir))
                @php
                    $totalallowance = $ir->allowances()->sum('allowance_total');
                @endphp
                @php
                    $total = 0;
                @endphp
                @foreach($ir->requestitems as $request_item)
                    @php
                        $total += $request_item->quantity * $request_item->price ;
$alltotal = $totalallowance + $total;
                    @endphp
                @endforeach
                {{ Form::text('total_cost', $alltotal, ['class' => $errors->has('supplier') ? 'form-control is-invalid' : 'form-control']) }}
            @else
                @php
                    $total = 0;
                @endphp
                @if(isset($expenseRequest))
                @foreach($expenseRequest->requestitems as $request_item)
                    @php
                        $total += $request_item->quantity * $request_item->price ;
                    @endphp
                @endforeach
                @endif
                {{ Form::text('total_cost', $total, ['class' => $errors->has('total_cost') ? 'form-control is-invalid' : 'form-control', 'readonly' => 'readonly']) }}
            @endif
            @if ($errors->has('total_cost'))
                <div class="invalid-feedback">{{ $errors->first('total_cost') }}</div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('bankstatement', __('law.bank_statement') , ['class' => 'form-label']) }}
            {{ Form::text('bankstatement', isset($expenseRequest) ? $expenseRequest->bankstatement : '', ['class' => $errors->has('bankstatement') ? 'form-control is-invalid' : 'form-control']) }}
            @if ($errors->has('bankstatement'))
                <div class="invalid-feedback">{{ $errors->first('bankstatement') }}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('payment_type', __('law.payment_type'), ['class' => 'form-label']) }}
            {{ Form::select('payment_type', getPaymentTypeArray(), null, ['class' => 'form-select']) }}
            @if ($errors->has('payment_type'))
                <div
                    class="invalid-feedback">{{ $errors->first('payment_type') }}</div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mt-3 mt-lg-0">
            <div class="mb-3">
                {{ Form::label('user_id', __('law.user'), ['class' => 'form-label']) }}
                <select class="form-select" name="user_id" id="user_id">
                    <option value="0">---</option>

                    @foreach(auth()->user()->tenant->users()->whereIsActive(true)->whereIsClientvisible(true)->get() as $user)
                        <option
                            value="{{$user->id}}"{{ isset($expenseRequest) && $expenseRequest->user_id == $user->id ? ' selected' : '' }}>{{ $user->fullname }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
