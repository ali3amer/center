<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * {
            font-family: DejaVu Sans;
            direction: rtl;
        }    </style>
</head>
<body>
<h1>Invoice</h1>
<x-table :headers="$headers" :search="false" model="reports" :buttons="false" :rows="$rows" :paginate="false" :cells="$cells"/>
</body>
</html>
