@extends('layouts.app')

@section('extracss')

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{__('law.settings')}}</h4>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

                    <table class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>{{__('law.setting')}}</th>
                            <th>{{__('law.value')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($appSettings as $appSetting)
                            <tr>
                                <td><a href="{{route('appsettings.edit', $appSetting)}}">{{$appSetting->setting_key}}</a></td>
                                <td>{{$appSetting->setting_value}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
        </div>
    </div>

@endsection

@section('extrajs')

@endsection
