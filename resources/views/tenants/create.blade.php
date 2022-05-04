@extends('layouts.app')

@section('extracss')
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tenants - {{__('law.create_new')}}</h4>
                </div>

                {!! Form::open(['url' => route('tenants.store'), 'method' => 'post']) !!}

                @include('tenants.partials.form')

                {{Form::close()}}

            </div>
        </div>
    </div>
@endsection

@section('extrajs')

@endsection
