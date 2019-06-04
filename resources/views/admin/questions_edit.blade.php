@extends('admin.admin_layout')
@section('admin_title') Perguntas &raquo; {{!$question->id ? 'Novo' : "Editar: {$question->name}"}} @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<form method="POST" action="{{route('admin.questions.save', $question->id ? [$question->id] : null)}}">
		@csrf

		<div class="card">
			<div class="card-header">Dados da pergunta</div>
			<div class="card-body row">
				<div class="col-md-12 form-question">
					<label for="fld-title">Título</label>
					<input required id="fld-title" name="title" class="form-control" type="text" value="{{$question->title}}" />
				</div>

				<div class="col-md-6 form-question">
					<label for="fld-code">Código</label>
					<input required id="fld-code" name="code" class="form-control" type="text" value="{{$question->code}}" />
				</div>

				<div class="col-md-6 form-question">
					<label for="fld-key">Chave</label>
					<input required id="fld-key" name="key" class="form-control" type="text" value="{{$question->key}}" />
				</div>

				<div class="col-md-6 form-question">
					<label for="fld-entity_type">Tipo de entidade</label>
					<select required id="fld-entity_type" name="entity_type" class="form-control">
						@foreach(config('entities.type') as $typeID => $type)
							<option @if($typeID === $question->entity_type) selected @endif value="{{$typeID}}">{{$type['name']}}</option>
						@endforeach
					</select>
					<small>Nota: alterar o tipo de entidade não irá desvincular a pergunta das respostas existentes.</small>
				</div>

				<div class="col-md-6">
					<label for="fld-field_type">Tipo de resposta</label>
					<select required id="fld-field_type" name="field_type" class="form-control">
						@foreach(\SGPS\Entity\Question::TYPES as $type)
							<option @if($type === $question->field_type) selected @endif value="{{$type}}">{{trans('fields.type.' . $type)}}</option>
						@endforeach
					</select>
					<small>Nota: alterar o tipo de resposta não irá alterar o valor das respostas existentes.</small>
				</div>

				<div class="col-md-12">
					<label for="fld-field_settings">Configurações do campo</label>
					<textarea id="fld-field_settings" class="form-control text-monospace" name="field_settings">{{json_encode($question->field_settings)}}</textarea>
				</div>

				<div class="col-md-12">
					<label for="fld-field_options">Opções do campo</label>
					<textarea id="fld-field_options" class="form-control text-monospace" name="field_options">{{json_encode($question->field_options)}}</textarea>
				</div>

				<div class="col-md-12">
					<label for="fld-conditions">Condições da pergunta</label>
					<textarea id="fld-conditions" class="form-control text-monospace" name="conditions">{{json_encode($question->conditions)}}</textarea>
				</div>

				<div class="col-md-12">
					<label for="fld-triggers">Gatilhos da pergunta</label>
					<textarea id="fld-triggers" class="form-control text-monospace" name="triggers">{{json_encode($question->triggers)}}</textarea>
				</div>

				@if($question->id)
					<div class="col-md-12">
						<label for="fld-field_type">Categorias da pergunta</label>

						<div class="row">
							@foreach($categories as $category)
								<div class="col-md-4">
									<label>
										<input type="checkbox" name="categories[]" value="{{$category->id}}" @if($question->categories->contains('id', $category->id)) checked @endif /> {{$category->name}}
									</label>
								</div>
							@endforeach

						</div>

					</div>
				@endif

			</div>

			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
			</div>
		</div>

	</form>
@endsection