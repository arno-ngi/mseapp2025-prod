@extends('layouts.app')

@section('extracss')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('law.users')}} - {{__('law.create_new')}}</h4>
                </div>

                {!! Form::open(['url' => route('users.store'), 'method' => 'post']) !!}

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('name', __('law.name') , ['class' => 'form-label']) }}
                                {{ Form::text('name', isset($user) ? $user->name : '', ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('firstname', __('law.firstname') , ['class' => 'form-label']) }}
                                {{ Form::text('firstname', isset($user) ? $user->firstname : '', ['class' => $errors->has('firstname') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('firstname'))
                                    <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('email', __('law.email') , ['class' => 'form-label']) }}
                                {{ Form::text('email', isset($user) ? $user->email : '', ['class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('initials', __('law.initials') , ['class' => 'form-label']) }}
                                {{ Form::text('initials', isset($user) ? $user->initials : '', ['class' => $errors->has('initials') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('initials'))
                                    <div class="invalid-feedback">{{ $errors->first('initials') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('password', __('law.password') . ' ' . __('law.empty_automatic') , ['class' => 'form-label']) }}
                                {{ Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                </div>


                <div class="card-footer">
                    <a href="{{route('users.index')}}"
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
