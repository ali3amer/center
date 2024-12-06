@props(['title' => '', 'class' => ''])
<div class="p-5 text-cyan-800 bg-white {{$class}} font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
    @if($title != '')
        <h3>{{$title}}</h3>
    @endif

    {{ $slot }}
</div>
