@php
/* @var $residence \SGPS\Entity\Residence */
/* @var $family \SGPS\Entity\Family */
@endphp
<div>
	<div class="row">
		<div class="col-md-8">
			<label class="detail__label">DOMICÍLIO</label>
			<h3>{{$residence->address}}</h3>
		</div>
		<div class="col-md-4">
			<label class="detail__label">ETIQUETAS</label>
			<div>
				@foreach($residence->flags as $flag)
					<span class="badge badge-secondary">{{$flag->name}}</span>
				@endforeach
			</div>
		</div>
	</div>

	<hr />

	<forms-panel entity-type="residence" entity-id="{{$residence->id}}"></forms-panel>
</div>