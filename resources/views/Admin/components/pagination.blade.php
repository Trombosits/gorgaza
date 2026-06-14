@if ($paginator->hasPages())
    <nav class="admin-pagination-wrap" role="navigation" aria-label="Navigasi halaman">
        <div class="admin-pagination-info">
            Menampilkan
            <strong>{{ $paginator->firstItem() }}</strong>
            sampai
            <strong>{{ $paginator->lastItem() }}</strong>
            dari
            <strong>{{ $paginator->total() }}</strong>
            data
        </div>

        <ul class="admin-pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="admin-page-item disabled" aria-disabled="true" aria-label="Sebelumnya">
                    <span class="admin-page-link"><i class="fa-solid fa-chevron-left"></i></span>
                </li>
            @else
                <li class="admin-page-item">
                    <a class="admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="admin-page-item disabled" aria-disabled="true">
                        <span class="admin-page-link dots">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="admin-page-item active" aria-current="page">
                                <span class="admin-page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="admin-page-item">
                                <a class="admin-page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="admin-page-item">
                    <a class="admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="admin-page-item disabled" aria-disabled="true" aria-label="Berikutnya">
                    <span class="admin-page-link"><i class="fa-solid fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
