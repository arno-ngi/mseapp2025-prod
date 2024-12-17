<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="robots" content="noindex, nofollow">

    <title>e-ID inlezen</title>
</head>
<body>
<div class="container">
    @if(session()->has('flash_message'))
        <div class="alert alert-success" role="alert">
            {{ session('flash_message.message') }}
        </div>
    @endif

    <div class="jumbotron mt-3">
        <h1>Register Check-in / Check-out | Eid</h1>
        <a class="btn btn-lg btn-primary" href="{{route('eid.show')}}" role="button">Read e-ID &raquo;</a>
        <a class="btn btn-lg btn-primary" href="{{route('eid.create')}}" role="button">Manuele check-in</a>
    </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>MSE</strong> Open check-ins</h2>
                    </div>
                    <div class="body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{__('law.name')}}</th>
                                <th>Checkin</th>
                                <th>{{__('law.licence_plate')}}</th>
                                <th>{{__('law.reason')}}</th>
                                <th>De Checkout</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($VisitorCheckIns->sortByDesc('checking') as $VisitorCheckIn)
                                <tr>
                                    <td>{{ $VisitorCheckIn->firstname }} {{ $VisitorCheckIn->lastname }}</td>
                                    <td>{{ $VisitorCheckIn->checkin->format('Y-m-d H:i')}}</td>
                                    <td>{{ $VisitorCheckIn->licenseplate }}</td>
                                    <td>{{ $VisitorCheckIn->reason }}</td>
                                    <td><a class="btn btn-sm btn-primary" href="{{route('eid.manualcheckout', $VisitorCheckIn)}}" onclick="return confirm('Manual Checkout, are you sure?')" role="button">Manuele check-out</a></td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
