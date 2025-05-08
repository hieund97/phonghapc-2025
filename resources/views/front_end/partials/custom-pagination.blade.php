@if ($paginator->hasPages())
    <div class="custom_pagination">
        @if ($paginator->onFirstPage())
            <a class="arrow" id="prevPage" disabled>← <span class="nav-text"></span></a>
        @else
            <a class="arrow" id="prevPage" href="{{ $paginator->previousPageUrl() }}">← <span
                        class="nav-text"></span></a>
        @endif
        <div class="pages">
            @foreach ($elements as $element)

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <div class="page-number active">{{ $page }}</div>
                        @else
                            <div class="page-number">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a class="arrow" id="nextPage" href="{{ $paginator->nextPageUrl() }}"><span class="nav-text"></span> →</a>
        @else
            <a class="arrow" id="nextPage" disabled href="{{ $paginator->nextPageUrl() }}"><span
                        class="nav-text"></span> →</a>
        @endif
    </div>
@endif

<style>
    .custom_pagination{
        text-align:center;
        margin-top:40px;
        display:flex;
    }

    .custom_pagination .pages{
        display:flex;
        align-items:center;
        max-width:100%;
    }

    .custom_pagination .pages .page-number{
        cursor:pointer;
        background-color:white;
        color:#999;
        border-radius:50%;
        height:30px;
        width:30px;
        display:flex;
        align-items:center;
        justify-content:center;
        transition:.4s ease;
        border:1px solid;
        margin:0 10px;
    }

    .custom_pagination .pages .active{
        font-size:1.3em;
        height:40px;
        width:40px;
        background-color:#0057b3;
        color:white;
    }

    .custom_pagination a{
        padding:8px 16px;
        background-color:#ffffff00;
        color:#0057b3;
        border:none;
        cursor:pointer;
        margin:0 5px;
        display:flex;
        align-items:center;
    }

    .custom_pagination a:hover{
        color:#0056b3;
    }

    .custom_pagination a:disabled{
        background-color:#ffffff00;
        color:#ccc;
        cursor:not-allowed;
    }

    .custom_pagination .arrow{
        font-size:1.2em;
    }

    .custom_pagination .nav-text{
        font-size:0.7em;
        letter-spacing:0.3em;
    }
</style>

