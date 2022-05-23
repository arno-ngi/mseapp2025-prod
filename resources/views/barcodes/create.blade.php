@extends('layouts.app')

@section('extracss')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Barcodes - {{__('law.create_new')}}</h4>
                </div>

                {!! Form::open(['url' => route('barcodes.store'), 'method' => 'post']) !!}

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
    </div>
@endsection

@section('extrajs')

@endsection
