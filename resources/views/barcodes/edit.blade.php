@extends('layouts.app')

@section('extracss')
    <link href="/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $barcode->name }}</h4>

                </div>

                {{ Form::model($barcode, ['route' => ['barcodes.update', $barcode], 'method' => 'patch']) }}
                <div class="card-body p-4">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('name', __('law.name') , ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($barcode) ? $barcode->name : '', ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('startnumber', 'Startnummber' , ['class' => 'form-label']) }}
                                {{ Form::text('startnumber', isset($barcode) ? $barcode->startnumber : '', ['class' => $errors->has('startnumber') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('startnumber'))
                                    <div class="invalid-feedback">{{ $errors->first('startnumber') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('quantity', __('law.quantity') , ['class' => 'form-label']) }}
                                {{ Form::text('quantity', isset($barcode) ? $barcode->quantity : '', ['class' => $errors->has('quantity') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('quantity'))
                                    <div class="invalid-feedback">{{ $errors->first('quantity') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{route('barcodes.index')}}"
                       class="btn btn-soft-danger waves-effect waves-light">{{__('law.cancel')}}</a>
                    <button type="submit"
                            class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
        <div class="col-6">
            @for ($i = $barcode->startnumber; $i < ($barcode->startnumber + $barcode->quantity); $i++)
                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($i, 'C39',1,33,array(1,1,1), true)}}" alt="barcode" /><br><br>
            @endfor
        </div>
    </div>
@endsection

@section('extrajs')

@endsection
