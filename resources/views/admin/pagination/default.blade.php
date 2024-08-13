@if ($paginator->hasPages())
<div class="p-4">
    <nav class="block">
      <ul class="flex pl-0 rounded list-none flex-wrap justify-end">
        @if ($paginator->onFirstPage())
            <li>
                <a href="javascript:void(0)" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 bg-white text-blue-500 disabled:cursor-not-allowed pointer-events-none">
                <i class="fas fa-chevron-left -ml-px"></i>
                </a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 bg-white text-blue-500">
                <i class="fas fa-chevron-left -ml-px"></i>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
            <li>
                <a href="javascript:void(0)" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 text-white bg-white disabled:cursor-not-allowed pointer-events-none">
                {{ $element }}
                </a>
            </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page=>$url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <a href="javascript:void(0)" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 text-white bg-blue-500">
                            {{ $page }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 text-blue-500 bg-white">
                            {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach


        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 bg-white text-blue-500">
                <i class="fas fa-chevron-right -mr-px"></i>
                </a>
            </li>
        @else
            <li>
                <a href="javascript:void(0)" class="first:ml-0 text-xs font-semibold flex w-8 h-8 mx-1 p-0 rounded-full items-center justify-center leading-tight relative border border-solid border-blue-500 bg-white text-blue-500 disabled:cursor-not-allowed pointer-events-none">
                <i class="fas fa-chevron-right -mr-px"></i>
                </a>
            </li>
        @endif

      </ul>
    </nav>
  </div>
@endif