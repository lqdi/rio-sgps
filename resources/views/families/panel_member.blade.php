@php
/* @var $family \SGPS\Entity\Family */
/* @var $member \SGPS\Entity\Person */
@endphp
<div>
	<div class="row">
		<div class="col-md-8">
			<label class="detail__label">INDIVÍDUO</label>
			<h3>{{$member->name}}</h3>
			@if($member->id === $family->person_in_charge_id)<span class="badge badge-success">Responsável</span>@endif
			<span class="badge badge-primary">{{$member->gender}}</span>
			<span class="badge badge-info">{{$member->getAge()}} anos</span>
		</div>
		<div class="col-md-4">
			<label class="detail__label">ETIQUETAS</label>
			<div>
				@foreach($member->flags as $flag)
					<span class="badge badge-secondary">{{$flag->name}}</span>
				@endforeach
			</div>
		</div>
	</div>

	<hr />

	<entity-questions-panel key="forms_person_{{$member->id}}" entity-type="person" entity-id="{{$member->id}}"></entity-questions-panel>
</div>