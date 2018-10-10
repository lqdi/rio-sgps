@php
	/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-12">
		<label class="detail__label">ETIQUETAS</label>

		<div class="row">

			<div class="col-md-12 text-center">
				<button type="button" class="btn btn-lg btn-primary" @click="addFlag()"><i class="fa fa-plus"></i> Adicionar etiqueta</button>
				<hr />
			</div>

			@foreach($family->flags as $flag)
				<div class="col-md-3">
					@include('components.flagged_entity_card', ['flag' => $flag])
					<br />
				</div>
			@endforeach

			@foreach($family->residence->flags as $flag)
				<div class="col-md-3">
					@include('components.flagged_entity_card', ['flag' => $flag])
					<br />
				</div>
			@endforeach

			@foreach($family->members as $member)
				@foreach($member->flags as $flag)
					<div class="col-md-3">
						@include('components.flagged_entity_card', ['flag' => $flag, 'person' => $member])
						<br />
					</div>
				@endforeach
			@endforeach
		</div>
	</div>
</div>