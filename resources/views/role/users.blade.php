@extends('layouts.master')

@section('content')

  <h1>'{{ $role->name }}' Users</h1>
  <hr/>

  {!! Form::model($role, [
    'route' => ['role.users.update', $role->id],
    'class' => 'form-horizontal'])
  !!}

  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title">
            Current Users
            <small>({{$users->count()}})</small>
          </h2>
        </div>

        <div class="panel-body">
          @forelse($users->chunk(6) as $c)
            @foreach ($c as $u)
            <div class="col-sm-4 col-xs-6">
            <label class="checkbox-inline" title="{{ $u->slug }}">
              <input type="checkbox" name="users[]" value="{{$u->id}}" checked=""> {{ $u->name }}
            </label>
            </div>
            @endforeach
          @empty
            <span class="text-warning"><i class="fa fa-warning text-warning"></i> This role does not have any defined users.</span>
          @endforelse
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title">
            Available Users
            <small>({{$available_users->count()}})</small>
          </h2>
        </div>

        <div class="panel-body">
          @forelse($available_users->chunk(6) as $chunk)
            @foreach ($chunk as $au)
            <div class="col-md-2 col-sm-3 col-xs-4">
            <label class="checkbox-inline" title="{{ $au->slug }}">
              <input type="checkbox" name="users[]" value="{{$au->id}}"> {{ $au->name }}
            </label>
            </div>
            @endforeach
          @empty
            <span class="text-danger"><i class="fa fa-warning text-danger"></i> There aren't any available users.</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-3 col-sm-offset-3">
      <a href="{{ route('role.show', $role->id) }}" class="btn btn-default form-control">
        <i class="fa fa-arrow-left fa-fw"></i>
        <span class="hidden-xs">Back</span>
      </a>
    </div>
    <div class="col-sm-3">
      <button type="submit" class="btn btn-primary form-control">
        <i class="fa fa-check fa-fw"></i>
        <span class="hidden-xs">Update</span>
      </button>
    </div>
  </div>

  {!! Form::close() !!}

@endsection
