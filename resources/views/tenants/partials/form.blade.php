<div class="card-body p-4">

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
</div>

<div class="card-footer">
    <a href="{{route('tenants.index')}}" class="btn btn-soft-danger waves-effect waves-light">{{__('law.cancel')}}</a>
    <button type="submit" class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
</div>
