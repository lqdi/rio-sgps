@php /* @var $alert \SGPS\Entity\Family */ @endphp
@php /* @var $cras \SGPS\Entity\Equipment */ @endphp
@php /* @var $cre \SGPS\Entity\Equipment */ @endphp

<div class="print-table">
	<div class="print-row print-single-line">
		<div class="print-cell print-w-40">
			<div class="print-cell-label">Profissional responsável</div>
		</div>
		<div class="print-cell print-w-25">
			<div class="print-cell-label">Data do encaminhamento</div>
		</div>
		<div class="print-cell print-w-10">
			<div class="print-cell-label">Dia</div>
		</div>
		<div class="print-cell print-w-10">
			<div class="print-cell-label">Mês</div>
		</div>
		<div class="print-cell print-w-15">
			<div class="print-cell-label">Ano</div>
		</div>
	</div>
	<div class="print-row print-single-line">
		<div class="print-cell print-w-30">
			<div class="print-cell-label">Matrícula ou CPF</div>
		</div>
		<div class="print-cell print-w-70">
			<div class="print-cell-label">OBS:</div>
		</div>
	</div>
</div>

<div class="print-table">
	<div class="print-row print-single-line">
		<div class="print-cell print-w-60">
			<div class="print-cell-label"><div class="print-subheader">Dados do domicílio</div></div>
		</div>
		<div class="print-cell print-w-40">
			<div class="print-cell-label">Código SGPS</div>
			<div class="print-cell-value"><div class="print-subheader">{{$alert->shortcode}}</div></div>
		</div>
	</div>
	<div class="print-row print-single-line">
		<div class="print-cell print-w-50">
			<div class="print-cell-label">Nome do entrevistado:</div>
			<div class="print-cell-value">{{$alert->personInCharge->name ?? '---'}}</div>
		</div>
		<div class="print-cell print-w-50">
			<div class="print-cell-label">Endereço do domicílio:</div>
			<div class="print-cell-value">{{$alert->residence->address ?? '---'}}</div>
		</div>
	</div>
	<div class="print-row print-single-line">
		<div class="print-cell print-w-50">
			<div class="print-cell-label">Telefone</div>
			<div class="print-cell-value">{{$alert->personInCharge->phone_number ?? '---'}}</div>
		</div>
		<div class="print-cell print-w-50">
			<div class="print-cell-label">Ponto de referência</div>
			<div class="print-cell-value">{{$alert->residence->reference ?? '---'}}</div>
		</div>
	</div>
</div>

<div class="print-subheader my-5">
	Órgãos de destino:
</div>

<div class="print-table">
	<div class="print-row print-single-line">
		<div class="print-cell print-w-30">
			<div class="print-cell-label">RP / AP / RA / Bairro / Setor</div>
			<div class="print-cell-value"><small>{{$alert->sector->cod_rp}} / {{$alert->sector->cod_ap}} / {{$alert->sector->cod_ra}} / {{$alert->sector->cod_bairro}} / {{$alert->sector_id}}</small></div>
		</div>
		<div class="print-cell print-w-70">
			<div class="print-cell-label">CRAS</div>
			<div class="print-cell-value">{{$cras->name}} <small>(cód {{$cras->code}})</small></div>
		</div>
	</div>
	<div class="print-row print-double-line">
		<div class="print-cell print-w-100">
			<div class="print-cell-label">Endereço</div>
			<div class="print-cell-value"><small>{{$cras->alert}}</small></div>
		</div>
	</div>
	<div class="print-row print-single-line">
		<div class="print-cell print-w-100">
			<div class="print-cell-label">Nome do Responsável da família</div>
		</div>
	</div>
	<div class="print-row print-single-line">
		<div class="print-cell print-w-50">
			<div class="print-cell-label">CPF:</div>
		</div>
		<div class="print-cell print-w-50">
			<div class="print-cell-label">NIS:</div>
		</div>
	</div>
	<div class="print-row print-single-line">
		<div class="print-cell print-w-50">
			<div class="print-cell-label">Telefone:</div>
		</div>
		<div class="print-cell print-w-50">
			<div class="print-cell-label">OBS:</div>
		</div>
	</div>
</div>

<div class="print-table">
	<div class="print-row print-single-line">
		<div class="print-cell print-w-10">
		</div>
		<div class="print-cell print-w-90">
			<div class="print-cell-value print-cell-single-line print-no-label">
				<small>
					Marcar ao lado e encaminhar à CRE se houver criança entre 4 e 14 anos fora da escola
				</small>
			</div>
		</div>
	</div>
	<div class="print-row print-double-line">
		<div class="print-cell print-w-30">
			<div class="print-cell-label">CRE</div>
			<div class="print-cell-value">{{$cre->name}} <small>(cód {{$cre->code}})</small></div>
		</div>
		<div class="print-cell print-w-70">
			<div class="print-cell-label">Endereço</div>
			<div class="print-cell-value"><small>{{$cre->address}}</small></div>
		</div>
	</div>
</div>