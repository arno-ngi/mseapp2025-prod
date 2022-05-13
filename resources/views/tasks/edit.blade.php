@extends('layouts.app')

@section('extracss')
    <link href="/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('law.task')}} - {{__('law.create_new')}}</h4>
                </div>

                {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'patch']) }}

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('title', __('law.title') , ['class' => 'form-label']) }}
                                {{ Form::text('title', isset($task) ? $task->title : '', ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control', 'readonly' => 'readonly']) }}
                                @if ($errors->has('title'))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('description', __('law.description') , ['class' => 'form-label']) }}
                                {{ Form::text('description', isset($task) ? $task->description : '', ['class' => $errors->has('description') ? 'form-control is-invalid' : 'form-control', 'readonly' => 'readonly']) }}
                                @if ($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('task_start', 'Start time' , ['class' => 'form-label']) }}
                                {{ Form::text('task_start', isset($task) ? $task->task_start : '', ['class' => $errors->has('task_start') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('task_start'))
                                    <div class="invalid-feedback">{{ $errors->first('task_start') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                {{ Form::label('task_end', 'End time' , ['class' => 'form-label']) }}
                                {{ Form::text('task_end', isset($task) ? $task->task_end : '', ['class' => $errors->has('task_end') ? 'form-control is-invalid' : 'form-control']) }}
                                @if ($errors->has('task_end'))
                                    <div class="invalid-feedback">{{ $errors->first('task_end') }}</div>
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
                                                value="{{$user->id}}"{{$task->user_id === $user->id ? ' selected' : ''}}>{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <div class="form-check form-switch mb-3" dir="ltr">
                                        <input type="checkbox" class="form-check-input" id="is_completed"
                                               name="is_completed"{{ isset($task) && $task->is_completed ? ' checked=""' : '' }}>
                                        <label class="form-check-label"
                                               for="is_completed">{{__('law.task_completed')}}</label>
                                    </div>
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
        <div class="col-lg-4">
            {{ Form::open([ 'route' => [ 'tasks.store.files', $task ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'form_rfa_files']) }}
            <div class="fallback">
                <input name="taskfile" type="file" multiple="multiple">
            </div>
            <div class="dz-message needsclick">
                <div class="mb-3">
                    <i class="display-4 text-muted bx bx-cloud-upload"></i>
                </div>

                <h5>{{__('law.add_files')}}</h5>
            </div>
            <input type="hidden" name="current_folder" id="current_folder" value="/"/>

            {{ Form::close() }}

            @if(count($task->extrafiles) > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>{{__('law.name')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($task->extrafiles as $extrafile)
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
            @endif
        </div>
    </div>
@endsection

@section('extrajs')
    <script src="/assets/libs/dropzone/min/dropzone.min.js"></script>
    <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        $("#form_rfa_files").dropzone({
            paramName: "taskfile",
            maxFilesize: 250,
            init: function () {
                this.on("queuecomplete", function (file, response) {
                    location.reload();
                });
            }
        });
        flatpickr("#task_start", {enableTime: true, dateFormat: "Y-m-d H:i"});
        flatpickr("#task_end", {enableTime: true, dateFormat: "Y-m-d H:i"});
    </script>
@endsection
