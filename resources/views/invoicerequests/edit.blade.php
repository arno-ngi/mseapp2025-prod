@extends('layouts.app')

@section('extracss')
    <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">
    <link href="/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
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
                                <a class="nav-link{{ Request::has('tab') ? '' : ' active' }}" data-bs-toggle="tab" href="#general" role="tab">
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
                                <a class="nav-link" data-bs-toggle="tab" href="#invoicefiles" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Invoice Files</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Request::has('tab') && Request::query('tab') == 'requestitems' ? ' active' : '' }}" data-bs-toggle="tab" href="#items" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Items</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane{{ Request::has('tab') ? '' : ' active' }}" id="general" role="tabpanel">
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
                                            @foreach($invoiceRequest->extrafiles->where('is_invoice', false) as $extrafile)
                                                <tr>
                                                    <td>
                                                        <i class="{{ getExtensionIcon($extrafile->filename) }}"></i> <a href="{{url('storage/'.$extrafile->filepath)}}">{{$extrafile->filename}}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    {{ Form::open([ 'route' => [ 'rfa.store.files', $invoiceRequest ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'form_rfa_files']) }}
                                    <div class="fallback">
                                        <input name="rfafile" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                        </div>

                                        <h5>{{__('law.add_files')}}</h5>
                                    </div>
                                    <input type="hidden" name="current_folder" id="current_folder" value="/"/>

                                    {{ Form::close() }}
                                </div>
                            </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="invoicefiles" role="tabpanel">
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
                                            @foreach($invoiceRequest->extrafiles->where('is_invoice', true) as $extrafile)
                                                <tr>
                                                    <td>
                                                        <i class="{{ getExtensionIcon($extrafile->filename) }}"></i> <a href="{{url('storage/'.$extrafile->filepath)}}">{{$extrafile->filename}}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    {{ Form::open([ 'route' => [ 'rfa.store.files', $invoiceRequest ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'form_rfa_files_invoice']) }}
                                    <div class="fallback">
                                        <input name="rfafile" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                        </div>

                                        <h5>{{__('law.add_files')}}</h5>
                                    </div>
                                    <input type="hidden" name="current_folder" id="current_folder" value="/"/>

                                    {{ Form::close() }}
                                </div>
                            </div>
                            </p>
                        </div>
                        <div class="tab-pane{{ Request::has('tab') && Request::query('tab') == 'requestitems' ? ' active' : '' }}" id="items" role="tabpanel">

                            <p class="mb-0">
                            <div class="row">
                                <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Descriptions</th>
                                        <th>Price per unit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($invoiceRequest->requestitems as $request_item)
                                        <tr>
                                            <td>{{$request_item->quantity}}</td>
                                            <td> <a href="{{route('rfa.edit', $invoiceRequest).'?tab=requestitems&edit='.$request_item->id}}">{{$request_item->description}}</a></td>
                                            <td>{!! showEUR2($request_item->price, $invoiceRequest->currency) !!}</td>
                                        </tr>
                                        @php
                                            $total += $request_item->quantity * $request_item->price ;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{!! showEUR2($total, $invoiceRequest->currency) !!} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                                </div>
                                <div class="col-lg-4">
                                    @if(Request::has('edit'))
                                        @php
                                            $requestitem = \App\Models\RequestItem::find(Request::query('edit'))
                                        @endphp
                                        {{ Form::model($requestitem, ['route' => ['requestitem.update', $requestitem], 'method' => 'patch']) }}
                                    @else
                                        {!! Form::open(['url' => route('requestitem.store'), 'method' => 'post', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
                                    @endif
                                    {{Form::hidden('modeltype', 'invoicerequest')}}
                                    {{Form::hidden('modelid', $invoiceRequest->id)}}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                {{ Form::label('quantity', 'Quantity', ['class' => 'form-label']) }}
                                                {{ Form::text('quantity', isset($requestitem) ? $requestitem->quantity : '', ['class' => $errors->has('quantity') ? 'form-control is-invalid' : 'form-control']) }}
                                                @if ($errors->has('quantity'))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first('quantity') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                {{ Form::label('description', 'Description', ['class' => 'form-label']) }}
                                                {{ Form::text('description', isset($requestitem) ? $requestitem->description : '', ['class' => $errors->has('description') ? 'form-control is-invalid' : 'form-control']) }}
                                                @if ($errors->has('description'))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first('description') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                {{ Form::label('price', 'Price per unit', ['class' => 'form-label']) }}
                                                {{ Form::text('price', isset($requestitem) ? $requestitem->price : '', ['class' => $errors->has('price') ? 'form-control is-invalid' : 'form-control', 'data-type' => 'currency']) }}
                                                @if ($errors->has('price'))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first('price') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>
                                    {{Form::close()}}
                                </div>
                            </div>
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
    <script src="/assets/libs/dropzone/min/dropzone.min.js"></script>

    <script>
        flatpickr("#invoice_date", {dateFormat: "Y-m-d", defaultDate: new Date});

        Dropzone.autoDiscover = false;

        $("#form_rfa_files").dropzone({
            paramName: "rfafile",
            maxFilesize: 250,
            init: function () {
                this.on("queuecomplete", function (file, response) {
                    location.reload();
                });
            }
        });
        $("#form_rfa_files_invoice").dropzone({
            paramName: "rfafile",
            maxFilesize: 250,
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("is_invoice", "yes");
                });
                this.on("queuecomplete", function (file, response) {
                    location.reload();
                });
            }
        });
    </script>
@endsection
