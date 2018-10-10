<div class="card @if($flag->pivot->is_cancelled) card-disabled @endif">
	<div class="card-header {{\SGPS\Utils\Decorators::getFlagBackgroundClass($flag)}} text-white">
		<strong><i class="fa fa-tag"></i> {{$flag->name}}</strong>
	</div>
	<div class="card-body">
		@if($flag->pivot->entity_type === 'family')<div class="text-primary"><i class="fa fa-users"></i> Família</div>@endif
		@if($flag->pivot->entity_type === 'residence')<div class="text-success"><i class="fa fa-home"></i> Domicílio</div>@endif
		@if($flag->pivot->entity_type === 'person')<div class="text-info"><i class="fa fa-male"></i> Indivíduo: {{$person->name ?? '---'}}</div>@endif

		<div><i v-b-tooltip title="Data de atribuição" class="fa fa-calendar"></i> {{$flag->pivot->reference_date}}</div>
		<div><i v-b-tooltip title="Prazo para resolução" class="fa fa-clock"></i> {{\SGPS\Utils\Decorators::getFlagDeadline($flag->pivot->reference_date, $flag->pivot->deadline)}}</div>
	</div>
	<div class="card-footer">
		@if(!$flag->pivot->is_cancelled && !$flag->pivot->is_completed)
			<button type="button" v-b-tooltip @click="completeFlagAssignment('{{$flag->pivot->entity_type}}', '{{$flag->pivot->entity_id}}', '{{$flag->id}}')" title="Marcar etiqueta como resolvida" class="btn btn-sm mx-1 btn-outline-success pull-right"><i class="fa fa-check"></i> Concluído</button>
			<button type="button" v-b-tooltip @click="cancelFlagAssignment('{{$flag->pivot->entity_type}}', '{{$flag->pivot->entity_id}}', '{{$flag->id}}')" title="Cancelar e remover etiqueta" class="btn btn-sm mx-1 btn-outline-danger pull-right"><i class="fa fa-trash"></i> Cancelar</button>
		@elseif($flag->pivot->is_cancelled)
			<div class="badge badge-danger"><i class="fa fa-ban"></i> Etiqueta cancelada!</div>
		@elseif($flag->pivot->is_completed)
			<div class="badge badge-success"><i class="fa fa-check"></i> Etiqueta concluída!</div>
		@endif
	</div>
</div>