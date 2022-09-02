@extends('layouts.app')

@section('extracss')
    <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">
    <link href="/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css"/>
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
                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.profile')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#files" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.files')}}</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <p class="mb-0">
                            {{ Form::model($user, ['route' => ['users.update2', $user], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}

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
<button type="submit"
                                    class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                            {{Form::close()}}
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel">
                            <p class="mb-0">
                            {{ Form::model($user, ['route' => ['users.profile.update', $user], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('birthplace', __('law.birthplace'), ['class' => 'form-label']) }}
                                        {{ Form::text('birthplace', isset($user) ? $user->birthplace : '', ['class' => $errors->has('birthplace') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('birthplace'))
                                            <div class="invalid-feedback">{{ $errors->first('birthplace') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('birthdate', __('law.birthdate'), ['class' => 'form-label']) }}
                                        {{ Form::text('birthdate', isset($user) ? $user->birthdate : '', ['class' => $errors->has('birthdate') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('birthdate'))
                                            <div class="invalid-feedback">{{ $errors->first('birthdate') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('birth_country', __('law.birthland'), ['class' => 'form-label']) }}
                                        {{ Form::text('birth_country', isset($user) ? $user->birth_country : '', ['class' => $errors->has('birth_country') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('birth_country'))
                                            <div class="invalid-feedback">{{ $errors->first('birth_country') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('national_register_no', __('law.rijksregister'), ['class' => 'form-label']) }}
                                        {{ Form::text('national_register_no', isset($user) ? $user->national_register_no : '', ['class' => $errors->has('national_register_no') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('national_register_no'))
                                            <div
                                                class="invalid-feedback">{{ $errors->first('national_register_no') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('nationality', __('ngi.nationality'), ['class' => 'form-label']) }}
                                        {{ Form::text('nationality', isset($user) ? $user->nationality : '', ['class' => $errors->has('nationality') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('nationality'))
                                            <div class="invalid-feedback">{{ $errors->first('nationality') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('bankaccountno', __('law.bankaccountnr'), ['class' => 'form-label']) }}
                                        {{ Form::text('bankaccountno', isset($user) ? $user->bankaccountno : '', ['class' => $errors->has('bankaccountno') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('bankaccountno'))
                                            <div class="invalid-feedback">{{ $errors->first('bankaccountno') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('street', __('law.street'), ['class' => 'form-label']) }}
                                        {{ Form::text('street', isset($user) ? $user->street : '', ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('street'))
                                            <div class="invalid-feedback">{{ $errors->first('street') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('number', __('law.housenumber'), ['class' => 'form-label']) }}
                                        {{ Form::text('number', isset($user) ? $user->number : '', ['class' => $errors->has('number') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('number'))
                                            <div class="invalid-feedback">{{ $errors->first('number') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('zip', __('law.zipcode'), ['class' => 'form-label']) }}
                                        {{ Form::text('zip', isset($user) ? $user->zip : '', ['class' => $errors->has('zip') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('zip'))
                                            <div class="invalid-feedback">{{ $errors->first('zip') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('city', __('law.city'), ['class' => 'form-label']) }}
                                        {{ Form::text('city', isset($user) ? $user->city : '', ['class' => $errors->has('city') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('city'))
                                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('hospital_previous_eployer', __('law.hospital_previous'), ['class' => 'form-label']) }}
                                        {{ Form::text('hospital_previous_eployer', isset($user) ? $user->hospital_previous_eployer : '', ['class' => $errors->has('hospital_previous_eployer') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('hospital_previous_eployer'))
                                            <div
                                                class="invalid-feedback">{{ $errors->first('hospital_previous_eployer') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('contract_no', 'Contract #', ['class' => 'form-label']) }}
                                        {{ Form::text('contract_no', isset($user) ? $user->contract_no : '', ['class' => $errors->has('contract_no') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('contract_no'))
                                            <div class="invalid-feedback">{{ $errors->first('contract_no') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                            {{Form::close()}}
                            </p>
                        </div>

                        <div class="tab-pane" id="files" role="tabpanel">
                            <p class="mb-0">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>{{__('law.name')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user->extrafiles as $extrafile)
                                                <tr>
                                                    <td>
                                                        <i class="{{ getExtensionIcon($extrafile->filename) }}"></i> <a
                                                            href="{{url('storage/'.$extrafile->filepath)}}">{{$extrafile->filename}}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    {{ Form::open(['route' => ['users.store.files',$user], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'form_user_files']) }}
                                    <div class="fallback">
                                        <input name="rfafile" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                        </div>

                                        <h5>{{__('law.add_files')}}</h5>
                                    </div>

                                    {{ Form::close() }}
                                </div>
                            </div>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{route('users.index')}}"
                       class="btn btn-soft-danger waves-effect waves-light">{{__('law.cancel')}}</a>

                </div>

            </div>

        </div>
    </div>
@endsection

@section('extrajs')
    <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="/assets/libs/dropzone/min/dropzone.min.js"></script>

    <script>
        flatpickr("#birthdate", {dateFormat: "Y-m-d"});

        Dropzone.autoDiscover = false;

        $("#form_user_files").dropzone({
            paramName: "rfafile",
            maxFilesize: 250,
            init: function () {
                this.on("queuecomplete", function (file, response) {
                    location.reload();
                });
            }
        });
    </script>
@endsection
