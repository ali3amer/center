<!DOCTYPE html>
<html>
<head>

    <title>التقارير</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        * {
            font-family: sans-serif;
            direction: rtl;
            text-align: center;
        }

        h2 {
            font-family: sans-serif;
            direction: rtl;
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
            text-align: center !important;
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
            text-align: right;
        }

        .header th, td img {
            border: 3px solid #000;
            border-radius: 50% !important;
        }

        .header, .header-space,
        .footer, .footer-space {
            height: 100px;
        }

        .header {
            position: fixed;
            top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }


    </style>
</head>
<body>
<table style="direction: rtl" class="header">
    <tr>
        <td style="width: 200px;text-align: right"><img src="{{asset("js/center.jpg")}}" style="width: 200px;"/>
        </td>
        <td>
            <h1>مركز معاً للتدريب والتأهيل <br> وتنمية الموارد البشرية</h1>
        </td>
    </tr>
</table>
<h2>{{$types[$type]}}</h2>
@if($type != 'expenses')
    <table>
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
                    <td style="text-align: center;border: 1px solid black">
                        @if(in_array($cell,$numbers))
                            {{number_format(round($row[$cell]))}}
                        @else
                            {{$row[$cell]}}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        @if(!empty($footers))
            <tfoot>
            <tr>
                @foreach ($footers as $key => $footer)
                    <th>{{$footer}}</th>
                @endforeach
            </tr>
            </tfoot>
        @endif
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
                    <td style="text-align: center;border: 1px solid black;">
                        @if(!is_array($cell))
                            @if(in_array($cell, $numbers['options']))
                                {{ number_format($row[$cell]) }}
                            @else
                                {{ $row[$cell] }}
                            @endif
                        @else
                            {{$cell[$row[$key]]}}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        @if(!empty($footers))
            <tfoot>
            <tr>
                @foreach ($footers['options'] as $key => $footer)
                    <th>{{$footer}}</th>
                @endforeach
            </tr>
            </tfoot>
        @endif

    </table>

    <table style="border: 1px solid #000; text-align: center; border-collapse: collapse">
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
                <td style="text-align: center;border: 1px solid black;"
                    rowspan="{{ count($row['details']) }}">{{$rowIndex}}</td>
                @foreach ($row['details'] as $key => $expense)
                    <td style="text-align: center;border: 1px solid black;">
                        {{$expense->description}}
                    </td>
                    <td style="text-align: center;border: 1px solid black;">{{number_format($expense->price)}}</td>
                    <td style="text-align: center;border: 1px solid black;">{{$expense->quantity}}</td>
                    <td style="text-align: center;border: 1px solid black;">{{number_format($expense->amount)}}</td>
                    <td style="text-align: center;border: 1px solid black;">{{$expense->date}}</td>
            </tr>
        @endforeach
        <tr>
            <td style="text-align: center;border: 1px solid black; color: white;background-color: #000">الجمله</td>
            <td style="text-align: center;border: 1px solid black; color: white;background-color: #000"></td>
            <td style="text-align: center;border: 1px solid black; color: white;background-color: #000"></td>
            <td style="text-align: center;border: 1px solid black; color: white;background-color: #000"></td>
            <td style="text-align: center;border: 1px solid black; color: white;background-color: #000">{{number_format($row['total'])}}</td>
            <td style="text-align: center;border: 1px solid black; color: white;background-color: #000"></td>
        </tr>
        @endforeach
        </tbody>
        @if(!empty($footers))
            <tfoot>
            <tr>
                @foreach ($footers['expenses'] as $key => $footer)
                    <th>{{$footer}}</th>
                @endforeach
            </tr>
            </tfoot>
        @endif
    </table>
@endif

{{--<footer>--}}
{{--    <p>جميع الحقوق محفوظة</p>--}}
{{--</footer>--}}
</body>
</html>
