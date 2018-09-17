@extends('admin.admin_layout')
@section('admin_title') Operadores &raquo; {{!$user->id ? 'Novo' : "Editar: {$user->name}"}} @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<form method="POST" class="row" action="{{route('admin.users.save', $user->id ? [$user->id] : null)}}">

		@csrf

		<div class="col-md-12 form-group">
			<label for="fld-name">Nome</label>
			<input required id="fld-name" name="name" class="form-control" type="text" value="{{$user->name}}" />
		</div>

		<div class="col-md-6 form-group">
			<label for="fld-cpf">CPF</label>
			<input id="fld-cpf" name="cpf" class="form-control" type="tel" value="{{$user->cpf}}" />
		</div>

		<div class="col-md-6 form-group">
			<label for="fld-registration_number">Matrícula</label>
			<input id="fld-registration_number" name="registration_number" class="form-control" type="tel" value="{{$user->registration_number}}" />
		</div>

		<div class="col-md-6 form-group">
			<label for="fld-email">E-mail</label>
			<input required id="fld-email" name="email" class="form-control" type="email" value="{{$user->email}}" />
		</div>

		<div class="col-md-6 form-group">
			<label for="fld-password">Senha</label>
			<input @if(!$user->id) required @endif id="fld-password" name="password" class="form-control" type="password" />
		</div>

		<div class="col-md-12 form-group">
			<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
		</div>

	</form>
@endsection