@extends('layouts.app')

@section('extracss')

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{__('law.settings')}}</h4>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{str(__('law.edit'))->ucfirst()}} {{$appSetting->setting_key}}</h4>
                </div>

                {{ Form::model($appSetting, ['route' => ['appsettings.update', $appSetting], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}

                <div class="card-body p-4">

                    <div class="row">
                        @if($appSetting->setting_type === 'image')
                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        {{ Form::label('file1', __('law.file'), ['class' => 'form-label']) }}
                                        <input type="file" class="{{$errors->has('file1') ? 'form-control is-invalid' : 'form-control'}}" id="file1" name="file1">
                                        @if ($errors->has('file1'))
                                            <div
                                                class="invalid-feedback">{{ $errors->first('file1') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        @if(!is_null($appSetting->setting_value) && $appSetting->setting_value !== '/')
                                            <img class="img-fluid" src="{{url('storage/'.$appSetting->setting_value)}}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            @if($appSetting->setting_value === 'yes' || $appSetting->setting_value === 'no')
                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            {{ Form::label('setting_value', __('law.value'), ['class' => 'form-label']) }}
                                            {{ Form::select('setting_value', ['yes' => __('law.yes'), 'no' => __('law.no')], null, ['class' => 'form-select']) }}
                                            @if ($errors->has('setting_value'))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('setting_value') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            {{ Form::label('setting_value', __('law.value'), ['class' => 'form-label']) }}
                                            {{ Form::text('setting_value', isset($appSetting) ? $appSetting->setting_value : '', ['class' => $errors->has('setting_value') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('setting_value'))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('setting_value') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('appsettings.index')}}"
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
