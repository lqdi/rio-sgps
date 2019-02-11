@extends('admin.admin_layout')
@section('admin_title') Operadores &raquo; {{!$user->id ? 'Novo' : "Editar: {$user->getFirstName()}"}} @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<div is="operator-edit" inline-template :initially-selected-groups="{{json_encode($user->groups->pluck('code')->toArray())}}">
		<div>
			<form method="POST" action="{{route('admin.users.save', $user->id ? [$user->id] : null)}}">
					@csrf

					<div class="card">
						<div class="card-header">Dados do usuário</div>
						<div class="card-body row">
							<div class="col-md-6 form-group">
								<label for="fld-name">Nível</label>
								<select @if($user->isExternal()) disabled @endif id="fld-level" name="level" class="form-control" type="text">
									@foreach(\SGPS\Constants\UserLevel::LEVEL_HIERARCHY as $level => $hierarchy)
										<option @if($user->level === $level) selected @endif value="{{$level}}">{{trans('user.level.' . $level)}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-6 form-group">
								<label for="fld-name">Origem</label>
								<div>
									<span class="badge badge-light">{{trans('user.source.' . ($user->source ?? 'sgps'))}}</span>
								</div>
							</div>

							<div class="col-md-12 form-group">
								<label for="fld-name">Nome</label>
								<input @if($user->isExternal()) disabled @else required @endif id="fld-name" name="name" class="form-control" type="text" value="{{$user->name}}" />
							</div>

							<div class="col-md-6 form-group">
								<label for="fld-cpf">CPF</label>
								<input @if($user->isExternal()) disabled @endif id="fld-cpf" name="cpf" class="form-control" type="tel" value="{{$user->cpf}}" />
							</div>

							<div class="col-md-6 form-group">
								<label for="fld-registration_number">Matrícula</label>
								<input @if($user->isExternal()) disabled @endif id="fld-registration_number" name="registration_number" class="form-control" type="tel" value="{{$user->registration_number}}" />
							</div>

							<div class="col-md-6 form-group">
								<label for="fld-email">E-mail</label>
								<input @if($user->isExternal()) disabled @else required @endif id="fld-email" name="email" class="form-control" type="email" value="{{$user->email}}" />
							</div>

							<div class="col-md-6 form-group">
								<label for="fld-password">Senha</label>
								<input @if($user->isExternal()) disabled @elseif(!$user->id) required @endif id="fld-password" name="password" class="form-control" type="password" />
							</div>
						</div>
					</div>

					<br />

					<div class="card">
						<div class="card-header">Grupos e Secretarias</div>
						<div class="card-body row">

							@foreach($groups->split(3) as $chunk)
								<table class="table col-md-4">
									@foreach($chunk as $group)
										<tr>
											<td width="10%"><input id="chk-group-{{$group->id}}" @change="onGroupsUpdate('{{$group->code}}', $event)" type="checkbox" name="groups[]" value="{{$group->id}}" @if(in_array($group->id, $currentGroups)) checked @endif /></td>
											<td width="90%"><label for="chk-group-{{$group->id}}">{{$group->code}}</label></td>
										</tr>
									@endforeach
								</table>
							@endforeach
						</div>
					</div>

					<br />

					<div class="card">
						<div class="card-header">Equipamentos</div>
						<div class="card-body row">
							@foreach($equipments as $equipment)
								<table class="table col-md-6" v-if="hasSelectedGroup('{{$equipment->group_code}}')">
									<tr>
										<td width="10%"><input id="chk-equipment-{{$equipment->id}}" type="checkbox" name="equipments[]" value="{{$equipment->id}}" @if(in_array($equipment->id, $currentEquipments)) checked @endif /></td>
										<td width="90%"><label for="chk-equipment-{{$equipment->id}}">{{$equipment->name}}</label></td>
									</tr>
								</table>
							@endforeach
						</div>
					</div>

					<br />

					<div class="card">
						<div class="card-footer">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
						</div>
					</div>
			</form>
		</div>
	</div>
@endsection