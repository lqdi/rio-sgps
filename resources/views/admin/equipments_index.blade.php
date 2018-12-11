@extends('admin.admin_layout')
@section('admin_title') Equipamentos @endsection
@section('admin_buttons')
	<a href="{{route('admin.equipments.create')}}" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Novo</a>
@endsection
@section('admin_content')
	<table class="table">
		<thead>
		<tr>
			<th>Código</th>
			<th>Tipo</th>
			<th>Nome</th>
			<th>Endereço</th>
			<th>Setores</th>
			<th>Opções</th>
		</tr>
		</thead>
		<tbody>
		@foreach($equipments as $equipment)
			@php /* @var $equipment \SGPS\Entity\Equipment */ @endphp
			<tr>
				<td><a href="{{route('admin.equipments.show', [$equipment->id])}}" class="btn btn-sm btn-block btn-outline-danger"><code>{{$equipment->code}}</code></a></td>
				<td>{{$equipment->type}}</td>
				<td>{{$equipment->name}}</td>
				<td>{{$equipment->address}}</td>
				<td>
					@foreach($equipment->sectors as $sector)
						<span class="badge badge-secondary">{{$sector->id}}</span>
					@endforeach
				</td>
				<td>
					<a href="{{route('admin.equipments.show', [$equipment->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i> Editar</a>
					<form onsubmit="return confirm('Tem certeza que deseja excluir?')" class="d-inline-block" method="POST" action="{{route('admin.equipments.destroy', [$equipment->id])}}">
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
			{!! $equipments->links() !!}
		</div>
	</div>
@endsection