@extends('layouts.master')

@section('content')

	<h1>Permission "{{ $permission->name }}"</h1>

	<hr>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Name:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ $permission->name or '' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Slug:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ $permission->slug or '' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Description:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ $permission->description or '' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-4 col-md-3 col-md-offset-1">
			<a href="{{ route('permission.index') }}" class="btn btn-default btn-block">
				<i class="fa fa-arrow-left fa-fw"></i>
				<span class="hidden-xs">Back</span>
			</a>
		</div>
		<div class="col-xs-4 col-md-3">
			<a href="{{ route('permission.roles.edit', $permission->id) }}" class="btn btn-primary btn-block">
				<i class="fa fa-users fa-fw"></i>
				<span class="hidden-xs">Roles</span>
			</a>
		</div>
		<div class="col-xs-4 col-md-3">
			<a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-primary btn-block">
				<i class="fa fa-pencil fa-fw"></i>
				<span class="hidden-xs">Edit</span>
			</a>
		</div>
	</div>

@endsection
