@extends('layouts.master')

@section('content')

  <h1>'{{ $role->name }}' Permissions</h1>
  <hr/>

  {!! Form::model($role, [
    'route' => ['role.permissions.update', $role->id],
    'class' => 'form-horizontal'])
  !!}

  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title">
            Current Permissions <small>({{$permissions->count()}})</small>
          </h2>
        </div>

        <div class="panel-body">
          @forelse($permissions->chunk(6) as $c)
            @foreach ($c as $p)
            <div class="col-sm-4 col-xs-6">
            <label class="checkbox-inline" title="{{ $p->slug }}">
              <input type="checkbox" name="permissions[]" value="{{$p->id}}" checked=""> {{ $p->name }}
            </label>
            </div>
            @endforeach
          @empty
            <span class="text-warning"><i class="fa fa-warning text-warning"></i> This role does not have any defined permissions.</span>
          @endforelse
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title">
            Available Permissions <small>({{$available_permissions->count()}})</small>
          </h2>
        </div>

        <div class="panel-body">
          @forelse($available_permissions->chunk(6) as $chunk)
            @foreach ($chunk as $perm)
            <div class="col-sm-4 col-xs-6">
              <label class="checkbox-inline" title="{{ $perm->slug }}">
                <input type="checkbox" name="permissions[]" value="{{$perm->id}}"> {{ $perm->name }}
              </label>
            </div>
            @endforeach
          @empty
            <span class="text-danger"><i class="fa fa-warning text-danger"></i> There aren't any available permissions.</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-3 col-sm-offset-3">
      <a href="{{ route('role.show', $role->id) }}" class="btn btn-default form-control">
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

  {!! Form::close() !!}

@endsection
