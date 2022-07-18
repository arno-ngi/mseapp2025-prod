@extends('layouts.app')

@section('extracss')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Visitors</h4>
                </div>

                <div class="card-body">

                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Checkin</th>
                            <th>Checkout</th>
                            <th>License plate</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($VisitorCheckIns->sortByDesc('checking') as $VisitorCheckIn)
                            <tr>
                                <td>{{ $VisitorCheckIn->firstname }} {{ $VisitorCheckIn->lastname }}</td>
                                <td>{{ $VisitorCheckIn->checkin->format('Y-m-d H:i')}}</td>
                                <td>{!! !is_null($VisitorCheckIn->checkout) ? $VisitorCheckIn->checkout->format('Y-m-d H:i') : '-' !!}</td>
                                <td>{{ $VisitorCheckIn->licenseplate }}</td>
                                <td>{{ $VisitorCheckIn->reason }}</td>
                                <td class="text-right">
                                    @if(is_null($VisitorCheckIn->checkout))
                                        {{ Form::model($VisitorCheckIn, ['route' => ['visitors.docheckoutpost', $VisitorCheckIn], 'method' => 'post', 'files' => true, 'enctype' => 'multipart/form-data']) }}
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                {{ Form::label('checkoutdate', 'Datum', ['class' => 'form-label']) }}
                                                <input class="form-control" type="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" name="checkoutdate" id="checkoutdate">
                                                @if ($errors->has('checkoutdate'))
                                                    <div class="invalid-feedback">{{ $errors->first('checkoutdate') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                {{ Form::label('checkouttime', 'Tijdstip', ['class' => 'form-label']) }}
                                                <input class="form-control " type="time" value="" name="checkouttime" id="checkouttime">
                                                @if ($errors->has('checkouttime'))
                                                    <div class="invalid-feedback">{{ $errors->first('checkouttime') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mt-4 ">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-xs">Checkout</button>
                                            </div>
                                        </div>
                                    </div>
                                        {!! Form::close() !!}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('extrajs')
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/libs/jszip/jszip.min.js"></script>
    <script src="/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#datatable").DataTable({
                    pageLength: {{auth()->user()->rows_per_table}},
                    @if(app()->getLocale() === 'nl')
                    language: {
                        "sProcessing": "{{ __('law.busy') }}...",
                        "sLengthMenu": "_MENU_ {{__('law.view_results')}}",
                        "sZeroRecords": "{{__('law.no_results_found')}}",
                        "sInfo": "_START_ tot _END_ van _TOTAL_ resultaten",
                        "sInfoEmpty": "{{__('law.no_results_to_view')}}",
                        "sInfoFiltered": " ({{__('law.filtered_out')}} _MAX_ {{__('law.results')}})",
                        "sInfoPostFix": "",
                        "sSearch": "{{__('law.search')}}:",
                        "sEmptyTable": "{{__('law.no_results_to_view')}}",
                        "sInfoThousands": ".",
                        "sLoadingRecords": "{{ __('law.busy') }}...",
                        "oPaginate": {
                            "sFirst": "{{__('law.first')}}",
                            "sLast": "{{__('law.last')}}",
                            "sNext": "{{__('law.next')}}",
                            "sPrevious": "{{__('law.previous')}}"
                        }
                    }
                    @endif
                }
            );
            $("#datatable-buttons").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf", "colvis"]
            }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
        });
    </script>
@endsection
