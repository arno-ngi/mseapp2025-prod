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
                    <h4 class="card-title mb-0 flex-grow-1">Expense Request - {{ $expenseRequest->uniqueid }}
                        - {!! getStatus($expenseRequest->status) !!}

                        @if(!is_null($expenseRequest->invoice_request_id))
                            (<i class="bx bx-bx bx-link-alt"></i>{{$expenseRequest->invoicerequest->uniqueid}})
                        @endif
                    </h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-pills card-header-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link{{ Request::has('tab') ? '' : ' active' }}" data-bs-toggle="tab"
                                   href="#general" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.general')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Request::has('tab') && Request::query('tab') == 'approvers' ? ' active' : '' }}"
                                   data-bs-toggle="tab" href="#approvers" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.approvers')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Request::has('tab') && Request::query('tab') == 'requestitems' ? ' active' : '' }}"
                                   data-bs-toggle="tab" href="#items" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Items</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#files" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">{{__('law.files')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#logs" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Logs</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="card-body p-4">
                    <div class="tab-content text-muted">
                        <div class="tab-pane{{ Request::has('tab') ? '' : ' active' }}" id="general" role="tabpanel">
                            <p class="mb-0">

                                {{ Form::model($expenseRequest, ['route' => ['expenserequest.update', $expenseRequest], 'method' => 'patch']) }}
                                @include('expenserequests.partials.form')
                                <button type="submit"
                                        class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                                {{ Form::close() }}

                            </p>
                        </div>
                        <div
                            class="tab-pane{{ Request::has('tab') && Request::query('tab') == 'approvers' ? ' active' : '' }}"
                            id="approvers" role="tabpanel">
                            <p class="mb-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>{{__('law.name')}}</th>
                                        <th>Status</th>
                                        <th>{{__('law.date')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$expenseRequest->requester->fullname}}</td>
                                        <td>{{__('law.requester')}}</td>
                                        <td></td>
                                    </tr>
                                    @foreach($expenseRequest->approvers as $approver)
                                        <tr>
                                            <td>{{$approver->user->fullname}}</td>
                                            <td>{!! getStatus($approver->status) !!}
                                                @if($approver->user_id === auth()->user()->id)
                                                    @foreach(getStatus2() as $key => $value)
                                                        @if($key !== 1)
                                                            <a href="{{route('expenserequests.changestatus', ['expenseRequest' => $expenseRequest, 'status' => $key])}}"
                                                               class="btn {{getStatusColor($key)}}">{{ $value }}</a>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </td>
                                            <td>
                                                @if($approver->status === 3 || $approver->status === 4 || $approver->status === 5)
{{$approver->updated_at->format('d/m/Y H:i')}}
                                                @endif
                                            </td>
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
                                            @foreach($expenseRequest->extrafiles->where('is_invoice', false) as $extrafile)
                                                <tr>
                                                    <td>
                                                        <i class="{{ getExtensionIcon($extrafile->filename) }}"></i> <a
                                                            href="{{url('storage/'.$extrafile->filepath)}}"
                                                            target="_new">{{$extrafile->filename}}</a>
                                                    </td>
                                                    <td>
                                                        {!! Form::open(['url' => route('files.destroy'), 'method' => 'POST', 'class' => 'deletefile']) !!}
                                                        {{ Form::hidden('fileid', $extrafile->id) }}
                                                        {{ Form::hidden('type', 'er') }}
                                                        {{ Form::hidden('modelid', $expenseRequest->uuid) }}
                                                        <button
                                                            type="submit"
                                                            class="btn btn-outline-danger btn-xs">{{ __('ngi.delete') }}</button>
                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    {{ Form::open([ 'route' => [ 'expenserequest.store.files', $expenseRequest ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'form_rfa_files']) }}
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
                        <div
                            class="tab-pane{{ Request::has('tab') && Request::query('tab') == 'requestitems' ? ' active' : '' }}"
                            id="items" role="tabpanel">

                            <p class="mb-0">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th>{{__('law.quantity')}}</th>
                                                <th>{{__('law.description')}}</th>
                                                <th>{{__('law.price_per_unit')}}</th>
                                                <th>{{__('ngi.total')}}</th>
                                                <th>{{__('law.actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach($expenseRequest->requestitems as $request_item)
                                                <tr>
                                                    <td>{{$request_item->quantity}}</td>
                                                    <td>
                                                        <a href="{{route('expenserequest.edit', $expenseRequest).'?tab=requestitems&edit='.$request_item->id}}">{{$request_item->description}}</a>
                                                    </td>
                                                    <td>{!! showEUR2($request_item->price, $expenseRequest->currency) !!}</td>
                                                    <td>{!! showEUR2(($request_item->price * $request_item->quantity), $expenseRequest->currency) !!}</td>
                                                    <td>
                                                        {!! Form::open(['url' => route('requestitem.delete', $request_item), 'method' => 'DELETE', 'class' => 'deletefile']) !!}
                                                        {{ Form::hidden('type', 'er') }}
                                                        {{ Form::hidden('modelid', $expenseRequest->uuid) }}
                                                        <button
                                                            type="submit"
                                                            class="btn btn-outline-danger btn-xs">{{ __('ngi.delete') }}</button>
                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                                @php
                                                    $total += $request_item->quantity * $request_item->price ;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{!! showEUR2($total, $expenseRequest->currency) !!} </td>
                                                <td></td>

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
                                    {{Form::hidden('modeltype', 'expenserequest')}}
                                    {{Form::hidden('modelid', $expenseRequest->id)}}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                {{ Form::label('quantity', __('law.quantity'), ['class' => 'form-label']) }}
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
                                                {{ Form::label('description', __('law.description'), ['class' => 'form-label']) }}
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
                                                {{ Form::label('price',__('law.price_per_unit'), ['class' => 'form-label']) }}
                                                {{ Form::text('price', isset($requestitem) ? $requestitem->price : '', ['class' => $errors->has('price') ? 'form-control is-invalid' : 'form-control', 'data-type' => 'currency']) }}
                                                @if ($errors->has('price'))
                                                    <div
                                                        class="invalid-feedback">{{ $errors->first('price') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary">{{__('law.save')}}</button>
                                    {{Form::close()}}
                                </div>
                            </div>
                            </p>
                        </div>
                        <div class="tab-pane" id="logs" role="tabpanel">
                            <p class="mb-0">
                            <table class="table table-bordered table-striped table-sm">
                                <tbody>
                                @foreach($activitylogs as $activitylog)
                                    <tr>
                                        <td>{{ $activitylog->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if(is_null($activitylog->causer_id))
                                                -
                                            @else
                                                {{ $activitylog->causer->fullname }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $activitylog->description }}
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{route('expenserequest.index')}}"
                       class="btn btn-soft-danger waves-effect waves-light">{{__('law.cancel')}}</a>
                    <a href="{{route('expenserequest.pdf', $expenseRequest)}}"
                       class="btn btn-soft-secondary waves-effect waves-light ">PDF</a>
                    @if($expenseRequest->status !== 5)
                        <a href="{{route('expenserequests.makepending', $expenseRequest)}}"
                           class="btn btn-soft-info waves-effect waves-light ">{{__('law.status_pending')}}</a>

                        <a href="{{route('expenserequests.makerejected', $expenseRequest)}}"
                           class="btn btn-soft-alert waves-effect waves-light ">{{__('law.status_rejected')}}</a>
                    @else
                        @if(auth()->user()->is_superadmin || auth()->user()->hasAnyPermission(['module.rfa']))
                            <a href="{{route('expenserequests.makepending', $expenseRequest)}}"
                               class="btn btn-soft-info waves-effect waves-light ">Re-open</a>
                        @endif
                    @endif
                    <br/><br/>
                    @if($expenseRequest->status !== 5)
                        @if(is_null($expenseRequest->bankstatement) || is_null($expenseRequest->iban))
                            <a href="#"
                               class="btn btn-soft-success waves-effect waves-light">{{__('law.closed')}} - disabled -
                                Missing {{__('law.bank_statement')}} or IBAN</a>
                        @else
                            <a href="{{route('expenserequests.makeclosed', $expenseRequest)}}"
                               class="btn btn-soft-success waves-effect waves-light">{{__('law.closed')}}</a>
                        @endif
                    @endif



                       </div>
            </div>

        </div>
    </div>
@endsection

@section('extrajs')
    <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="/assets/libs/dropzone/min/dropzone.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        flatpickr("#expense_date", {dateFormat: "Y-m-d", defaultDate: new Date});

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
        $('#user_id').on('change', function () {

            $.ajax({
                url: '{{(route('users.getbank'))}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userid": this.value,
                },
                success: function (result2) {
                    Swal.fire({
                        title: 'Bankrekening nummer van gebruiker overnemen uit profiel?',
                        showCancelButton: true,
                        confirmButtonColor: '#32CD32',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Nee',
                        confirmButtonText: 'Ja'
                    }).then((result) => {
                        if (result.value) {
                            $("#iban").val(result2.banknumber);
                        }
                    });
                }
            });
        });

        delfiles();

        function delfiles() {
            $(".deletefile").submit(function (event) {
                event.preventDefault();
                Swal.fire({
                    title: '{{__('law.confirm_delete')}}',
                    showCancelButton: true,
                    confirmButtonColor: '#32CD32',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Nee',
                    confirmButtonText: 'Ja'
                }).then((result) => {
                    if (result.value) {
                        this.submit();
                    }
                });
            });

        }
    </script>
@endsection
