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

			<div class="mt-1 mb-2">
				<a target="_blank" href="{{route('families.index', ['filters[sector_id]' => $family->sector_id])}}" class="btn btn-light border-secondary">
					<i v-b-tooltip title="Região censitária" class="fa fa-map"></i> Setor RJ / <strong>{{$family->sector->name ?? "{$family->sector_id} (?)"}}</strong>
				</a>
			</div>

			@if($family->sector)
				<div class="row my-3">
					<div class="col-md-6">
						<div><i v-b-tooltip title="Bairro" class="fa fa-map-marker"></i> Bairro: <strong>{{$family->sector->getBairro()->name}}</strong></div>
						<div><i v-b-tooltip title="Região Administrativa (RA)" class="fa fa-map-marker"></i> RA: <strong>{{$family->sector->getRA()->name}}</strong></div>
						<div><i v-b-tooltip title="Região de Planejamento (RP)" class="fa fa-map-marker"></i> RP: <strong>{{$family->sector->getRP()->name}}</strong></div>
						<div><i v-b-tooltip title="Área de Planejamento (AP)" class="fa fa-map-marker"></i> AP: <strong>{{$family->sector->cod_ap}}</strong></div>
					</div>
					<div class="col-md-6">
						<div><i class="fa fa-cog"></i> CRE: <strong>{{$family->sector->cod_cre}}</strong></div>
						<div><i class="fa fa-cog"></i> CAP: <strong>{{$family->sector->cod_cap}}</strong></div>
						<div><i class="fa fa-cog"></i> CASDH: <strong>{{$family->sector->cod_casdh}}</strong></div>
						<div><i class="fa fa-cog"></i> CMS: <strong>{{$family->sector->cod_cms}}</strong></div>
					</div>
				</div>
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