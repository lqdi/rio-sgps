@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-12">
		<label class="detail__label">REGISTRO DE ATIVIDADES</label>

		<activity-log-panel entity-type="family" entity-id="{{$family->id}}"></activity-log-panel>
	</div>
</div>