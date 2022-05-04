@extends('layouts.app')

@section('extracss')
    <link href="/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tenants - {{ $tenant->name }}</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-pills card-header-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.general')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#logo" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Logo's</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{ Form::model($tenant, ['route' => ['tenants.update', $tenant], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}
                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <p class="mb-0">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('name', __('law.name') , ['class' => 'form-label']) }}
                                        {{ Form::text('name', isset($tenant) ? $tenant->name : '', ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            {{ Form::label('mail_info', __('law.email') . ' info', ['class' => 'form-label']) }}
                                            {{ Form::text('mail_info', isset($tenant) ? $tenant->mail_info : '', ['class' => $errors->has('mail_info') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('mail_info'))
                                                <div class="invalid-feedback">{{ $errors->first('mail_info') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('o365_client_id', 'Office 365 Client ID' , ['class' => 'form-label']) }}
                                        {{ Form::text('o365_client_id', isset($tenant) ? $tenant->o365_client_id : '', ['class' => $errors->has('o365_client_id') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('o365_client_id'))
                                            <div class="invalid-feedback">{{ $errors->first('o365_client_id') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            {{ Form::label('o365_client_secret', 'Office 365 Client Secret', ['class' => 'form-label']) }}
                                            {{ Form::text('o365_client_secret', isset($tenant) ? $tenant->o365_client_secret : '', ['class' => $errors->has('o365_client_secret') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('o365_client_secret'))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('o365_client_secret') }}</div>
                                            @endif
                                        </div>
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
                                                       name="is_active"{{ isset($tenant) && $tenant->is_active ? ' checked=""' : '' }}>
                                                <label class="form-check-label"
                                                       for="is_active">{{__('law.active')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="logo" role="tabpanel">
                            <p class="mb-0">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            {{ Form::label('file1', 'Logo', ['class' => 'form-label']) }}
                                            <input type="file"
                                                   class="{{$errors->has('file1') ? 'form-control is-invalid' : 'form-control'}}"
                                                   id="file1" name="file1">
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
                                            {{ Form::label('file2', 'Logo Mail', ['class' => 'form-label']) }}
                                            <input type="file"
                                                   class="{{$errors->has('file2') ? 'form-control is-invalid' : 'form-control'}}"
                                                   id="file2" name="file2">
                                            @if ($errors->has('file2'))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('file2') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            @if(!is_null($tenant->logo))
                                                <img class="img-fluid" src="{{url('storage/'.$tenant->logo)}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            @if(!is_null($tenant->logo_mail))
                                                <img class="img-fluid" src="{{url('storage/'.$tenant->logo_mail)}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{route('tenants.index')}}"
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
    <script src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        new Choices(document.getElementById("localips"), {
            delimiter: ",",
            editItems: !0,
            maxItemCount: 10,
            removeItemButton: !0
        });
        new Choices(document.getElementById("dossiertypes"), {
            delimiter: ",",
            editItems: !0,
            maxItemCount: 10,
            removeItemButton: !0
        })
    </script>
@endsection
