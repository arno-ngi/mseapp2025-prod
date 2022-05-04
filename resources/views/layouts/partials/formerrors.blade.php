@if(session()->has('status'))
    <div class="row">
        <div class="alert alert-info alert-label-icon label-arrow mb-2 " role="alert">
            <i class="mdi mdi-alert-circle-outline label-icon"></i>
            {{session('status')}}
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="row">

        <div class="alert alert-danger alert-label-icon label-arrow mt-2" role="alert">
            <i class="mdi mdi-block-helper label-icon"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                @endforeach
        </div>
    </div>
@endif
