@if ($page->lastPage() > 1)
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-primary justify-content-center">

            {{-- زر السابق --}}
            <li class="page-item {{ $page->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link"
                   href="{{ $page->onFirstPage() ? '#' : $page->previousPageUrl() . (request()->has('search') ? '&search=' . request('search') : '') }}"
                   aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            {{-- بداية الصفحات --}}
            @php
                $current = $page->currentPage();
                $last = $page->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $page->url(1) }}">1</a>
                </li>
                @if ($start > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            {{-- الصفحات حول الحالية --}}
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $current ? 'active' : '' }}">
                    <a class="page-link" href="{{ $page->url($i) . (request()->has('search') ? '&search=' . request('search') : '') }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- زر آخر صفحة --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $page->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- زر التالي --}}
            <li class="page-item {{ !$page->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link"
                   href="{{ $page->hasMorePages() ? $page->nextPageUrl() . (request()->has('search') ? '&search=' . request('search') : '') : '#' }}"
                   aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>

        </ul>
    </nav>
@endif
