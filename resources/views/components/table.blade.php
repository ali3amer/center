<div>
    <x-input name="search" label="" placeholder="بحث ....." width="1/3" wire:model.live="search" />
    <table class="table-auto w-full relative mt-2 max-h-96">
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
                @foreach ($cells as $key => $cell)
                    <td class="px-1 py-1 text-xs whitespace-nowrap text-wrap">
                        @if(!is_array($cell))
                            @if(!is_numeric($cell))
                            {{ $row[$cell] }}
                            @else
                                @dd($row[$cell])
                            @endif
                        @else
                            {{$cell[$row[$key]]}}
                        @endif
                    </td>
                @endforeach
                    <td class="px-6 py-1 whitespace-nowrap">
                        <button class="bg-cyan-300 rounded text-white px-2 py-1" wire:click="edit({{$row}})"><i class="fa fa-pen fa-xs"></i></button>
                        <button class="bg-red-600 rounded text-white px-2 py-1" wire:click="deleteMessage({{$row['id']}})"><i class="fa fa-close fa-xs"></i></button>
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="px-5 mt-2">
        {{ $rows->links() }}
    </div>
</div>
