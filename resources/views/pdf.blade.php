<!DOCTYPE html>
<html>
<head>

    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        @page {
            header: page-header;
        }

        * {
            font-family: sans-serif;
            direction: rtl;
            text-align: center;
        }

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            height: 50px;
            background-color: #752727;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        footer {
            font-family: sans-serif;
            position: fixed;
            bottom: -60px;
            height: 50px;
            width: 100%;
            background-color: #752727;
            color: white;
            text-align: center;
            line-height: 35px;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            direction: rtl;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: black;
            color: white;
            text-wrap: wrap;
        }

        thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        tfoot {
            position: sticky;
            bottom: 0;
        }

        tfoot tr td {
            background-color: black;
            color: white;
            text-wrap: wrap;
        }

        td h2 {
            padding: 0;
            margin: 0;
        }

        .header th, td {
            border: 0;
            padding: 0;
            text-align: center;
        }

        .header th, td img {
            border: 3px solid #000;
            border-radius: 50% !important;
        }

        @media print {
            .header th, td img {
                border: 3px solid #000;
            }

        }
    </style>
</head>
<body>
<htmlpageheader name="page-header">
    <table style="display:block; margin-bottom: 200px" >
        <tr>
            <td></td>
            <td><img src="{{asset("js/center.jpg")}}" style="width: 200px;"/></td>
        </tr>
    </table>
</htmlpageheader>

@if($type != 'expenses')
    <table style="margin-top: 100px">
        <thead>
        <tr>
            @foreach ($headers as $header)
                <th>{{$header}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($rows as $rowIndex => $row)
            <tr>
                @foreach ($cells as $key => $cell)
                    <td>
                        @if(!is_array($cell))
                            {{ $row->$cell }}
                        @else
                            {{$cell[$row[$key]]}}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td>المجموع:</td>
            <td>0</td>
        </tr>
        </tfoot>
    </table>
@else
    <table style="page-break-after: auto">
        <thead>
        <tr>
            @foreach ($headers['options'] as $header)
                <th>{{$header}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($rows['options'] as $rowIndex => $row)
            <tr>
                @foreach ($cells['options'] as $key => $cell)
                    <td>
                        @if(!is_array($cell))
                            {{ $row->$cell }}
                        @else
                            {{$cell[$row[$key]]}}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td>المجموع:</td>
            <td>0</td>
        </tr>
        </tfoot>
    </table>

    <table>
        <thead>
        <tr>
            @foreach ($headers['expenses'] as $header)
                <th>{{$header}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($rows['expenses'] as $rowIndex => $row)
            <tr>
                @foreach ($cells['expenses'] as $key => $cell)
                    <td>
                        @if(!is_array($cell))
                            {{ $row->$cell }}
                        @else
                            {{$cell[$row[$key]]}}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td>المجموع:</td>
            <td>0</td>
        </tr>
        </tfoot>
    </table>
@endif

<footer>
    <p>جميع الحقوق محفوظة</p>
</footer>
</body>
</html>
