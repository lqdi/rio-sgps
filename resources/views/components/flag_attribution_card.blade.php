<div class="card @if($attribution->is_cancelled) card-disabled @endif">
	@php
		$deadline = \SGPS\Utils\Hydrators::getDeadlineDate($attribution->reference_date, $attribution->deadline);
	@endphp
	<div class="card-header {{\SGPS\Utils\Decorators::getFlagAttributionBackgroundClass($attribution)}} text-white">
		<strong><i class="fa fa-tag"></i> {{$attribution->flag->name}}</strong>
	</div>
	<div class="card-body">
		@if($attribution->entity_type === 'family')<div class="text-primary"><i class="fa fa-users"></i> Família</div>@endif
		@if($attribution->entity_type === 'residence')<div class="text-success"><i class="fa fa-home"></i> Domicílio</div>@endif
		@if($attribution->entity_type === 'person')<div class="text-info"><i class="fa fa-male"></i> Indivíduo: {{$person->name ?? '---'}}</div>@endif

		<div><i v-b-tooltip title="Data de atribuição" class="fa fa-calendar"></i> {{$attribution->reference_date}}</div>

		@if(!$attribution->is_cancelled && !$attribution->is_completed)
			<div class="@if($deadline->isPast()) text-danger @endif"><i v-b-tooltip title="Prazo para resolução" class="fa fa-clock"></i> {{\SGPS\Utils\Decorators::getFlagDeadline($deadline)}}</div>
		@endif
	</div>
	<div class="card-footer">
		@if($permissions->canEdit($attribution->entity))
			@if(!$attribution->is_cancelled && !$attribution->is_completed)
				<button type="button" v-b-tooltip @click="completeFlagAttribution('{{$attribution->entity_type}}', '{{$attribution->entity_id}}', '{{$attribution->flag->id}}')" title="Marcar etiqueta como resolvida" class="btn btn-sm mx-1 btn-outline-success pull-right"><i class="fa fa-check"></i> Concluído</button>
				<button type="button" v-b-tooltip @click="cancelFlagAttribution('{{$attribution->entity_type}}', '{{$attribution->entity_id}}', '{{$attribution->flag->id}}')" title="Cancelar e remover etiqueta" class="btn btn-sm mx-1 btn-outline-danger pull-right"><i class="fa fa-trash"></i> Cancelar</button>
			@elseif($attribution->is_cancelled)
				<div class="badge badge-danger"><i class="fa fa-ban"></i> Etiqueta cancelada!</div>
			@elseif($attribution->is_completed)
				<div class="badge badge-success"><i class="fa fa-check"></i> Etiqueta concluída!</div>
			@endif
		@else
			<div class="badge badge-secondary">Etiqueta associada a outra secretaria</div>
		@endif
	</div>
</div>