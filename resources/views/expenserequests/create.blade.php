@extends('layouts.app')

@section('extracss')
    <link rel="stylesheet" href="/assets/libs/flatpickr/flatpickr.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Expense request - {{__('law.create_new')}}</h4>
                </div>

                {!! Form::open(['url' => route('expenserequest.store'), 'method' => 'post']) !!}

                <div class="card-body p-4">
                   @include('expenserequests.partials.form')
                </div>


                <div class="card-footer">
                    <a href="{{route('expenserequest.index')}}"
                       class="btn btn-soft-danger waves-effect waves-light">{{__('law.cancel')}}</a>
                    <button type="submit"
                            class="btn btn-soft-success waves-effect waves-light">{{ __('law.save') }}</button>
                </div>

                {{Form::close()}}

            </div>
        </div>
    </div>
@endsection

@section('extrajs')
    <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script>
        flatpickr("#expense_date", {dateFormat: "Y-m-d",defaultDate: new Date});


        $('#user_id').on('change', function() {

            $.ajax({
                url: '{{(route('users.getbank'))}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userid": this.value,
                },
                success: function (result) {
                    $("#iban").val(result.banknumber);
                }
            });
        });
    </script>
@endsection
