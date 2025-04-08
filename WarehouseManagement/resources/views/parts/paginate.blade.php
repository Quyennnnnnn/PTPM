@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-s1 flex-wrap justify-content-center py-2">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"> <a class="page-link" href="#"> <em class="ni ni-chevron-left icon"></em> </a>
                </li>
            @else
                <li class="page-item"> <a class="page-link" href="{{ $paginator->previousPageUrl() }}"> <em class="ni ni-chevron-left icon"></em> </a> </li>
            @endif

            @foreach ($paginator as $item)
                @if (is_string($item))
                    <li class="page-item disabled"> <a class="page-link" href="#">{{ $item }}</a> </li>
                @endif

                @if (is_array($paginator))
                    @foreach ($paginator as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item"> <a class="page-link" href="{{ $paginator->nextPageUrl() }}"> <em class="ni ni-chevron-right icon"></em> </a> </li>
            @else
                <li class="page-item disabled"> <a class="page-link" href="#"> <em class="ni ni-chevron-right icon"></em> </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
