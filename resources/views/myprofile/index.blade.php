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

                            <div class="tab-pane{{ Request::has('tab') && Request::query('tab') == 'profile' ? ' active' : '' }}" id="profile" role="tabpanel">
                                <p class="mb-0">
                                {{ Form::model($user, ['route' => ['users.profile.update', $user], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('birthplace', __('law.birthplace'), ['class' => 'form-label']) }}
                                            {{ Form::text('birthplace', isset($user) ? $user->birthplace : '', ['class' => $errors->has('birthplace') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('birthplace'))
                                                <div class="invalid-feedback">{{ $errors->first('birthplace') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('birthdate', __('law.birthdate'), ['class' => 'form-label']) }}
                                            <input class="form-control" type="date" value="{{isset($user)  && !is_null($user->birthdate) ? $user->birthdate->format('Y-m-d') : ''}}" name="birthdate" id="birthdate">
                                            @if ($errors->has('birthdate'))
                                                <div class="invalid-feedback">{{ $errors->first('birthdate') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('birth_country', __('law.birthland'), ['class' => 'form-label']) }}
                                            {{ Form::text('birth_country', isset($user) ? $user->birth_country : '', ['class' => $errors->has('birth_country') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('birth_country'))
                                                <div class="invalid-feedback">{{ $errors->first('birth_country') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('national_register_no', __('law.rijksregister'), ['class' => 'form-label']) }}
                                            {{ Form::text('national_register_no', isset($user) ? $user->national_register_no : '', ['class' => $errors->has('national_register_no') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('national_register_no'))
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('national_register_no') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('nationality', __('ngi.nationality'), ['class' => 'form-label']) }}
                                            {{ Form::text('nationality', isset($user) ? $user->nationality : '', ['class' => $errors->has('nationality') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('nationality'))
                                                <div class="invalid-feedback">{{ $errors->first('nationality') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('date_identitycard', 'Vervaldatum ID-kaart', ['class' => 'form-label']) }}
                                            <input class="form-control" type="date" value="{{isset($user) && !is_null($user->date_identitycard) ? $user->date_identitycard->format('Y-m-d') : ''}}" name="date_identitycard" id="date_identitycard">
                                            @if ($errors->has('date_identitycard'))
                                                <div class="invalid-feedback">{{ $errors->first('date_identitycard') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('bankaccountno', __('law.bankaccountnr'), ['class' => 'form-label']) }}
                                            {{ Form::text('bankaccountno', isset($user) ? $user->bankaccountno : '', ['class' => $errors->has('bankaccountno') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('bankaccountno'))
                                                <div class="invalid-feedback">{{ $errors->first('bankaccountno') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('date_goedgedragenzeden', __('law.date_behave'), ['class' => 'form-label']) }}
                                            <input class="form-control" type="date" value="{{isset($user) && !is_null($user->date_goedgedragenzeden) ? $user->date_goedgedragenzeden->format('Y-m-d') : ''}}" name="date_goedgedragenzeden" id="date_goedgedragenzeden">
                                            @if ($errors->has('date_goedgedragenzeden'))
                                                <div class="invalid-feedback">{{ $errors->first('date_goedgedragenzeden') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('street', __('law.street'), ['class' => 'form-label']) }}
                                            {{ Form::text('street', isset($user) ? $user->street : '', ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('street'))
                                                <div class="invalid-feedback">{{ $errors->first('street') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            {{ Form::label('number', __('law.housenumber'), ['class' => 'form-label']) }}
                                            {{ Form::text('number', isset($user) ? $user->number : '', ['class' => $errors->has('number') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('number'))
                                                <div class="invalid-feedback">{{ $errors->first('number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            {{ Form::label('zip', __('law.zipcode'), ['class' => 'form-label']) }}
                                            {{ Form::text('zip', isset($user) ? $user->zip : '', ['class' => $errors->has('zip') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('zip'))
                                                <div class="invalid-feedback">{{ $errors->first('zip') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
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
                                            {{ Form::label('prive_email', 'Prive email', ['class' => 'form-label']) }}
                                            {{ Form::text('prive_email', isset($user) ? $user->prive_email : '', ['class' => $errors->has('prive_email') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('prive_email'))
                                                <div class="invalid-feedback">{{ $errors->first('prive_email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('telefoon', __('law.phone'), ['class' => 'form-label']) }}
                                            {{ Form::text('telefoon', isset($user) ? $user->telefoon : '', ['class' => $errors->has('telefoon') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('telefoon'))
                                                <div class="invalid-feedback">{{ $errors->first('telefoon') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('ice_name', 'ICE ' . __('law.name'), ['class' => 'form-label']) }}
                                            {{ Form::text('ice_name', isset($user) ? $user->ice_name : '', ['class' => $errors->has('ice_name') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('ice_name'))
                                                <div class="invalid-feedback">{{ $errors->first('ice_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('ice_number', 'ICE ' . __('law.phone'), ['class' => 'form-label']) }}
                                            {{ Form::text('ice_number', isset($user) ? $user->ice_number : '', ['class' => $errors->has('ice_number') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('ice_number'))
                                                <div class="invalid-feedback">{{ $errors->first('ice_number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('clothing_shirt', __('law.clothing_size') . ' T-Shirt', ['class' => 'form-label']) }}
                                            {{ Form::text('clothing_shirt', isset($user) ? $user->clothing_shirt : '', ['class' => $errors->has('clothing_shirt') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('clothing_shirt'))
                                                <div class="invalid-feedback">{{ $errors->first('clothing_shirt') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('clothing_shoes', __('law.shoesize'), ['class' => 'form-label']) }}
                                            {{ Form::text('clothing_shoes', isset($user) ? $user->clothing_shoes : '', ['class' => $errors->has('clothing_shoes') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('clothing_shoes'))
                                                <div class="invalid-feedback">{{ $errors->first('clothing_shoes') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            {{ Form::label('clothing_pants', __('law.clothing_size') . ' ' . __('law.pants'), ['class' => 'form-label']) }}
                                            {{ Form::text('clothing_pants', isset($user) ? $user->clothing_pants : '', ['class' => $errors->has('clothing_pants') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('clothing_pants'))
                                                <div class="invalid-feedback">{{ $errors->first('clothing_pants') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('burgerlijke_staat', __('law.burgerlijke_staat'), ['class' => 'form-label']) }}
                                            {{ Form::select('burgerlijke_staat', ['-'=> '-', 'Alleenstaand'=>'Alleenstaand', 'Feitelijk samenwonend'=>'Feitelijk samenwonend', 'Wettelijk samenwonend'=>'Wettelijk samenwonend', 'Gehuwd'=>'Gehuwd', 'Gescheiden'=>'Gescheiden', 'Weduwe/Weduwnaar'=>'Weduwe/Weduwnaar', 'Feitelijk gescheiden'=>'Feitelijk gescheiden'], null, ['class' => $errors->has('burgerlijke_staat') ? 'form-select is-invalid' : 'form-select']) }}
                                            @if ($errors->has('burgerlijke_staat'))
                                                <div class="invalid-feedback">{{ $errors->first('burgerlijke_staat') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('opleidingsniveau', __('law.traininglevel'), ['class' => 'form-label']) }}
                                            {{ Form::select('opleidingsniveau', ['-'=> '-','Lager onderwijs'=>'Lager onderwijs', 'Middelbaar onderwijs'=>'Middelbaar onderwijs', 'Bachelor'=>'Bachelor', 'Master'=>'Master'], null, ['class' => $errors->has('opleidingsniveau') ? 'form-select is-invalid' : 'form-select']) }}
                                            @if ($errors->has('opleidingsniveau'))
                                                <div class="invalid-feedback">{{ $errors->first('opleidingsniveau') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Partner</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <h5>{{__('law.person_laste')}}</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('partner_name', __('law.name'), ['class' => 'form-label']) }}
                                            {{ Form::text('partner_name', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('partner_name'))
                                                <div class="invalid-feedback">{{ $errors->first('partner_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_kind_valide', __('law.kids_valid'), ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_kind_valide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_kind_valide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_kind_valide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_kind_invalide', __('law.kids_invalid'), ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_kind_invalide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_kind_invalide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_kind_invalide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('partner_firstname', __('law.firstname'), ['class' => 'form-label']) }}
                                            {{ Form::text('partner_firstname', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                            @if ($errors->has('partner_firstname'))
                                                <div class="invalid-feedback">{{ $errors->first('partner_firstname') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_65mantel_valide', '65+ mantelzorg', ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_65mantel_valide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_65mantel_valide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_65mantel_valide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('partner_birthdate', __('law.birthdate'), ['class' => 'form-label']) }}
                                            <input class="form-control" type="date" value="{{isset($user) && !is_null($user->partner_birthdate) ? $user->partner_birthdate->format('Y-m-d') : ''}}" name="partner_birthdate" id="partner_birthdate">
                                            @if ($errors->has('partner_birthdate'))
                                                <div class="invalid-feedback">{{ $errors->first('partner_birthdate') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_65overgang_valide', '65+ overgangsmaatregel valide', ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_65overgang_valide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_65overgang_valide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_65overgang_valide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_65overgang_invalide', '65+ overgangsmaatregel mindervalide', ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_65overgang_invalide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_65overgang_invalide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_65overgang_invalide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            {{ Form::label('beroepsinkomsten', __('law.beroepsinkomsten'), ['class' => 'form-label']) }}
                                            {{ Form::select('beroepsinkomsten', ['-'=> '-','Elk ander inkomen' => 'Elk ander inkomen', 'Geen inkomen' => 'Geen inkomen', 'Beroepsinkomen < 240 EUR/maand'=> 'Beroepsinkomen < 240 EUR/maand'], null, ['class' => $errors->has('contract_no') ? 'form-select is-invalid' : 'form-select']) }}
                                            @if ($errors->has('beroepsinkomsten'))
                                                <div class="invalid-feedback">{{ $errors->first('beroepsinkomsten') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_andere_valide', 'Anderen valide', ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_andere_valide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_andere_valide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_andere_valide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    {{ Form::label('personentenlaste_andere_invalide', 'Anderen mindervalide', ['class' => 'form-label']) }}
                                                    {{ Form::text('personentenlaste_andere_invalide', null, ['class' => $errors->has('street') ? 'form-control is-invalid' : 'form-control']) }}
                                                    @if ($errors->has('personentenlaste_andere_invalide'))
                                                        <div class="invalid-feedback">{{ $errors->first('personentenlaste_andere_invalide') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <div class="form-check form-switch mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="partner_tenlaste"
                                                           name="partner_tenlaste"{{ isset($user) && $user->partner_tenlaste ? ' checked=""' : '' }}>
                                                    <label class="form-check-label"
                                                           for="partner_tenlaste">{{__('law.partner_1')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <div class="form-check form-switch mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="partner_mindervalide"
                                                           name="partner_mindervalide"{{ isset($user) && $user->partner_mindervalide ? ' checked=""' : '' }}>
                                                    <label class="form-check-label"
                                                           for="partner_mindervalide">{{__('law.partner_2')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit"
                                        class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                                {{Form::close()}}
                            </div>

                            <div class="tab-pane" id="permissions" role="tabpanel">
                                <p class="mb-0">
                                    {{ Form::model($user, ['route' => ['users.update', $user], 'method' => 'patch', 'files' => true, 'enctype' => 'multipart/form-data']) }}



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
