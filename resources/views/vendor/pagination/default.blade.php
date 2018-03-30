@if ($paginator->hasPages())

    <nav>
      <ul class="pagination">
        <li class="page-item @if ($paginator->onFirstPage()) disabled @endif">
          <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><a class="page-link" href="#">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ $page }} <span class="sr-only">(current)</span></a>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif

        @endforeach
        <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </nav>

<? /*
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span>&laquo;</span></li>
        @else
            <li class='page-item'><a href="{{ $paginator->previousPageUrl() }}" class='page-link' rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span>{{ $page }}</span></li>
                    @else
                        <li class='page-item'><a href="{{ $url }}" class='page-link'>{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class='page-item'><a href="{{ $paginator->nextPageUrl() }}" class='page-link' rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span>&raquo;</span></li>
        @endif
    </ul>
*/ ?>
@endif
