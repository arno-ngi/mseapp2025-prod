<head>
    <style type="text/css" media="all">
        #design {
            border-collapse: collapse;
            border: 0px solid #000;
            width: 100%;
        }

        #design td {
            height: 120px;
            text-align: center;
        }

        #design th,
        #design thead {
            border: 0px solid #000;
            font-size: 12px;
        }


        * {
            margin: 2px;
            padding: 2px;
        }
    </style>
</head>
<table id="design">
    <tr>
        @php
            $counter = 1;
        @endphp
        @for ($i = $barcode->startnumber; $i < ($barcode->startnumber + $barcode->quantity); $i++)
            <td>{{$barcode->name}}<br/><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($i, $barcode->barcodetype,1,33,array(1,1,1), true)}}"
                     alt="barcode"/></td>
            @if($counter % 2 === 0)
    </tr>
    <tr>
        @endif
        @php
            $counter++;
        @endphp
        @endfor
    </tr>
</table>
