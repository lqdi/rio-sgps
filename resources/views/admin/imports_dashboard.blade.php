@extends('admin.admin_layout')
@section('admin_title') Importação @endsection
@section('admin_buttons')

@endsection
@section('admin_content')
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<strong class="card-header">Últimas importações</strong>
				<div class="card-body">

					<table class="table">
						@foreach($jobs as $job) @php /* @var $job \SGPS\Entity\Survey\SurveyImportJob */ @endphp
							<tr>
								<td>{{$job->created_at->diffForHumans()}}</td>
								<td>{{trans('messages.' . $job->stage)}}</td>
								<td>
									<span class="badge badge-primary">&raquo; {{$job->num_families_read}}</span>
									<span class="badge badge-success">&check; {{$job->num_families_imported}}</span>
									<span class="badge badge-warning">&circlearrowleft; {{$job->num_families_skipped}}</span>
								</td>
								<td>
									<span class="badge badge-primary">&raquo; {{$job->num_persons_read}}</span>
									<span class="badge badge-success">&check; {{$job->num_persons_imported}}</span>
									<span class="badge badge-warning">&circlearrowleft; {{$job->num_persons_skipped}}</span>
								</td>
								<td>{{$job->exception_message}}</td>
							</tr>
						@endforeach
					</table>

				</div>
			</div>
		</div>
		<div class="col-md-6">
			<form class="card" method="POST" action="{{route('admin.imports.survey_csv')}}" enctype="multipart/form-data">
				@csrf

				<strong class="card-header">Importar CSV do Survey</strong>

				<div class="card-body">
					<div class="form-group">
						<label for="fld-families_csv">CSV das famílias</label>
						<input id="fld-families_csv" class="form-control" name="families_csv" type="file" />
					</div>

					<div class="form-group">
						<label for="fld-members_csv">CSV dos membros</label>
						<input id="fld-members_csv" class="form-control" name="members_csv" type="file" />
					</div>
				</div>

				<div class="card-footer">
					<div class="clearfix text-right">
						<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Importar</button>
					</div>
				</div>
			</form>

            <hr />

			<form class="card" method="POST" action="{{route('admin.imports.geography_csv')}}" enctype="multipart/form-data">
				@csrf

				<strong class="card-header">Importar Equipamentos e Setores</strong>

				<div class="card-body">

					<div class="form-group">
						<label for="fld-equipments_csv">CSV dos equipamentos</label>
						<input id="fld-equipments_csv" class="form-control" name="equipments_csv" type="file" />
					</div>

					<div class="form-group">
						<label for="fld-sectors_csv">CSV dos setores</label>
						<input id="fld-sectors_csv" class="form-control" name="sectors_csv" type="file" />
					</div>
				</div>

				<div class="card-footer">
					<div class="clearfix text-right">
						<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Importar</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection
