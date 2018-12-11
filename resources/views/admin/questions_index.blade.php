@extends('admin.admin_layout')
@section('admin_title') Perguntas @endsection
@section('admin_buttons')
	<a href="{{route('admin.questions.create')}}" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Nova</a>
@endsection
@section('admin_content')
	<table class="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Pergunta</th>
			<th>Entidade</th>
			<th>Categorias</th>
			<th>Opções</th>
		</tr>
		</thead>
		<tbody>
		@foreach($questions as $question)
			@php /* @var $question \SGPS\Entity\Question */ @endphp
			<tr>
				<td><a href="{{route('admin.questions.show', [$question->id])}}" class="btn btn-sm btn-block btn-outline-danger"><code>{{$question->code}}</code></a></td>
				<td>{{$question->title}}</td>
				<td>{{trans('entity.type.' . $question->entity_type)}}</td>
				<td>
					@foreach($question->categories as $category)
						<span class="badge badge-secondary">{{$category->name}}</span>
					@endforeach
				</td>
				<td>
					<a href="{{route('admin.questions.show', [$question->id])}}" class="btn btn-sm btn-outline-dark"><i class="fa fa-edit"></i> Editar</a>
					<form onsubmit="return confirm('Tem certeza que deseja excluir?')" class="d-inline-block" method="POST" action="{{route('admin.questions.destroy', [$question->id])}}">
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
			{!! $questions->links() !!}
		</div>
	</div>
@endsection