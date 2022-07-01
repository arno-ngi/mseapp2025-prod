<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>e-ID inlezen</title>
</head>
<body>
<div class="container">
    @if(!is_null($VisitorCheckIn))
        <div class="alert alert-warning" role="alert">
            Open check in found <br/>
            <a class="btn btn-lg btn-primary" href="{{route('eid.checkout', $VisitorCheckIn)}}" role="button">Do Check-out &raquo;</a>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Checkin</th>
                    <th>License plate</th>
                    <th>Reason</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $VisitorCheckIn->firstname }} {{ $VisitorCheckIn->lastname }}</td>
                        <td>{{ $VisitorCheckIn->checkin->format('Y-m-d H:i')}}</td>
                        <td>{{ $VisitorCheckIn->licenseplate }}</td>
                        <td>{{ $VisitorCheckIn->reason }}</td>

                    </tr>

                </tbody>
            </table>
        </div>
    @else
    {{ Form::open(['url' => route('eid.store'), 'method' => 'post']) }}
        <input type="hidden" name="photoblob" value="{{$attributeseid['eid/photo']}}">
        <input type="hidden" name="gender" value="{{$attributeseid['person/gender']}}">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="firstname">{{__('law.firstname')}}</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder=""
                   value="{{$attributeseid['namePerson/first']}}" required="">
        </div>
        <div class="col-md-6 mb-3">
            <label for="lastname">{{__('law.name')}}</label>
            <input type="text" class="form-control" id="lastname" name="lastname"
                   value="{{$attributeseid['namePerson/last']}}" required="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nationalnumber">{{__('ngi.nationalnumber')}}</label>
            <input type="text" class="form-control" id="nationalnumber" name="nationalnumber" placeholder=""
                   value="{{$attributeseid['eid/rrn']}}" required="">
        </div>
        <div class="col-md-6 mb-3">
            <label for="nationality">{{__('ngi.nationality')}}</label>
            <input type="text" class="form-control" id="nationality" name="nationality"
                   value="{{$attributeseid['eid/nationality']}}" required="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="birthdate">{{__('ngi.birthdate')}}</label>
            <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder=""
                   value="{{$attributeseid['birthDate']}}" required="">
        </div>
        <div class="col-md-6 mb-3">
            <label for="birthplace">{{__('ngi.birthplace')}}</label>
            <input type="text" class="form-control" id="birthplace" name="birthplace"
                   value="{{$attributeseid['eid/pob']}}" required="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="address_street">{{__('ngi.street')}}</label>
            <input type="text" class="form-control" id="address_street" name="address_street" placeholder=""
                   value="{{$street}}" required="">
        </div>
        <div class="col-md-6 mb-3">
            <label for="address_number">{{__('law.address_number')}}</label>
            <input type="text" class="form-control" id="address_number" name="address_number"
                   value="{{$streetnumber}}" required="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="address_zip">{{__('ngi.zip')}}</label>
            <input type="text" class="form-control" id="address_zip" name="address_zip" placeholder=""
                   value="{{$attributeseid['contact/postalCode/home']}}" required="">
        </div>
        <div class="col-md-6 mb-3">
            <label for="address_city">{{__('law.address_city')}}</label>
            <input type="text" class="form-control" id="address_city" name="address_city"
                   value="{{$attributeseid['contact/city/home']}}" required="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="contact_phone">{{__('ngi.phone')}}</label>
            <input type="text" class="form-control" id="contact_phone" name="contact_phone" placeholder="">
        </div>
       <div class="col-md-6 mb-3">
            <label for="contact_email">{{__('ngi.email')}}</label>
            <input type="text" class="form-control" id="contact_email" name="contact_email" placeholder="">
        </div>

    </div>
        <div class="row">
        <div class="col-md-6 mb-3">
            <label for="licenseplate">Licence plate</label>
            <input type="text" class="form-control" id="licenseplate" name="licenseplate" placeholder="">
        </div>
            <div class="col-md-6 mb-3">
            <label for="reason">Reason</label>
            <input type="text" class="form-control" id="reason" name="reason" placeholder="">
        </div>
    </div>

    <button class="btn btn-primary btn-lg btn-block" type="submit">{{__('ngi.save')}}</button>
    <a href="{{route('eid.index')}}" class="btn btn-danger btn-lg btn-block" type="submit">{{__('ngi.cancel')}}</a>
    {{ Form::close() }}
    @endif
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
