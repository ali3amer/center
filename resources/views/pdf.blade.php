<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
<h1>Invoice</h1>
<table>
    <thead>
    <tr>
        <th>Quantity</th>
        <th>Description</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $item)
        <tr>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['description'] }}</td>
            <td>{{ $item['price'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
