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
                    <h4 class="card-title mb-0 flex-grow-1">{{__('law.expense_request')}}</h4>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2 mb-0 my-n1">
                            <a href="{{route('expenserequest.create')}}" class="btn btn-primary waves-effect btn-label waves-light btn-sm">
                                <i
                                    class="bx bx-plus label-icon"></i>{{__('law.create_new')}}</a>
                        </div>
                    </div>
                </div>


                <div class="card-body">

                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{__('law.requester')}}</th>
                            <th>{{__('law.requested')}}</th>
                            <th>Info</th>
                            <th>{{__('law.amount')}}</th>
                            <th>{{__('law.category')}}</th>
                            <th>Status</th>
                            <th>Begunstigde</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenseRequests as $expenseRequest)
                            <tr>
                                <td><a href="{{route('expenserequest.edit', $expenseRequest)}}">{{$expenseRequest->slug }}</a></td>
                                <td>{{ $expenseRequest->requester->fullname }}</td>
                                <td>{{ $expenseRequest->created_at->format('Y-m-d') }}</td>
                                <td>{{ $expenseRequest->internal_information }}</td>
                                <td>{!! showEUR2($expenseRequest->total_cost, $expenseRequest->currency) !!}</td>
                                <td>{{  $expenseRequest->category->name }}</td>
                                <td>{!! getStatus($expenseRequest->status) !!}</td>
                                <td>{{ $expenseRequest->user->name }}</td>

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
            console.log

            var oTable = $("#datatable").DataTable({
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
                    },
                    @endif
                    pageLength: {{auth()->user()->rows_per_table}},
                }
            );

            $("#datatable-buttons").DataTable({
                lengthChange: !1,
                buttons: ["copy", "excel", "pdf", "colvis"]
            }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm");

        });
    </script>
@endsection
