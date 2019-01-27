@extends('shared.layout')
@php /* @var $family \SGPS\Entity\Family */ @endphp
@php /* @var $permissions \SGPS\Utils\FamilyPermissionGrid */ @endphp
@section('main')
	<div is="family-view"
	     inline-template
	     :family="{{json_encode($family)}}"
	>
		<div class="case__container">
			<loading-feedback :is-loading="isLoading"></loading-feedback>

			<div class="sgps__topbar">

				<div class="row">
					<div class="col-md-9">
						<h1>Família #{{$family->shortcode}}</h1>
						<p><i class="fa fa-home"></i> {{$family->residence->address}}</p>
					</div>
					<div class="col-md-3">
						<div class="pt-3">
							<i class="fa fa-calendar"></i> Data Abertura: {{$family->created_at}}
						</div>
					</div>
				</div>

			</div>

			<div class="sgps__sidebar">

				<a @click="openTab('overview')" href="#overview" :class="{active: isOpen('overview')}" class="sgps__sidebar-link"><i class="fa fa-info-circle"></i> Visão Geral</a>
				<a @click="openTab('discussion')" href="#discussion" :class="{active: isOpen('discussion')}" class="sgps__sidebar-link"><i class="fa fa-comments"></i> Discussão</a>
				<a @click="openTab('activity_log')" href="#activity_log" :class="{active: isOpen('activity_log')}" class="sgps__sidebar-link"><i class="fa fa-history"></i> Registro de atividades</a>
				<a @click="openTab('assignments')" href="#assignments" :class="{active: isOpen('assignments')}" class="sgps__sidebar-link"><i class="fa fa-users"></i> Operadores</a>
				<a @click="openTab('flags')" href="#flags" :class="{active: isOpen('flags')}" class="sgps__sidebar-link"><i class="fa fa-tags"></i> Etiquetas</a>

				<hr />

				<a @click="openTab('residence')" href="#residence" :class="{active: isOpen('residence')}" class="sgps__sidebar-link">
					<i class="fa fa-home"></i> Domicílio
					@include('components.entity_permission_icon', ['permissions' => $permissions, 'entity' => $family->residence, 'class' => 'pull-right mt-3 mr-1'])
				</a>

				<div class="tree__container">
					<a @click="openTab('family')" href="#family" :class="{active: isOpen('family')}" class="tree__leaf">
						<i class="fa fa-sitemap"></i> Família
						@include('components.entity_permission_icon', ['permissions' => $permissions, 'entity' => $family, 'class' => 'pull-right mt-3 mr-1'])
					</a>
					<div class="tree__children open">
						@foreach($family->members as $member)
							<a @click="openTab('member', '{{$member->id}}')" href="#member/{{$member->id}}" :class="{active: isOpen('member', '{{$member->id}}')}" class="tree__leaf @if($member->isArchived()) tree__deleted @endif">
								<i class="fa fa-male"></i> {{$member->name}}
								@if($member->id === $family->person_in_charge_id) <i v-b-tooltip.hover title="Responsável" class="fa fa-star"></i> @endif
								@include('components.entity_permission_icon', ['permissions' => $permissions, 'entity' => $member, 'class' => 'pull-right mt-3 mr-1'])
							</a>
						@endforeach
					</div>

					@if($permissions->canEdit($family))
						<div class="tree__options">
							<a @click="addMemberToFamily()" class="btn btn-success d-block"><i class="fa fa-plus"></i> Adicionar membro</a>
						</div>
					@endif
				</div>

			</div>

			<div class="sgps__panel">

				<div v-if="isOpen('overview')">
					@include('families.panel_overview', ['family' => $family])
				</div>

				<div v-if="isOpen('discussion')">
					@include('families.panel_discussion', ['family' => $family])
				</div>

				<div v-if="isOpen('activity_log')">
					@include('families.panel_activity_log', ['family' => $family])
				</div>

				<div v-if="isOpen('assignments')">
					@include('families.panel_assignments', ['family' => $family])
				</div>

				<div v-if="isOpen('flags')">
					@include('families.panel_flags', ['family' => $family])
				</div>

				<div v-if="isOpen('residence')">
					@include('families.panel_residence', ['residence' => $family->residence, 'family' => $family])
				</div>

				<div v-if="isOpen('family')">
					@include('families.panel_family', ['family' => $family])
				</div>

				@foreach($family->members as $member)
					<div v-if="isOpen('member', '{{$member->id}}')">
						@include('families.panel_member', ['member' => $member, 'family' => $family])
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection