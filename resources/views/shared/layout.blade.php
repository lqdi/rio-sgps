@extends('shared.base_html')
@section('body')

	@include('shared.navbar')

	<main role="main" style="margin-top: 55px;">
		@yield('main')
	</main>
@endsection