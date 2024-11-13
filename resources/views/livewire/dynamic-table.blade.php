<div class="overflow-auto h-80 w-full max-w-full"> <!-- ضبط w-full و max-w-full لجعل الحاوية تستجيب -->
    <table class="table-auto w-full relative max-h-96"> <!-- الجدول يملأ العرض المتاح بالكامل -->
        <thead class="bg-cyan-700 text-white">
        <tr>
            @foreach ($columns as $column)
                <th class="py-2 {{ $loop->first ? 'rounded-r-2xl' : '' }} px-4">{{ $column }}</th>
            @endforeach
            <th class="py-2 px-4 rounded-l-2xl">الإجراءات</th> <!-- عمود الإجراءات -->
        </tr>
        </thead>
        <tbody class="text-center">
        @foreach ($data as $item)
            <tr class="border-b"> <!-- إضافة حد فاصل لتمييز الصفوف -->
                @foreach ($columns as $index => $column)
                    <td class="px-1 py-4 text-xs whitespace-nowrap text-wrap">
                        {{ $item[$column] ?? '' }}
                    </td>
                @endforeach
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-button width="" wire:click="$parent.edit({{ $item['id'] }})" color="bg-cyan-300"  px="2" py="1" icon="fa-pen" label=""/>
                    <x-button width="" wire:click="$parent.delete({{ $item['id'] }})" color="bg-red-600" label="" px="2" py="1" icon="fa-x"/>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
