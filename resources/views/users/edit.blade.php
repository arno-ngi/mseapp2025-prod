@extends('layouts.app')

@section('extracss')

@endsection

@section('content')
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('law.users')}} - {{ $user->fullname }}</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-pills card-header-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.general')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#permissions" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.permissions')}}</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                {{ Form::model($user, ['route' => ['users.update', $user], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}
                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <p class="mb-0">
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
                                        {{ Form::label('password', __('law.new_password') , ['class' => 'form-label']) }}
                                        {{ Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="mb-3">
                                        {{ Form::label('notifier_position', __('law.notifier_position'), ['class' => 'form-label']) }}
                                        {{ Form::select('notifier_position', ['top-center' => 'top-center','top-right' => 'top-right', 'bottom-center' => 'bottom-center', 'bottom-right' => 'bottom-right'], null, ['class' => 'form-select']) }}
                                        @if ($errors->has('notifier_position'))
                                            <div class="invalid-feedback">{{ $errors->first('notifier_position') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            <div class="form-check form-switch mb-3" dir="ltr">
                                                <input type="checkbox" class="form-check-input" id="is_active"
                                                       name="is_active"{{ isset($user) && $user->is_active ? ' checked=""' : '' }}>
                                                <label class="form-check-label"
                                                       for="is_active">{{__('law.active')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="permissions" role="tabpanel">
                            <p class="mb-0">
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-lg-2">
                                        <div class="mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <div class="form-check form-switch mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="permissions[{{$permission->id}}]"
                                                           name="permissions[{{$permission->id}}]" value="{{$permission->id}}"{{ $user->hasPermissionTo($permission->id) ? ' checked=""' : '' }}>
                                                    <label class="form-check-label"
                                                           for="permissions[{{$permission->id}}]">{{$permission->name}}</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            </p>
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
