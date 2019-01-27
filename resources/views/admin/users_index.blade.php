@extends('admin.admin_layout')
@section('admin_title') Operadores @endsection
@section('admin_buttons')
	<a href="{{route('admin.users.create')}}" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Novo</a>
@endsection
@section('admin_content')
	<table class="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Nível</th>
			<th>E-mail</th>
			<th>CPF</th>
			<th>Matrícula</th>
			<th>Opções</th>
		</tr>
		</thead>
		<tbody>
		@foreach($users as $user)
			@php /* @var $user \SGPS\Entity\User */ @endphp
			<tr>
				<td><a href="{{route('admin.users.show', [$user->id])}}" class="btn btn-sm btn-block btn-outline-danger"><code>{{$user->id}}</code> <span class="badge badge-light">{{strtoupper($user->source)}}</span></a></td>
				<td>{{$user->name}}</td>
				<td>{{trans('user.level.' . $user->level)}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->cpf}}</td>
				<td>{{$user->registration_number}}</td>
				<td>
					<a href="{{route('admin.users.show', [$user->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i> Editar</a>
					<form onsubmit="return confirm('Tem certeza que deseja excluir?')" class="d-inline-block" method="POST" action="{{route('admin.users.destroy', [$user->id])}}">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Excluir</button>
					</form>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<div class="align-items-center">
		<div class="align-self-center">
			{!! $users->links() !!}
		</div>
	</div>
@endsection