@extends('layouts.master')

@section('content')

  <h1>'{{ $user->name }}' Roles</h1>
  <hr/>

  {!! Form::model($user, [ 'route' => [ 'user.roles.update', $user->id ], 'class' => 'form-horizontal']) !!}

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
            @foreach ($c as $r)
            <div class="col-sm-4 col-xs-6">
            <label class="checkbox-inline" title="{{ $r->id }}">
              <input type="checkbox" name="roles[]" value="{{$r->id}}" checked=""> {{ $r->name }}
              @if ($r->special == 'all-access')
                <i class="fa fa-star text-success"></i>
              @elseif ($r->special == 'no-access')
                <i class="fa fa-ban text-danger"></i>
              @endif
            </label>
            </div>
            @endforeach
          @empty
            <span class="text-warning"><i class="fa fa-warning text-warning"></i> This user does not have any defined roles.</span>
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
            @foreach ($chunk as $ar)
            <div class="col-sm-4 col-xs-6">
            <label class="checkbox-inline" title="{{ $ar->id }}">
              <input type="checkbox" name="roles[]" value="{{$ar->id}}"> {{ $ar->name }}
              @if ($ar->special == 'all-access')
                <i class="fa fa-star text-success"></i>
              @elseif ($ar->special == 'no-access')
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
     <div class="col-xs-4 col-md-2 col-md-offset-3">
       <a href="{{ route('user.show', $user->id) }}" class="btn btn-default form-control">
         <i class="fa fa-times fa-fw"></i>
         <span class="hidden-xs">Cancel</span>
       </a>
     </div>
     <div class="col-xs-4 col-md-2">
       <button class="btn btn-info form-control" type="button" data-toggle="collapse" data-target="#collapsePermissions" aria-expanded="false" aria-controls="collapsePermissions">
         <i class="fa fa-key fa-fw"></i>
         <span class="hidden-xs">Permissions</span>
       </button>
     </div>
      <div class="col-xs-4 col-md-2">
        <button type="submit" class="btn btn-primary form-control">
          <i class="fa fa-check fa-fw"></i>
          <span class="hidden-xs">Update</span>
        </button>
      </div>
  </div>

  {!! Form::close() !!}

  <div class="row panel-collapse collapse" id="collapsePermissions">
    <div class="col-xs-12">
      <div class="panel panel-info">
        <div class="panel-heading clearfix">
          <h2 class="panel-title"><i class="fa fa-key"></i> {{$user->name}}'s Permissions (from current roles)</small></h2>
        </div>

        <div class="panel-body">
          <div class="col-xs-12">
            <ul class="list-unstyled">
              @forelse($roles as $prole)
              <li><strong>{{$prole->name}}</strong></li>
                <ul>
                  @if ($prole->special == 'all-access')
                    <li><i class="fa fa-fw fa-star text-success"></i> All Access</li>
                  @elseif ($prole->special == 'no-access')
                    <li><i class="fa fa-fw fa-ban text-danger"></i> No Access</li>
                  @else
                    @forelse($prole->permissions as $p)
                      <li>{{$p->name}} <em>({{ $p->slug }})</em></li>
                    @empty
                      <li>This role has no defined permissions</li>
                    @endforelse
                  @endif
                </ul>
              @empty
                <span class="text-danger"><i class="fa fa-warning text-danger"></i> There are no permissions defined for this user.</span>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
