@php /* @var $permissions \SGPS\Utils\FamilyPermissionGrid */ @endphp
@php /* @var $entity \SGPS\Entity\Entity */ @endphp
@if($permissions->canEdit($entity))
	<i v-b-tooltip.hover title="Permissão de editar" class="fa fa-edit text-secondary {{$class ?? ''}}"></i>
@elseif($permissions->canView($entity))
	<i v-b-tooltip.hover title="Permissão de visualizar" class="fa fa-eye text-secondary {{$class ?? ''}}"></i>
@else
	<i v-b-tooltip.hover title="Sem acesso" class="fa fa-ban text-secondary {{$class ?? ''}}"></i>
@endif