@extends('layouts.master')

@section('content')

  <h1>'{{ $permission->name }}' Roles</h1>
  <hr/>

  {!! Form::model($permission, [
    'route' => ['permission.roles.update', $permission->id],
    'class' => 'form-horizontal'
  ]) !!}

  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title">
            Current Roles
            <small>({{$roles->count()}})</small>
          </h2>
        </div>

        <div class="panel-body">
          @forelse($roles->chunk(6) as $c)
            @foreach ($c as $p)
            <div class="col-sm-4 col-xs-6">
            <label class="checkbox-inline" title="{{ $p->slug }}">
              <input type="checkbox" name="roles[]" value="{{$p->id}}" checked=""> {{ $p->name }}
              @if ($p->special == 'all-access')
                <i class="fa fa-star text-success"></i>
              @elseif ($p->special == 'no-access')
                <i class="fa fa-ban text-danger"></i>
              @endif
            </label>
            </div>
            @endforeach
          @empty
            <span class="text-warning"><i class="fa fa-warning text-warning"></i> This permission does not have any defined roles.</span>
          @endforelse
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title">
            Available Roles <small>({{$available_roles->count()}})</small>
          </h2>
        </div>

        <div class="panel-body">
          @forelse($available_roles->chunk(6) as $chunk)
            @foreach ($chunk as $perm)
            <div class="col-sm-4 col-xs-6">
            <label class="checkbox-inline" title="{{ $perm->slug }}">
              <input type="checkbox" name="roles[]" value="{{$perm->id}}"> {{ $perm->name }}
              @if ($perm->special == 'all-access')
                <i class="fa fa-star text-success"></i>
              @elseif ($perm->special == 'no-access')
                <i class="fa fa-ban text-danger"></i>
              @endif
            </label>
            </div>
            @endforeach
          @empty
            <span class="text-danger"><i class="fa fa-warning text-danger"></i> There aren't any available roles.</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>


  <div class="form-group">
    <div class="col-sm-3 col-sm-offset-3">
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
{!! Form::close() !!}

@endsection
