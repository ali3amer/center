@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between rtl">
        {{-- الصفحات الصغيرة --}}
        <div class="flex-1 flex items-center justify-between sm:hidden">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium {{ $paginator->onFirstPage() ? 'text-gray-500 cursor-default' : 'text-gray-700 hover:text-gray-500' }} bg-white border border-gray-300 leading-5 rounded-md focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 transition ease-in-out duration-150">
                السابق
            </a>

            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium {{ $paginator->hasMorePages() ? 'text-gray-700 hover:text-gray-500' : 'text-gray-500 cursor-default' }} bg-white border border-gray-300 leading-5 rounded-md focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 transition ease-in-out duration-150">
                التالي
            </a>
        </div>

        {{-- الصفحات الكبيرة --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- رابط "السابق" --}}
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium {{ $paginator->onFirstPage() ? 'text-gray-500 cursor-default' : 'text-gray-700 hover:text-gray-500' }} bg-white border border-gray-300 rounded-r-md leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 transition ease-in-out duration-150" aria-label="Previous">
                        &laquo;
                    </a>

                    {{-- روابط الصفحات --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium {{ $page == $paginator->currentPage() ? 'text-white bg-blue-600 cursor-default' : 'text-gray-700 hover:text-gray-500' }} bg-white border border-gray-300 leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- رابط "التالي" --}}
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 text-sm font-medium {{ $paginator->hasMorePages() ? 'text-gray-700 hover:text-gray-500' : 'text-gray-500 cursor-default' }} bg-white border border-gray-300 rounded-l-md leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 transition ease-in-out duration-150" aria-label="Next">
                        &raquo;
                    </a>
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    عرض
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    إلى
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    من
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    النتائج
                </p>
            </div>
        </div>
    </nav>
@endif
