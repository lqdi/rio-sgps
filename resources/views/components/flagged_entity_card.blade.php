<div class="card">
	<div class="card-header {{\SGPS\Utils\Decorators::getFlagBackgroundClass($flag)}} text-white">
		<strong><i class="fa fa-tag"></i> {{$flag->name}}</strong>
	</div>
	<div class="card-body">
		@if($flag->pivot->entity_type === 'family')<div class="text-primary"><i class="fa fa-users"></i> Família</div>@endif
		@if($flag->pivot->entity_type === 'residence')<div class="text-success"><i class="fa fa-home"></i> Domicílio</div>@endif
		@if($flag->pivot->entity_type === 'person')<div class="text-warning"><i class="fa fa-male"></i> Indivíduo: {{$person->name ?? '---'}}</div>@endif

		<div><i v-b-tooltip title="Data de atribuição" class="fa fa-calendar"></i> {{$flag->pivot->reference_date}}</div>
		<div><i v-b-tooltip title="Operador responsável" class="fa fa-user"></i> ---</div>
		<div><i v-b-tooltip title="Prazo para resolução" class="fa fa-clock"></i> {{$flag->pivot->deadline}} (em --- dias)</div>
	</div>
	<div class="card-footer">
		<button type="button" v-b-tooltip title="Marcar etiqueta como resolvida" class="btn btn-sm mx-1 btn-outline-success pull-right"><i class="fa fa-check"></i> Concluído</button>
		<button type="button" v-b-tooltip title="Cancelar e remover etiqueta" class="btn btn-sm mx-1 btn-outline-danger pull-right"><i class="fa fa-trash"></i> Cancelar</button>
	</div>
</div>