@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div>
	<div class="row">
		<div class="col-md-8">
			<label class="detail__label">FAMÍLIA</label>
			@if($family->personInCharge)
				<h3>Responsável: {{$family->personInCharge->name}}</h3>
			@endif
		</div>
		<div class="col-md-4">
			<label class="detail__label">ETIQUETAS</label>
			<div>
				@foreach($family->flags as $flag)
					<span class="badge badge-secondary">{{$flag->name}}</span>
				@endforeach
			</div>
		</div>
	</div>

	<hr />

	<entity-questions-panel key="forms_family_{{$family->id}}" entity-type="family" entity-id="{{$family->id}}" :can-edit="{{$permissions->canEdit($family) ? 'true' : 'false'}}"></entity-questions-panel>
</div>
