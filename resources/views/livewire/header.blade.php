<div class="bg-white items-center shadow py-4 font-extrabold flex text-cyan-800 px-3">
    <button class="inline-block mx-6" id="sideBarBtn">
        <i class="fa fa-bars"></i>
    </button>
    <div class="mx-3 w-1/4 text-2xl">{{$header ?? ""}}</div>
    <div class="mx-3 w-1/4 text-2xl">الخزنة : {{ number_format($safe) }} </div>
    <div class="mx-3 w-1/4 text-2xl">البنك : {{ number_format($bank) }} </div>

    <div class="w-1/4 mx-3 text-left text-2xl"> المستخدم :  {{auth()->user()->name ?? "" }}</div>

    <div class="justify-self-end bg-red-500 hover:bg-red-400 text-white w-25 py-2 px-3 rounded-xl items-end">
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <i class="fa fa-door-open"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

</div>
