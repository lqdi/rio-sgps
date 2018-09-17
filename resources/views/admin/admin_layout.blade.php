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

			<div class="sgps__sidebar topbar--compact">

				<a class="sgps__sidebar-link @if(Route::is('admin.users.*')) active @endif" href="{{route('admin.users.index')}}"><i class="fa fa-user"></i> Operadores</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.groups.*')) active @endif" href="{{route('admin.groups.index')}}"><i class="fa fa-users"></i> Secretarias</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.flags.*')) active @endif" href="{{route('admin.flags.index')}}"><i class="fa fa-tags"></i> Etiquetas</a>
				<a class="sgps__sidebar-link @if(Route::is('admin.settings.*')) active @endif" href="{{route('admin.settings.index')}}"><i class="fa fa-sliders-h"></i> Configurações</a>

			</div>

			<div class="sgps">
				@yield('admin_content')
			</div>
		</div>
	</div>
@endsection