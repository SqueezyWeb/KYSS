@extends('layouts.master')

@section('content')

  <h1>Edit '{{ $user->name }}'</h1>
  <hr/>

  {!! Form::model($user, [
    'method' => 'PATCH',
    'route' => [
    'user.update',
    $user->id
    ],
    'class' => 'form-horizontal'
  ]) !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
      {!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>
      {!! $errors->first('name', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
      {!! Form::label('email', 'Email Address: ', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-6">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
      </div>
      {!! $errors->first('email', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
      {!! Form::label('password', 'Password: ', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-6">
        {!! Form::password('password', ['class' => 'form-control']) !!}
        {!! $errors->first('password', '<div class="text-danger">:message</div>') !!}
      </div>
    </div>

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
      {!! Form::label('password_confirmation', 'Confirm Password: ', ['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-6">
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        {!! $errors->first('password_confirmation', '<div class="text-danger">:message</div>') !!}
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-3 col-xs-6">
        <a href="{{ route('user.show', $user->id) }}" class="btn btn-default form-control">
          <i class="fa fa-times fa-fw"></i>
          <span class="hidden-xs">Cancel</span>
        </a>
      </div>
      <div class="col-sm-3 col-xs-6">
        <button type="submit" class="btn btn-primary form-control">
          <i class="fa fa-check fa-fw"></i>
          <span class="hidden-xs">Update</span>
        </button>
      </div>
    </div>
  {!! Form::close() !!}

@endsection
