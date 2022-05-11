@extends('layouts.app')

@section('extracss')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('law.task')}} - {{__('law.create_new')}}</h4>
                </div>

                {!! Form::open(['url' => route('tasks.store'), 'method' => 'post']) !!}

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('title', __('law.title') , ['class' => 'form-label']) }}
                                {{ Form::text('title', isset($task) ? $task->name : '', ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('title'))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('description', __('law.description') , ['class' => 'form-label']) }}
                                {{ Form::text('description', isset($task) ? $task->description : '', ['class' => $errors->has('description') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    {{ Form::label('user_id', __('law.user'), ['class' => 'form-label']) }}
                                    <select class="form-select" name="user_id" id="user_id">
                                        <option value="0">---</option>
                                        @foreach(auth()->user()->tenant->users()->whereIsActive(true)->whereIsClientvisible(true)->get() as $user)
                                            <option
                                                value="{{$user->id}}"{{ isset($expenseRequest) && $expenseRequest->user_id == $user->id ? ' selected' : '' }}>{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-footer">
                    <a href="{{route('tasks.index')}}"
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
