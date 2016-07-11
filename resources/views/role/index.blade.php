@extends('layouts.master')

@section('content')

  <h1>
    Roles
  @if (Shinobi::can(config('acl.role.create', false)))
    <a href="{{ route('role.create') }}" class="btn btn-primary btn-sm pull-right">
      <i class="fa fa-plus fa-fw"></i>
      <span class="hidden-xs">Add new</span>
    </a>
  @endif
  </h1>

  <div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
      @include('partials.search', [
        'search_route' => 'role.index',
        'items' => $roles
      ])
    </div>
  </div>

  <p>
    Found {{ $roles->total() }} {{ str_plural('role', $roles->count()) }}.
  </p>

    <table class="table table-hover table-striped table-responsive">
      <thead>
        <tr>
          <th>Name</th><th>Actions</th>
        </tr>
      </thead>

      <tbody>
      @forelse($roles as $role)
      <tr>
        <td>
          <a href="{{ route('role.show', $role->id) }}">{{ $role->name }}</a>
        @if ($role->special == 'all-access')
          <i class="fa fa-star text-success"></i>
        @elseif ($role->special == 'no-access')
          <i class="fa fa-ban text-danger"></i>
        @endif
        </td>

        <td>
        @if (Shinobi::can(config('acl.role.show', false)))
          <a href="{{ route('role.show', $role->id) }}" class="btn btn-default btn-xs">
            <i class="fa fa-eye fa-fw"></i>
            <span class="hidden-xs hidden-sm">View</span>
          </a>
        @endif
        
        @if (Shinobi::can(config('acl.role.edit', false)))
          <a href="{{ route('role.edit', $role->id) }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil fa-fw"></i>
            <span class="hidden-xs hidden-sm">Edit</span>
          </a>
        @endif

        @if (Shinobi::can(config('acl.role.permissions', false)))
        <a href="{{ route('role.permissions.edit', $role->id) }}" class="btn btn-default btn-xs">
          <i class="fa fa-key fa-fw"></i>
          <span class="hidden-xs hidden-sm">Permissions</span>
        </a>
        @endif

        @if (Shinobi::can(config('acl.role.users', false)))
          <a href="{{ route('role.users.edit', $role->id) }}" class="btn btn-default btn-xs">
            <i class="fa fa-user fa-fw"></i>
            <span class="hidden-xs hidden-sm">Users</span>
          </a>
        @endif

        @if (Shinobi::can(config('acl.role.destroy', false)))
          {!! Form::open([
            'method'=>'delete',
            'route'=> ['role.destroy', $role->id],
            'style' => 'display:inline'
          ]) !!}
            <button type="submit" class="btn btn-danger btn-xs">
              <i class="fa fa-trash-o fa-lg"></i>
              <span class="hidden-xs hidden-sm">Delete</span>
            </button>
          {!! Form::close() !!}
        @endif
        </td>
       </tr>
      @empty
        <tr><td>There are no roles</td></tr>
      @endforelse

        <!-- pagination -->
        <tfoot>
          <tr>
           <td colspan="3" class="text-center small">
            {!! $roles->render() !!}
           </td>
          </tr>
        </tfoot>
      </tbody>
    </table>
  </div>

@endsection
