@extends('shared.base_print')

@section('body')
	@include('print.header', ['title' => 'Formulário de encaminhamento'])

	@include('print.alert_forwarding')
@endsection