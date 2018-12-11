@extends('admin.admin_layout')
@section('admin_title') Secretarias @endsection
@section('admin_buttons')
	<a href="{{route('admin.groups.create')}}" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Novo</a>
@endsection
@section('admin_content')
	<table class="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Opções</th>
		</tr>
		</thead>
		<tbody>
		@foreach($groups as $group)
			@php /* @var $group \SGPS\Entity\User */ @endphp
			<tr>
				<td><a href="{{route('admin.groups.show', [$group->id])}}" class="btn btn-sm btn-block btn-outline-danger"><code>{{$group->id}}</code></a></td>
				<td>{{$group->name}}</td>
				<td>
					<a href="{{route('admin.groups.show', [$group->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i> Editar</a>
					<form onsubmit="return confirm('Tem certeza que deseja excluir?')" class="d-inline-block" method="POST" action="{{route('admin.groups.destroy', [$group->id])}}">
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
			{!! $groups->links() !!}
		</div>
	</div>
@endsection