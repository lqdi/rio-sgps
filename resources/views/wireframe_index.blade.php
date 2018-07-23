@extends('layout')
@section('main')
	<div class="col-md-12">
		<h1 class="mt-5">Páginas do wireframe</h1>
		<hr />

		@foreach($pages as $page)
			<a class="btn btn-block btn-outline-secondary" href="{{route('wireframe.view', [$page])}}">{{$page}}</a>
		@endforeach

	</div>
@endsection