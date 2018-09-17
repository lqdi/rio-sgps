@extends('admin.admin_layout')
@section('admin_title') Secretarias &raquo; {{!$group->id ? 'Novo' : "Editar: {$group->name}"}} @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<form method="POST" action="{{route('admin.groups.save', $group->id ? [$group->id] : null)}}">
		@csrf

		<div class="card">
			<div class="card-header">Dados do grupo</div>
			<div class="card-body row">
				<div class="col-md-12 form-group">
					<label for="fld-name">Nome</label>
					<input required id="fld-name" name="name" class="form-control" type="text" value="{{$group->name}}" />
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
			</div>
		</div>

	</form>
@endsection