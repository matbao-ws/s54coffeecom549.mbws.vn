@if ($paginator->hasPages())
    @php
        $locale = app()->getLocale();
        $isVi = $locale === 'vi';
    @endphp
    <nav class="s54-pagination" aria-label="{{ $isVi ? 'Phân trang' : 'Pagination' }}" style="display: flex; flex-direction: column; align-items: center; gap: 16px; margin: 40px auto 20px; width: 100%;">
        {{-- Information counter --}}
        @if($paginator->total() > 0)
            <div class="s54-pagination__info" style="font-size: 13.5px; color: #6E6259; font-family: 'Inter', -apple-system, sans-serif;">
                @if($isVi)
                    Hiển thị <span style="font-weight: 700; color: #2F221A;">{{ $paginator->firstItem() }}</span> – <span style="font-weight: 700; color: #2F221A;">{{ $paginator->lastItem() }}</span> trên tổng số <span style="font-weight: 700; color: #D68E1D;">{{ $paginator->total() }}</span> kết quả
                @else
                    Showing <span style="font-weight: 700; color: #2F221A;">{{ $paginator->firstItem() }}</span> to <span style="font-weight: 700; color: #2F221A;">{{ $paginator->lastItem() }}</span> of <span style="font-weight: 700; color: #D68E1D;">{{ $paginator->total() }}</span> results
                @endif
            </div>
        @endif

        {{-- Page buttons list --}}
        <ul class="s54-pagination__list" style="display: flex; list-style: none !important; margin: 0 !important; padding: 0 !important; gap: 8px; align-items: center; flex-wrap: wrap; justify-content: center;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="s54-pagination__item is-disabled" aria-disabled="true" style="list-style: none !important; margin: 0;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; padding: 0 16px; border-radius: 6px; border: 1px solid #EBE7E1; background: #F5F2ED; color: #B8ABA0; font-size: 13.5px; font-weight: 600; cursor: not-allowed; text-decoration: none; user-select: none; gap: 4px;">
                        &lsaquo; {{ $isVi ? 'Trước' : 'Prev' }}
                    </span>
                </li>
            @else
                <li class="s54-pagination__item" style="list-style: none !important; margin: 0;">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; padding: 0 16px; border-radius: 6px; border: 1px solid #D6C7BC; background: #FFFFFF; color: #2F221A; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.04); gap: 4px;" onmouseover="this.style.borderColor='#D68E1D';this.style.background='#FAF6F1';" onmouseout="this.style.borderColor='#D6C7BC';this.style.background='#FFFFFF';">
                        &lsaquo; {{ $isVi ? 'Trước' : 'Prev' }}
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="s54-pagination__item is-separator" aria-disabled="true" style="list-style: none !important; margin: 0;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 42px; color: #8A7B70; font-size: 14px; font-weight: 700; user-select: none;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="s54-pagination__item is-active" aria-current="page" style="list-style: none !important; margin: 0;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid #2F221A; background: #2F221A; color: #FAF6F1; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(47,34,26,0.25); user-select: none;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="s54-pagination__item" style="list-style: none !important; margin: 0;">
                                <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid #EBE7E1; background: #FFFFFF; color: #2F221A; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.04);" onmouseover="this.style.borderColor='#D68E1D';this.style.background='#FAF6F1';this.style.color='#D68E1D';" onmouseout="this.style.borderColor='#EBE7E1';this.style.background='#FFFFFF';this.style.color='#2F221A';">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="s54-pagination__item" style="list-style: none !important; margin: 0;">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; padding: 0 16px; border-radius: 6px; border: 1px solid #D6C7BC; background: #FFFFFF; color: #2F221A; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.04); gap: 4px;" onmouseover="this.style.borderColor='#D68E1D';this.style.background='#FAF6F1';" onmouseout="this.style.borderColor='#D6C7BC';this.style.background='#FFFFFF';">
                        {{ $isVi ? 'Sau' : 'Next' }} &rsaquo;
                    </a>
                </li>
            @else
                <li class="s54-pagination__item is-disabled" aria-disabled="true" style="list-style: none !important; margin: 0;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; padding: 0 16px; border-radius: 6px; border: 1px solid #EBE7E1; background: #F5F2ED; color: #B8ABA0; font-size: 13.5px; font-weight: 600; cursor: not-allowed; text-decoration: none; user-select: none; gap: 4px;">
                        {{ $isVi ? 'Sau' : 'Next' }} &rsaquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
