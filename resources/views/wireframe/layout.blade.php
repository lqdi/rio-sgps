@extends('base_html')
@section('body')

	@include('navbar')

	<main role="main" style="margin-top: 55px;">
		@yield('main')
	</main>
@endsection