<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
</head>
<body>

@if(!empty($data))
    <x-table :headers="$headers" :array="true" :search="false" :buttons="false"
             :index="$type == 'safe' ? false : true" :rows="$data" :paginate="false" :cells="$cells"/>
@endif


</body>
</html>
