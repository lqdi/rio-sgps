@extends('admin.admin_layout')
@section('admin_title')  @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<div class="row">
		<div class="col-md-6">
			<a href="{{route('admin.users.index')}}" class="card">
				<div class="card-body text-center">
					<i class="fa fa-user" style="font-size: 48px"></i>
				</div>
				<div class="card-footer text-center">Operadores</div>
			</a>
			<br />
		</div>

		<div class="col-md-6">
			<a href="{{route('admin.groups.index')}}" class="card">
				<div class="card-body text-center">
					<i class="fa fa-users" style="font-size: 48px"></i>
				</div>
				<div class="card-footer text-center">Grupos</div>
			</a>
			<br />
		</div>

		<div class="col-md-6">
			<a href="{{route('admin.flags.index')}}" class="card">
				<div class="card-body text-center">
					<i class="fa fa-tags" style="font-size: 48px"></i>
				</div>
				<div class="card-footer text-center">Etiquetas</div>
			</a>
			<br />
		</div>

		<div class="col-md-6">
			<a href="{{route('admin.settings.index')}}" class="card">
				<div class="card-body text-center">
					<i class="fa fa-sliders-h" style="font-size: 48px"></i>
				</div>
				<div class="card-footer text-center">Configurações</div>
			</a>
			<br />
		</div>

	</div>
@endsection