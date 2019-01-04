@extends('shared.base_print')

@section('body')

	@foreach($alerts as $alert)
		<div class="print-page">
			@include('print.header', ['title' => 'Formulário de encaminhamento'])

			@include('print.alert_forwarding', ['alert' => $alert, 'cras' => $alert->cras, 'cre' => $alert->cre])
		</div>
	@endforeach
@endsection