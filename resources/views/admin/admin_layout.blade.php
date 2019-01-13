@extends('shared.layout')
@php /* @var $family \SGPS\Entity\Family */ @endphp
@section('main')
	<div>
		<div class="admin__container">
			<div class="sgps__topbar topbar--compact">

				<div class="row">
					<div class="col-md-9">
						<h1><i class="fa fa-cog"></i> Administração &raquo; @yield('admin_title')</h1>
					</div>
					<div class="col-md-3 text-right py-2">
						@yield('admin_buttons')
					</div>
				</div>

			</div>

			<div class="sgps__sidebar has-compact-topbar">

				<a class="sgps__sidebar-link @if(Route::is('admin.users.*')) active @endif" href="{{route('admin.users.index')}}"><i class="fa fa-user"></i> Operadores</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.groups.*')) active @endif" href="{{route('admin.groups.index')}}"><i class="fa fa-users"></i> Secretarias</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.flags.*')) active @endif" href="{{route('admin.flags.index')}}"><i class="fa fa-tags"></i> Etiquetas</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.questions.*')) active @endif" href="{{route('admin.questions.index')}}"><i class="fa fa-question-circle"></i> Perguntas</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.imports.*')) active @endif" href="{{route('admin.imports.dashboard')}}"><i class="fa fa-upload"></i> Importação</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.equipments.*')) active @endif" href="{{route('admin.equipments.index')}}"><i class="fa fa-map-marker"></i> Equipamentos</a>

			</div>

			<div class="sgps__panel has-compact-topbar">

				@include('components.messages')

				@yield('admin_content')
			</div>
		</div>
	</div>
@endsection