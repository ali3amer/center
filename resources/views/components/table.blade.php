@props(['choose' => false, 'index' => false, 'search' => true, 'buttons' => true, 'edit' => true, 'delete' => true, 'paginate' => true, 'numbers' => [], 'functions' => [], 'array' => false, 'model' => '', 'chooseModel' => '', 'footers' => []])
<div>
    @if(Auth::user()->hasPermission($model.'-read'))
        @if($search)
            <x-input name="search" label="" placeholder="بحث ....." width="1/3" wire:model.live="search"/>
        @endif
        <table class="table-auto w-full relative mt-2 max-h-96">
            <thead class="bg-cyan-700 text-white">
            <tr>
                @if($index)
                    <th class="px-4 py-1 rounded-r-2xl">
                        #
                    </th>
                @endif
                @foreach ($headers as $header)
                    <th class="py-2 {{$loop->first && !$index ? 'rounded-r-2xl' : ''}} {{ $loop->last && !$buttons ? 'rounded-l-2xl' : '' }} px-4">{{$header}}</th>

                @endforeach
                @if($buttons)
                    <th class="py-2 px-4 rounded-l-2xl">الإجراءات</th>
                @endif
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach ($rows as $rowIndex => $row)

                <tr class="border-b">
                    @if($index)
                        <td class="px-4 py-1 whitespace-nowrap text-xs text-wrap">{{$rowIndex + 1}}</td>
                    @endif
                    @foreach ($cells as $key => $cell)
                        <td class="px-1 py-1 text-xs whitespace-nowrap text-wrap">
                            @if(!is_array($cell))
                                @if(in_array($cell, $numbers))
                                    @if($array)
                                        {{ number_format($row[$cell]) }}
                                    @else
                                        {{ number_format($row->$cell) }}
                                    @endif
                                @else
                                    @if($array)
                                        {{ $row[$cell] }}
                                    @else
                                        {{ $row->$cell }}
                                    @endif
                                @endif
                            @else
                                {{$cell[$row[$key]]}}
                            @endif
                        </td>
                    @endforeach
                    @if($buttons)
                        <td class="px-6 py-1 whitespace-nowrap">
                            @if($edit)
                                <button
                                    @disabled(!Auth::user()->hasPermission($model.'-update')) class="bg-cyan-300 rounded text-white px-2 py-1"
                                    wire:click="edit({{$row}})"><i
                                        class="fa fa-pen fa-xs"></i></button>
                            @endif
                            @if($delete)
                                <button
                                    @disabled(!Auth::user()->hasPermission($model.'-delete')) class="bg-red-600 rounded text-white px-2 py-1"
                                    wire:click="deleteMessage({{$row['id']}})">
                                    <i class="fa fa-close fa-xs"></i></button>
                            @endif
                            @if($choose)
                                <button
                                    @disabled(!Auth::user()->hasPermission($chooseModel.'-read')) class="bg-yellow-400 rounded text-white px-2 py-1"
                                    wire:click="choose({{$row}})"><i
                                        class="fa fa-eye fa-xs"></i></button>
                            @endif
                            @if(!empty($functions))
                                @foreach($functions[0] as $function)
                                    <button class="bg-yellow-400 rounded text-white px-2 py-1"
                                            wire:click="{{$function}}({{$row}})"><i
                                            class="fa fa-eye fa-xs"></i></button>
                                @endforeach
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            @if(!empty($footers))
                <tfoot class="bg-cyan-700 text-white">
                <tr>
                    @php $i = count($headers) @endphp
                    @if($index)
                        <th class="px-4 py-1 rounded-r-2xl">

                        </th>
                    @endif
                    @foreach ($footers as $key => $footer)
                        <th class="py-1 {{$loop->first && !$index ? 'rounded-r-2xl' : ''}} {{ $loop->last && !$buttons ? 'rounded-l-2xl' : '' }} px-4">{{$footer}}</th>
                    @endforeach
                </tr>
                </tfoot>
            @endif
        </table>

        @if($paginate)
            <div class="px-5 mt-2">
                {{ $rows->links() }}
            </div>
        @endif
    @endif
</div>
