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
				<div class="col-md-12 form-flag">
					<label for="fld-name">Nome</label>
					<input required id="fld-name" name="name" class="form-control" type="text" value="{{$flag->name}}" />
				</div>
				<div class="col-md-12 form-flag">
					<label for="fld-entity_type">Tipo de entidade</label>
					<select required id="fld-entity_type" name="entity_type" class="form-control" value="{{$flag->entity_type}}">
						@foreach(config('entities.type') as $typeID => $type)
							<option @if($typeID === $flag->entity_type) selected @endif value="{{$typeID}}">{{$type['name']}}</option>
						@endforeach
					</select>
					<small>Nota: alterar o tipo de entidade não irá desvincular a etiqueta das entidades existentes.</small>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
			</div>
		</div>

	</form>
@endsection