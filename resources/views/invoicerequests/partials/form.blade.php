<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('invoice_date', __('law.invoice_date') , ['class' => 'form-label']) }}
            {{ Form::text('invoice_date', isset($invoiceRequest) ? $invoiceRequest->invoice_date->format('Y-m-d') : '', ['class' => $errors->has('invoice_date') ? 'form-control is-invalid' : 'form-control']) }}
            @if ($errors->has('invoice_date'))
                <div class="invalid-feedback">{{ $errors->first('invoice_date') }}</div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('supplier', __('law.supplier') , ['class' => 'form-label']) }}
            {{ Form::text('supplier', isset($invoiceRequest) ? $invoiceRequest->supplier : '', ['class' => $errors->has('supplier') ? 'form-control is-invalid' : 'form-control']) }}
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
                {{ Form::select('category_id', getCategoryArray(), null, ['class' => 'form-select']) }}
                @if ($errors->has('category_id'))
                    <div
                        class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                @endif
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
            {{ Form::text('internal_information', isset($invoiceRequest) ? $invoiceRequest->internal_information : '', ['class' => $errors->has('internal_information') ? 'form-control is-invalid' : 'form-control']) }}
            @if ($errors->has('internal_information'))
                <div class="invalid-feedback">{{ $errors->first('internal_information') }}</div>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        @php
        $number = '';
        if(isset($invoiceRequest) && !is_null($invoiceRequest->total_invoice_amount)) {
                        $number = ': ' . number_format($invoiceRequest->total_invoice_amount, 2, ',', '.');
        }
        @endphp
        <div class="mb-3">
            {{ Form::label('total_invoice_amount', 'Budget' . $number , ['class' => 'form-label']) }}
            {{ Form::text('total_invoice_amount', isset($invoiceRequest) ? $invoiceRequest->total_invoice_amount : '', ['class' => $errors->has('total_invoice_amount') ? 'form-control is-invalid' : 'form-control']) }}
            @if ($errors->has('total_invoice_amount'))
                <div class="invalid-feedback">{{ $errors->first('total_invoice_amount') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('extra_info', __('law.extra_info') , ['class' => 'form-label']) }}
            {{ Form::text('extra_info', isset($invoiceRequest) ? $invoiceRequest->extra_info : '', ['class' => $errors->has('extra_info') ? 'form-control is-invalid' : 'form-control']) }}
            @if ($errors->has('extra_info'))
                <div class="invalid-feedback">{{ $errors->first('extra_info') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mt-3 mt-lg-0">
            <div class="mb-3">
                {{ Form::label('safety_assesment', __('law.safety_assesment'), ['class' => 'form-label']) }}
                {{ Form::select('safety_assesment', getStatusSafety(), null, ['class' => 'form-select']) }}
                @if ($errors->has('safety_assesment'))
                    <div
                        class="invalid-feedback">{{ $errors->first('safety_assesment') }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mt-3 mt-lg-0">
            <div class="mb-3">
                {{ Form::label('environment_assesment', __('law.environment_assesment'), ['class' => 'form-label']) }}
                {{ Form::select('environment_assesment', getStatusEnvironment(), null, ['class' => 'form-select']) }}
                @if ($errors->has('environment_assesment'))
                    <div
                        class="invalid-feedback">{{ $errors->first('environment_assesment') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@if(isset($invoiceRequest) && $invoiceRequest->safety_assesment == "1")
    <div class="row">
        <div class="col-lg-6">
            <div class="mt-3 mt-lg-0">
                <div class="mb-3">
                    {{ Form::label('safety_description', 'Safety Description' , ['class' => 'form-label']) }}
                    {{ Form::text('safety_description', isset($invoiceRequest) ? $invoiceRequest->safety_description : '', ['class' => $errors->has('extra_info') ? 'form-control is-invalid' : 'form-control']) }}
                    @if ($errors->has('safety_description'))
                        <div class="invalid-feedback">{{ $errors->first('safety_description') }}</div>
                    @endif
                </div>


            </div>
        </div>

    </div>
@endif
