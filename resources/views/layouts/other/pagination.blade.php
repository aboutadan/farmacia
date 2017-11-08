@if ($results->hasPages())
    <div class="pagination_container">

        <div class="col-xs-6 col-sm-6  col-md-4 total">
            Resultados: <strong>{{ $results->total() }}</strong>
        </div>

        {{-- Links to show Previous and Next --}}
        <div class="hidden-xs hidden-sm col-md-4 links">
            
            <a href="{{ $results->currentPage() === 1 ? 'javascript:void();' : $results->previousPageUrl() }}" class="{{ $results->currentPage() === 1 ? 'disabled' : '' }} left">
                <i class="fa fa-angle-double-left" aria-hidden="true"></i> Anterior
            </a>
            

            <a href="{{ $results->currentPage() === $results->lastPage() ? 'javascript:void();' : $results->nextPageUrl() }}" class="{{ $results->currentPage() === $results->lastPage() ? 'disabled' : '' }} right">
                Siguiente <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </a>
            
        </div>

        <div class="col-xs-6 col-sm-6 col-md-4 current_page">
            Página <strong>{{ $results->currentPage() }} de {{ $results->lastPage() }}</strong>
        </div>
    </div>

@else
    <div class="pagination_container">
        <div class="col-xs-6">
            Resultados: <strong>{{ $results->total() }}</strong>
        </div>

        <div class="col-xs-6 current_page">
            Página <strong>{{ $results->currentPage() }} de {{ $results->lastPage() }}</strong>
        </div>
    </div>


@endif