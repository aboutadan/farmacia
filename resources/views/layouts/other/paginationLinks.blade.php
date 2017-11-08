@if ($results->hasPages())
    <div class="pagination_container hidden-md hidden-lg">
        {{-- Links to show Previous and Next --}}
        <div class="col-xs-12">
            <div class="col-xs-4 pad-0 links">
                <a href="{{ $results->currentPage() === 1 ? 'javascript:void();' : $results->previousPageUrl() }}" class="{{ $results->currentPage() === 1 ? 'disabled' : '' }}">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Anterior
                </a>
            </div>

            <div class="col-xs-4 pad-0 current_page center">
                Página <strong>{{ $results->currentPage() }} de {{ $results->lastPage() }}</strong>
            </div>

            <div class="col-xs-4 pad-0 links">
                <a href="{{ $results->currentPage() === $results->lastPage() ? 'javascript:void();' : $results->nextPageUrl() }}" class="{{ $results->currentPage() === $results->lastPage() ? 'disabled' : '' }} right">
                    Siguiente <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
@endif