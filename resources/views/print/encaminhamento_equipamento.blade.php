@extends('print.base_html')
@section('body')

	<div class="container-fluid">
		<div class="print-header">
			<div class="row">
				<div class="col-6">
					<div class="align-items-center justify-content-between">
						<img class="mx-3" style="max-width: 25%" src="{{asset('images/print/logo_rio.jpg')}}" alt="Rio" title="Rio" />
						<img class="mx-3" style="max-width: 25%" src="{{asset('images/print/logo_sgps.jpg')}}" alt="SGPS" title="SGPS" />
						<img class="mx-3" style="max-width: 25%" src="{{asset('images/print/logo_pic.jpg')}}" alt="PIC" title="PIC" />
					</div>
				</div>
				<div class="col-6 text-center py-5">
					<h1 style="font-size: 64pt;">Formulário de Encaminhamento</h1>
				</div>
			</div>
		</div>

		<table class="table print-table">
			<tbody>
				<tr>
					<td>
						<div class="print-table-label">Profissional responsável</div>
						<div class="print-table-content"></div>
					</td>
					<td>
						<div class="print-table-label">Data do encaminhamento</div>
						<div class="print-table-content"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>


@endsection