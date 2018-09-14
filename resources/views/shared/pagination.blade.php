<div class="col-md-12 d-flex justify-content-center">
	@if ($paginator->hasPages())
		<ul class="pagination">
			{{-- Previous Page Link --}}
			@if ($paginator->onFirstPage())
				<li class="page-item disabled"><span class="page-link"><i class="fa fa-arrow-left"></i></span></li>
			@else
				<li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-arrow-left"></i></a></li>
			@endif

			{{-- Pagination Elements --}}
			@foreach ($elements as $element)
				{{-- "Three Dots" Separator --}}
				@if (is_string($element))
					<li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
				@endif

				{{-- Array Of Links --}}
				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="page-item active"><span class="page-link">{{ $page }}</span></li>
						@else
							<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
						@endif
					@endforeach
				@endif
			@endforeach

			{{-- Next Page Link --}}
			@if ($paginator->hasMorePages())
				<li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-arrow-right"></i></a></li>
			@else
				<li class="page-item disabled"><span class="page-link"><i class="fa fa-arrow-right"></i></span></li>
			@endif
		</ul>
	@endif
</div>