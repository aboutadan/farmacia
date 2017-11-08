@if ($results->hasPages())
    <div class="col-sm-12 pad-0 pagination_container center">
        {{-- Links to show Previous and Next --}}
        <div class="col-sm-12 pad-0 links">
            <a href="{{ $results->currentPage() === 1 ? 'javascript:void();' : $results->previousPageUrl() }}" class="{{ $results->currentPage() === 1 ? 'disabled' : '' }} l">
            	<i class="fa fa-angle-double-left" aria-hidden="true"></i> Anterior
            </a>
            <a href="{{ $results->currentPage() === $results->lastPage() ? 'javascript:void();' : $results->nextPageUrl() }}" class="{{ $results->currentPage() === $results->lastPage() ? 'disabled' : '' }} r">
            	Siguiente <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endif