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
		<div class="col-md-12">
			<label class="detail__label">FAMÍLIAS NESSE DOMICÍLIO</label>
			<div>
				@foreach($residence->families as $f)
					@if($f->id === $family->id)
						<div class="btn btn-primary"><i class="fa fa-arrow-right"></i> <i class="fa fa-users"></i> {{$f->shortcode}}</div>
					@else
						<a class="btn btn-outline-primary" href="{{route('families.show', [$f->id])}}"><i class="fa fa-users"></i> {{$f->shortcode}}</a>
					@endif
				@endforeach
			</div>
		</div>
	</div>

	<hr />

	<entity-questions-panel key="forms_residence_{{$residence->id}}" entity-type="residence" entity-id="{{$residence->id}}" :can-edit="{{$permissions->canEdit($residence) ? 'true' : 'false'}}"></entity-questions-panel>
</div>