@extends('layouts.master')

@section('content')

	<h1>Role "{{ $role->name }}"</h1>

	<hr>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Name:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ $role->name or '' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Slug:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ $role->slug or '' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Description:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ $role->description or '' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<p><b>Special Access:</b></p>
		</div>
		<div class="col-sm-6">
			<p>{{ !empty($role->special) ? ucwords(str_replace('-', ' ', $role->special)) : 'No special access' }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-3">
			<a href="{{ route('role.index') }}" class="btn btn-default btn-block">
				<i class="fa fa-arrow-left fa-fw"></i>
				<span class="hidden-xs">Back</span>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="{{ route('role.permissions.edit', $role->id) }}" class="btn btn-primary btn-block">
				<i class="fa fa-key fa-fw"></i>
				<span class="hidden-xs">Permissions</span>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="{{ route('role.users.edit', $role->id) }}" class="btn btn-primary btn-block">
				<i class="fa fa-user fa-fw"></i>
				<span class="hidden-xs">Users</span>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary btn-block">
				<i class="fa fa-pencil fa-fw"></i>
				<span class="hidden-xs">Edit</span>
			</a>
		</div>
	</div>

@endsection
