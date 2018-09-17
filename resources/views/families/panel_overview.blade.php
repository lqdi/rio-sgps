@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-8">
		<label class="detail__label">VISÃO GERAL</label>
		<h3>Família #{{$family->shortcode}} - {{$family->residence->address}}</h3>
		<div>Alerta registrado por <i class="fa fa-user"></i> ---</div>
		<div>Caso aberto por <i class="fa fa-user"></i> ---</div>
	</div>
	<div class="col-md-4">
		<label class="detail__label">LOCALIZAÇÃO</label>
		<div>
			<i v-b-tooltip title="Região censitária" class="fa fa-map"></i> RJ / {{$family->residence->sector_code}}<br />
			<i v-b-tooltip title="Endereço" class="fa fa-map-marker"></i> {{$family->residence->address}}
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-md-8">
		<label class="detail__label">EQUIPAMENTOS</label>
		<div><i class="fa fa-university"></i> CRAS ---</div>
		<div><i class="fa fa-university"></i> CRE ---</div>
		<div><i class="fa fa-university"></i> CSF ---</div>
		<div><i class="fa fa-university"></i> CASDH ---</div>
	</div>
	<div class="col-md-4">
		<label class="detail__label">SITUAÇÃO</label>
		<div>
			<h3 class="text-danger">{{$family->ipm_rate}} <br /><small>pontos no IPM</small></h3>
		</div>
	</div>
</div>