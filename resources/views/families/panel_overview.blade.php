@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-8">
		<label class="detail__label">VISÃO GERAL</label>
		<h3>Família #{{$family->shortcode}} - {{$family->residence->address}}</h3>
		<div><i class="fa fa-calendar"></i> Alerta registrado {{$family->created_at->diffForHumans()}}</div>
		@if($family->caseOpenedBy) <div><i class="fa fa-user"></i> Caso aberto por {{$family->caseOpenedBy->name}}</div> @endif
	</div>
	<div class="col-md-4">
		<label class="detail__label">LOCALIZAÇÃO</label>
		<div>
			<i v-b-tooltip title="Região censitária" class="fa fa-map"></i> RJ / {{$family->sector->id ?? "{$family->sector_id} (?)"}}<br />
			<i v-b-tooltip title="Endereço" class="fa fa-map-marker"></i> {{$family->residence->address}}
		</div>
	</div>
</div>

<br />

<div class="row">
	<div class="col-md-8">
		<div>
			<label class="detail__label">LOCALIZAÇÃO</label>

			<div><i v-b-tooltip title="Região censitária" class="fa fa-map"></i> RJ / {{$family->sector->id ?? "{$family->sector_id} (?)"}}</div>
			@if($family->sector)
				<div><i v-b-tooltip title="Bairro" class="fa fa-map-marker"></i> Bairro {{$family->sector->getBairro()->name}}</div>
				<div><i v-b-tooltip title="Região Administrativa (RA)" class="fa fa-map-marker"></i> RA {{$family->sector->getRA()->name}}</div>
				<div><i v-b-tooltip title="Região de Planejamento (RP)" class="fa fa-map-marker"></i> RP {{$family->sector->getRP()->name}}</div>
				<div><i v-b-tooltip title="Área de Planejamento (AP)" class="fa fa-map-marker"></i> AP {{$family->sector->cod_ap}}</div>
			@else
				<div class="text-danger"><i class="fa fa-exclamation-triangle"></i> Código de setor {{$family->sector_id}} não registrado no SGPS!</div>
			@endif
		</div>

		@if($family->sector)
			<hr />

			<div>
				<label class="detail__label">EQUIPAMENTOS</label>
				@foreach($family->sector->equipments as $equipment)
					<div><i class="fa fa-university"></i> {{$equipment->type}} - {{$equipment->name}}</div>
					<div><small>{{$equipment->address}}</small></div>
					<br />
				@endforeach
			</div>
		@endif
	</div>
	<div class="col-md-4">
		<label class="detail__label">SITUAÇÃO</label>
		<div>
			<h3 class="text-danger">{{$family->ipm_rate}} <br /><small>pontos no IPM</small></h3>
		</div>
	</div>
</div>