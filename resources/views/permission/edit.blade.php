@extends('layouts.master')

@section('content')

	<h1>Edit Permission</h1>

	<hr>

	{!! Form::model($permission, [
		'method' => 'PATCH',
		'route' => ['permission.update', $permission->id],
		'class' => 'form-horizontal'
	]) !!}

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			{!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-6">
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
			</div>
			{!! $errors->first('name', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
		</div>

		<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
			{!! Form::label('slug', 'Slug: ', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-6">
				{!! Form::text('slug', null, ['class' => 'form-control']) !!}
			</div>
			{!! $errors->first('slug', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
		</div>

		<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
			{!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-6">
				{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
			</div>
			{!! $errors->first('description', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
		</div>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-3">
				<a href="{{ route('permission.show', $permission->id) }}" class="btn btn-default form-control">
					<i class="fa fa-times fa-fw"></i>
					<span class="hidden-xs">Cancel</span>
				</a>
			</div>
			<div class="col-sm-3">
				<button type="submit" class="btn btn-primary form-control">
					<i class="fa fa-check fa-fw"></i>
					<span class="hidden-xs">Update</span>
				</button>
			</div>
		</div>

@endsection
