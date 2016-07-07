@extends('layouts.master')

@section('content')

  <h1>
    Permissions
  @if (Shinobi::can(config('acl.permission.create', false)))
    <a href="{{ route('permission.create') }}" class="btn btn-primary btn-sm pull-right">
      <i class="fa fa-plus fa-fw"></i>
      <span class="hidden-xs">Add new</span>
    </a>
  @endif
  </h1>

  <div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
      @include('partials.search', [
        'search_route' => 'permission.index',
        'items' => $permissions
      ])
    </div>
  </div>

  <p>
    Found {{ $permissions->total() }} {{ str_plural('permission', $permissions->total()) }}.
  </p>

  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th>Name</th><th>Actions</th>
      </tr>
    </thead>

    <tbody>
    @forelse($permissions as $permission)
      <tr>

        <td>
          <a href="{{ route('permission.show', $permission->id) }}">
            {{ $permission->name }}
          </a>
        </td>

        <td>
        @if ( Shinobi::can( config('acl.permission.edit', false)) )
          <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-default btn-xs">
            <i class="fa fa-pencil fa-fw"></i>
            <span class="hidden-xs hidden-sm">Update</span>
          </a>
        @endif

        @if ( Shinobi::can( config('acl.permission.roles', false)) )
          <a href="{{ route('permission.roles.edit', $permission->id) }}" class="btn btn-default btn-xs">
            <i class="fa fa-users fa-fw"></i>
            <span class="hidden-xs hidden-sm">Roles</span>
          </a>
        @endif

        @if (Shinobi::can(config('acl.permission.destroy', false)))
          {!! Form::open([
            'method' => 'delete',
            'route' => ['permission.destroy', $permission->id],
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
      <tr><td>There are no permissions</td></tr>
    @endforelse

      <!-- pagination -->
      <tfoot>
      <tr>
       <td colspan="3" class="text-center small">
        {!! $permissions->render() !!}
       </td>
      </tr>
      </tfoot>
    </tbody>
  </table>

@endsection
