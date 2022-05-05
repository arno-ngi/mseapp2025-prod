@extends('layouts.app')

@section('extracss')
    <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">RFA - {{ $invoiceRequest->uniqueid }}</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-pills card-header-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.general')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#approvers" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Approvers</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#files" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Files</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#items" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Items</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="general" role="tabpanel">
                            <p class="mb-0">

                                {{ Form::model($invoiceRequest, ['route' => ['rfa.update', $invoiceRequest], 'method' => 'patch']) }}
                                @include('invoicerequests.partials.form')
                                    <button type="submit"
                                            class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                                {{ Form::close() }}

                            </p>
                        </div>
                        <div class="tab-pane" id="approvers" role="tabpanel">
                            <p class="mb-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>{{__('law.name')}}</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoiceRequest->approvers as $approver)
                                    <tr>
                                        <td>{{$approver->user->fullname}}</td>
                                        <td>{!! getStatus($approver->status) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="files" role="tabpanel">
                            <p class="mb-0">

                            </p>
                        </div>
                        <div class="tab-pane" id="items" role="tabpanel">
                            <p class="mb-0">

                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{route('rfa.index')}}"
                       class="btn btn-soft-danger waves-effect waves-light">{{__('law.cancel')}}</a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('extrajs')
    <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script>
        flatpickr("#invoice_date", {dateFormat: "Y-m-d",defaultDate: new Date});
    </script>
@endsection
