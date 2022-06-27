@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <table id="datatable" class="table table-bordered table-striped table-sm dataTable">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($approvers as $approver)
                        <tr>
                            <td>
                                @if(get_class($approver->approvers) === 'App\Models\ExpenseRequest')
                                    <a href="{{route('expenserequest.edit', $approver->approvers).'?tab=approvers'}}">{{$approver->approvers->uniqueid}}</a>
                                @else
                                    <a href="{{route('rfa.edit', $approver->approvers).'?tab=approvers'}}">{{$approver->approvers->uniqueid}}</a>
                                @endif

                            </td>
                            <td>{!! getStatus($approver->status) !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
