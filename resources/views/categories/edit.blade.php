@extends('layouts.app')

@section('extracss')
    <link href="/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ $category->name }}</h4>
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
                                    <span class="d-none d-sm-block">Approvers</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                {{ Form::model($category, ['route' => ['categories.update', $category], 'method' => 'patch']) }}
                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <p class="mb-0">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('name', __('law.name') , ['class' => 'form-label']) }}
                                        {{ Form::text('name', isset($category) ? $category->name : '', ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        {{ Form::label('shortname', 'Shortname' , ['class' => 'form-label']) }}
                                        {{ Form::text('shortname', isset($category) ? $category->shortname : '', ['class' => $errors->has('shortname') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('shortname'))
                                            <div class="invalid-feedback">{{ $errors->first('shortname') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            </p>
                        </div>
                        <div class="tab-pane" id="permissions" role="tabpanel">
                            <p class="mb-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="approvers"
                                               class="form-label font-size-13 text-muted ">Approvers</label>
                                        <select class="form-control" data-trigger
                                                name="approvers[]" id="approvers"
                                                placeholder="Select approvers" multiple>
                                            @foreach ($users as $user)
                                                <option
                                                    value="{{$user->id}}"{{$category->categoryusers->contains('user_id', $user->id) ? ' selected' : ''}}>{{$user->fullname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{route('categories.index')}}"
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
        new Choices("#approvers", {
            placeholderValue: "This is a placeholder set in the config",
            searchPlaceholderValue: "This is a search placeholder"
        })
    </script>
@endsection
