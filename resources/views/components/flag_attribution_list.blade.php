<table class="table">
	<thead>
	<tr>
		<th>Tipo</th>
		<th>Etiqueta</th>
		<th>Nome</th>
		<th>Data</th>
		<th>Prazo</th>
		<th>Cód.</th>
	</tr>
	</thead>
	<tbody>

	@if(sizeof($attributions) <= 0)
		<tr>
			<td colspan="6" class="text-center text-secondary">Nenhuma etiqueta atribuida!</td>
		</tr>
	@endif

	@foreach($attributions as $attribution)
		@php /* @var $attribution \SGPS\Entity\FlagAttribution */ @endphp
		<tr>
			<td>
				<span class="badge badge-light">
					@if($attribution->entity_type === 'family')<div class="text-primary"><i class="fa fa-users"></i> Família</div>@endif
					@if($attribution->entity_type === 'residence')<div class="text-success"><i class="fa fa-home"></i> Domicílio</div>@endif
					@if($attribution->entity_type === 'person')<div class="text-info"><i class="fa fa-male"></i> Indivíduo</div>@endif
				</span>
			</td>
			<td>
				<small><strong>{{$attribution->flag->name}}</strong></small>
			</td>
			<td>
				<small>
					@if($attribution->entity_type === 'family') {{$attribution->residence->address}} @endif
					@if($attribution->entity_type === 'residence') {{$attribution->entity->address}} @endif
					@if($attribution->entity_type === 'person') {{$attribution->entity->name}} @endif
				</small>
			</td>
			<td>
				<div>
					<span class="badge badge-light"><i class="fa fa-calendar"></i> {{$attribution->reference_date->format('d/m/Y')}}</span>
				</div>
			</td>
			<td>
				@php
					$deadline = \SGPS\Utils\Hydrators::getDeadlineDate($attribution->reference_date, $attribution->deadline);
				@endphp

				<div>
					<span class="badge badge-light"><i class="fa fa-clock"></i> {{$deadline->format('d/m/Y')}}</span>
				</div>
				<div>
					@if($attribution->is_late)
						<span title="Atrasado!" class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> {{$deadline->diffForHumans()}}</span>
					@else
						<span title="No prazo" class="badge badge-primary">{{$deadline->diffForHumans()}}</span>
					@endif
				</div>
			</td>
			<td>
				<a href="{{route('families.go_to_residence', [$attribution->residence->id])}}" class="btn btn-sm text-danger btn-outline-danger">{{$attribution->entity->shortcode}}</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

{!! $attributions->links() !!}