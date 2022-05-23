<head>
    <style type="text/css" media="all">
        #design {
            border-collapse: collapse;
            border: 0px solid #000;
            width: 100%;
        }

        #design td {
            height: 70px;
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
        @for ($i = $barcode->startnumber; $i < ($barcode->startnumber + $barcode->quantity); $i++)
            <td><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($i, 'C39',1,33,array(1,1,1), true)}}"
                     alt="barcode"/></td>
            @if($i % 2 === 0)
    </tr>
    <tr>
        @endif
        @endfor
    </tr>
</table>
