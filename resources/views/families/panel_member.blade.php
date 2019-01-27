@php
/* @var $family \SGPS\Entity\Family */
/* @var $member \SGPS\Entity\Person */
@endphp
<div>
	<div class="row">
		<div class="col-md-8">
			<label class="detail__label">INDIVÍDUO</label>
			<h3>{{$member->name}}</h3>

			@if($member->id === $family->person_in_charge_id)
				<span class="badge badge-success">Responsável</span>
			@endif

			<span class="badge badge-primary">{{$member->gender}}</span>

			@if($member->hasAgeAvailable())
				<span class="badge badge-info">{{$member->getAge()}} anos</span>
			@endif

			@if($member->isArchived())
				<div>
					<h4 class="badge badge-danger">Ficha arquivada: {{trans('reasons.' . $member->archived_reason)}}</h4>
					<p>Arquivado por <strong>{{$member->archivedBy ?? '???'}}</strong></p>
				</div>
			@else
				<div>
					<a @click="archiveFamilyMember('{{$member->id}}')" class="btn btn-light text-danger"><i class="fa fa-archive"></i> Arquivar ficha</a>
				</div>
			@endif
		</div>
		@if(!$member->isArchived())
			<div class="col-md-4">
				<label class="detail__label">ETIQUETAS</label>
				<div>
					@foreach($member->flags as $flag)
						<span class="badge badge-secondary">{{$flag->name}}</span>
					@endforeach
				</div>
			</div>
		@endif
	</div>

	@if(!$member->isArchived())
		<hr />

		<entity-questions-panel key="forms_person_{{$member->id}}" entity-type="person" entity-id="{{$member->id}}" :can-edit="{{$permissions->canEdit($member) ? 'true' : 'false'}}"></entity-questions-panel>
	@endif
</div>