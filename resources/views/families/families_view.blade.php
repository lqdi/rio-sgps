@extends('shared.layout')
@php /* @var $family \SGPS\Entity\Family */ @endphp
@section('main')
	<div is="family-view" inline-template>
		<div class="case__container">
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

				<a @click="openTab = 'overview'" :class="{active: openTab === 'overview'}" class="sgps__sidebar-link"><i class="fa fa-info-circle"></i> Visão Geral</a>
				<a @click="openTab = 'discussion'" :class="{active: openTab === 'discussion'}" class="sgps__sidebar-link"><i class="fa fa-comments"></i> Discussão</a>
				<a @click="openTab = 'tags'" :class="{active: openTab === 'tags'}" class="sgps__sidebar-link"><i class="fa fa-tags"></i> Etiquetas</a>

				<hr />

				<a @click="openTab = 'residence'" :class="{active: openTab === 'residence'}" class="sgps__sidebar-link"><i class="fa fa-home"></i> Domicílio</a>

				<div class="tree__container">
					<a @click="openTab = 'family'" :class="{active: openTab === 'family'}" class="tree__leaf"><i class="fa fa-sitemap"></i> Família</a>
					<div class="tree__children open">
						@foreach($family->members as $member)
							<a @click="openTab = 'member-{{$member->id}}'" :class="{active: openTab === 'member-{{$member->id}}'}" class="tree__leaf"><i class="fa fa-male"></i> {{$member->name}} @if($member->id === $family->person_in_charge_id)<i v-b-tooltip.hover title="Responsável" class="fa fa-star"></i>@endif</a>
						@endforeach
					</div>
				</div>

			</div>

			<div class="sgps__panel">

				<div v-if="openTab === 'overview'">
					@include('families.panel_overview', ['family' => $family])
				</div>

				<div v-if="openTab === 'discussion'">
					@include('families.panel_discussion', ['family' => $family])
				</div>

				<div v-if="openTab === 'tags'">
					@include('families.panel_flags', ['family' => $family])
				</div>

				<div v-if="openTab === 'residence'">
					@include('families.panel_residence', ['residence' => $family->residence, 'family' => $family])
				</div>

				<div v-if="openTab === 'family'">
					@include('families.panel_family', ['family' => $family])
				</div>

				@foreach($family->members as $member)
					<div v-if="openTab === 'member-{{$member->id}}'">
						@include('families.panel_member', ['member' => $member, 'family' => $family])
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection