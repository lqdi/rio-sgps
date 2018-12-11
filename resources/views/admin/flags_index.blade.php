@extends('admin.admin_layout')
@section('admin_title') Etiquetas @endsection
@section('admin_buttons')
	<a href="{{route('admin.flags.create')}}" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Nova</a>
@endsection
@section('admin_content')
	<table class="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Tipo</th>
			<th>Opções</th>
		</tr>
		</thead>
		<tbody>
		@foreach($flags as $flag)
			@php /* @var $flag \SGPS\Entity\User */ @endphp
			<tr>
				<td><a href="{{route('admin.flags.show', [$flag->id])}}" class="btn btn-sm btn-block btn-outline-danger"><code>{{$flag->shortcode}}</code></a></td>
				<td>{{$flag->name}}</td>
				<td>
					@if($flag->entity_type === 'family')
						<span class="badge badge-primary"><i class="fa fa-users"></i> Família</span>
					@elseif($flag->entity_type === 'residence')
						<span class="badge badge-success"><i class="fa fa-home"></i> Residência</span>
					@elseif($flag->entity_type === 'person')
						<span class="badge badge-info"><i class="fa fa-male"></i> Indivíduo</span>
					@endif
				</td>
				<td>
					<a href="{{route('admin.flags.show', [$flag->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i> Editar</a>
					<form onsubmit="return confirm('Tem certeza que deseja excluir?')" class="d-inline-block" method="POST" action="{{route('admin.flags.destroy', [$flag->id])}}">
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
			{!! $flags->links() !!}
		</div>
	</div>
@endsection