@extends('admin.admin_layout')
@section('admin_title') Etiquetas &raquo; {{!$flag->id ? 'Novo' : "Editar: {$flag->name}"}} @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<form method="POST" action="{{route('admin.flags.save', $flag->id ? [$flag->id] : null)}}">
		@csrf

		<div class="card">
			<div class="card-header">Dados da etiqueta</div>
			<div class="card-body row">
				<div class="col-md-6 form-group">
					<label for="fld-name">Nome</label>
					<input required id="fld-name" name="name" class="form-control" type="text" value="{{$flag->name}}" />
				</div>

				<div class="col-md-6 form-group">
					<label for="fld-code">Código</label>
					<input required id="fld-code" name="code" class="form-control" type="text" value="{{$flag->code}}" />
				</div>

				<div class="col-md-8 form-group">
					<label for="fld-entity_type">Tipo de entidade</label>
					<select required id="fld-entity_type" name="entity_type" class="form-control" value="{{$flag->entity_type}}">
						@foreach(config('entities.type') as $typeID => $type)
							<option @if($typeID === $flag->entity_type) selected @endif value="{{$typeID}}">{{$type['name']}}</option>
						@endforeach
					</select>
					<small>Nota: alterar o tipo de entidade não irá desvincular a etiqueta das entidades existentes.</small>
				</div>

				<div class="col-md-4 form-group">
					<label for="fld-default_deadline">Prazo padrão (em dias)</label>
					<input required id="fld-default_deadline" name="default_deadline" class="form-control" type="number" min="0" max="99999" value="{{$flag->default_deadline}}" />
				</div>

				<div class="col-md-12 form-group">
					<label for="fld-entity_type">Classe de comportamento</label>
					<select required id="fld-behavior" name="behavior" class="form-control">
						@foreach(\SGPS\Behavior\FlagBehavior::getAvailableClasses() as $behaviorClass)
							<option @if($behaviorClass === $flag->behavior) selected @endif value="{{$behaviorClass}}">{{$behaviorClass}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-md-12 form-group">
					<label for="fld-conditions">Conditionais do campo</label>
					<textarea class="form-control text-monospace" name="conditions">{{json_encode($flag->conditions)}}</textarea>
				</div>

				<div class="col-md-12 form-group">
					<label for="fld-triggers">Gatilhos</label>
					<textarea class="form-control text-monospace" name="triggers">{{json_encode($flag->triggers)}}</textarea>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
			</div>
		</div>

	</form>
@endsection