<div>
    <table class="table-auto w-full relative max-h-96">
        <thead class="bg-cyan-700 text-white">
        <tr>
            @foreach ($headers as $header)
                <th class="py-2 {{$loop->first ? 'rounded-r-2xl' : ''}} px-4">{{$header}}</th>
            @endforeach
            <th class="py-2 px-4 rounded-l-2xl">الإجراءات</th>
        </tr>
        </thead>
        <tbody class="text-center">
        @foreach ($rows as $row)
            <tr class="border-b">
                @foreach ($cells as $cell)
                    <td class="px-1 py-1 text-xs whitespace-nowrap text-wrap">{{$row[$cell]}}</td>
                @endforeach
                    <td class="px-6 py-1 whitespace-nowrap">
                        <button class="bg-cyan-300 rounded text-white px-2 py-1"><i class="fa fa-pen fa-xs"></i></button>
                        <button class="bg-red-600 rounded text-white px-2 py-1"><i class="fa fa-close fa-xs"></i></button>
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
