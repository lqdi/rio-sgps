@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div>
	<div class="row">
		<div class="col-md-8">
			<label class="detail__label">FAMÍLIA</label>
			<h3>Responsável: {{$family->personInCharge->name}}</h3>
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

	<forms-panel entity-type="family" entity-id="{{$family->id}}"></forms-panel>
</div>
