@extends('admin.admin_layout')
@section('admin_title') Equipamentos &raquo; {{!$equipment->id ? 'Novo' : "Editar: {$equipment->name}"}} @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<form method="POST" action="{{route('admin.equipments.save', $equipment->id ? [$equipment->id] : null)}}">
		@csrf

		<div class="card">
			<div class="card-header">Dados da pergunta</div>
			<div class="card-body row">
				<div class="col-md-6 form-equipment">
					<label for="fld-type">Tipo de equipamento</label>
					<select required id="fld-type" name="type" class="form-control">
						@foreach(\SGPS\Entity\Equipment::TYPES as $type)
							<option @if($type === $equipment->type) selected @endif value="{{$type}}">{{$type}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-md-12 form-equipment">
					<label for="fld-code">Código</label>
					<input required id="fld-code" name="code" class="form-control" type="text" value="{{$equipment->code}}" />
				</div>

				<div class="col-md-12 form-equipment">
					<label for="fld-name">Nome</label>
					<input required id="fld-name" name="name" class="form-control" type="text" value="{{$equipment->name}}" />
				</div>

				<div class="col-md-6 form-equipment">
					<label for="fld-address">Endereço</label>
					<input required id="fld-address" name="address" class="form-control" type="text" value="{{$equipment->address}}" />
				</div>
			</div>

			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
			</div>
		</div>

	</form>
@endsection