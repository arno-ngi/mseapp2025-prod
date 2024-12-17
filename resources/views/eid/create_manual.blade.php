<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="robots" content="noindex, nofollow">

    <title>e-ID inlezen</title>
</head>
<body>
<div class="container">

        {{ Form::open(['url' => route('eid.store'), 'method' => 'post']) }}
        <input type="hidden" name="photoblob" value="">
        <input type="hidden" name="gender" value="">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="firstname">{{__('law.firstname')}}</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder=""
                       value="" required="">
            </div>
            <div class="col-md-6 mb-3">
                <label for="lastname">{{__('law.name')}}</label>
                <input type="text" class="form-control" id="lastname" name="lastname"
                       value="" required="">
            </div>
        </div><div class="row">
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
                <label for="licenseplate">{{__('law.licence_plate')}}</label>
                <input type="text" class="form-control" id="licenseplate" name="licenseplate" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
                <label for="reason">{{__('law.reason')}}</label>
                <input type="text" class="form-control" id="reason" name="reason" placeholder="">
            </div>
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">{{__('ngi.save')}}</button>
        <a href="{{route('eid.index')}}" class="btn btn-danger btn-lg btn-block" type="submit">{{__('ngi.cancel')}}</a>
        {{ Form::close() }}
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
