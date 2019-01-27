@php
	/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-12">
		<label class="detail__label">ETIQUETAS</label>

		<div class="row">

			@if($permissions->canEdit($family))
				<div class="col-md-12 text-center">
					<button type="button" class="btn btn-lg btn-primary" @click="addFlag()"><i class="fa fa-plus"></i> Adicionar etiqueta</button>
					<hr />
				</div>
			@endif

			@foreach($family->allFlagAttributions as $attribution)
				<div class="col-md-3">
					@include('components.flag_attribution_card', ['attribution' => $attribution])
					<br />
				</div>
			@endforeach

		</div>
	</div>
</div>