@if(session()->has('success'))
	<div class="alert alert-success">
		{{trans('messages.' . session('success'))}}
	</div>
@endif
@if(session()->has('warning'))
	<div class="alert alert-warning">
		{{trans('messages.' . session('warning'))}}
	</div>
@endif
@if(session()->has('error'))
	<div class="alert alert-danger">
		{{trans('messages.' . session('error'))}}
	</div>
@endif