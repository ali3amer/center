@php
    $links = [
        ['course' , 'البرامج التدريبية', 'book-open-reader'],
        ['trainer' , 'المدربين', 'person-chalkboard'],
        ['student' , 'الدارسين', 'graduation-cap'],
        ['certification' , 'الشهادات', 'certificate fa-solid'],
        ['hall' , 'القاعات', 'home'],
        ['employee' , 'الموظفين', 'user-tie'],
        ['expense' , 'المصروفات', 'money-bill-wave'],
        ['user' , 'المستخدمين', 'users'],
        ['report' , 'التقارير', 'file-lines'],
        ['settings' , 'الإعدادات', 'cogs'],
        ['bank' , 'البنوك', 'bank'],
        ['transfer' , 'التحويلات', 'money-bill-transfer'],
];
@endphp
<style>
    .footer {
        position: fixed;
        bottom: 0;
        padding: 0px;
    }

    @font-face {
        font-family: 'arefRuqaa';
        src: url('fonts/ArefRuqaa/ArefRuqaa-Bold.ttf');
        font-style: normal;
        font-weight: 400;
    }

    @font-face {
        font-family: 'lateef';
        src: url('fonts/lateef/Lateef-Bold.ttf');
        font-style: normal;
        font-weight: 400;
    }

    @font-face {
        font-family: 'marhey';
        src: url('fonts/marhey/static/Marhey-Bold.ttf');
        font-style: normal;
        font-weight: 400;
    }

    @font-face {
        font-family: 'messiri';
        src: url('fonts/messiri/static/ElMessiri-Bold.ttf');
        font-style: normal;
        font-weight: 400;
    }

    .result-header {
        font-family: 'messiri', sans-serif;
        font-size: 32px;
    }
</style>
<div id="sideBar"
     class="w-64 bg-cyan-600 space-y-6 px-2 py-4 absolute inset-y-0 right-0 transform translate-x-full transition duration-200 ease-in-out md:relative md:-translate-x-0">
    <a href="" class="flex justify-center text-white space-x-5 space-x-reverse ">
        <span class="text-2xl font-extrabold text-white">نظام إدارة مركز معاً للتدريب</span>
    </a>
    <nav>
        @foreach($links as $link)
            {{--            @if($user->hasPermission($link[0] == "category" ? "categories-read" : $link[0] . 's-read'))--}}
            {{--                <a href="{{$link[0]}}" wire:navigate--}}
            {{--                   class="flex items-center {{Route::current()->uri == $link[0] ? 'text-cyan-300 rounded bg-cyan-700' : '' }} transition-all duration-200  text-white py-3 group px-4 hover:text-cyan-300 rounded hover:bg-cyan-700">--}}
            {{--                    <i class="fa fa-{{$link[2]}} mx-5"></i><span--}}
            {{--                        class="px-2 {{Route::current()->uri == $link[0] ? 'text-cyan-300' : '' }}"> {{$link[1]}}</span>--}}
            {{--                </a>--}}
            {{--            @endif--}}
        @if($link[0] == "settings")
            @php $name = $link[0].'-read' @endphp
            @else
                @php $name = $link[0].'s-read' @endphp
        @endif
            @if(Auth::user()->hasPermission($name))
            <a href="{{$link[0]}}" wire:navigate
               class="flex items-center {{Route::current()->uri == $link[0] ? 'text-cyan-300 rounded bg-cyan-700' : '' }} transition-all duration-200  text-white py-3 group px-4 hover:text-cyan-300 rounded hover:bg-cyan-700">
                <i class="fa fa-{{$link[2]}} mx-5"></i><span
                    class="px-2 {{Route::current()->uri == $link[0] ? 'text-cyan-300' : '' }}"> {{$link[1]}}</span>
            </a>
            @endif
        @endforeach

    </nav>
</div>

