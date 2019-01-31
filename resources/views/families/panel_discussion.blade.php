@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-12">
		<label class="detail__label">DISCUSSÃO</label>

		<comments-panel entity-type="family" entity-id="{{$family->id}}" :is-admin="{{auth()->user()->level === \SGPS\Constants\UserLevel::ADMIN ? 'true' : 'false'}}"></comments-panel>
	</div>
</div>