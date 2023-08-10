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

                </div>

                {{ Form::model($category, ['route' => ['categories.update', $category], 'method' => 'patch']) }}
                <div class="card-body p-4">
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
                                        {{ Form::label('shortname', __('law.shortname') , ['class' => 'form-label']) }}
                                        {{ Form::text('shortname', isset($category) ? $category->shortname : '', ['class' => $errors->has('shortname') ? 'form-control is-invalid' : 'form-control']) }}
                                        @if ($errors->has('shortname'))
                                            <div class="invalid-feedback">{{ $errors->first('shortname') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <div class="form-check form-switch mb-3" dir="ltr">
                                        <input type="checkbox" class="form-check-input" id="has_allowance"
                                               name="has_allowance"{{ isset($category) && $category->has_allowance ? ' checked=""' : '' }}>
                                        <label class="form-check-label"
                                               for="has_allowance">{{ __('law.has_allowance') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="approvers"
                                               class="form-label font-size-13 text-muted ">Approvers</label>
                                        <select class="form-control" data-trigger
                                                name="approvers[]" id="approvers"
                                                placeholder="Select approvers" multiple>
                                            @foreach ($allusers as $alluser)
                                                <option
                                                    value="{{$alluser->id}}"{{$category->categoryusers->contains('user_id', $alluser->id) ? ' selected' : ''}}>{{$alluser->fullname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </p>
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
