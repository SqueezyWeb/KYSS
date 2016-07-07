@extends('layouts.master')

@section('content')

  <h1>Users
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm pull-right">
      <i class="fa fa-plus fa-fw"></i>
      <span class="hidden-xs">Add new</span>
    </a>
  </h1>

  <div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
      @include('partials.search', [
        'search_route' => 'user.index',
        'items' => $users
      ])
    </div>
  </div>

  <p>
		Found {{ $users->total() }} {{ str_plural('record', $users->count()) }}.
  </p>

  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th>Name</th><th>Email</th><th>Actions</th>
      </tr>
    </thead>

    <tbody>
      @forelse($users as $user)
       <tr>

      <td>
        <a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
      </td>

      <td>{{ $user->email }}</td>

      <td>
      @if (Shinobi::canAtLeast([
        config('acl.user.show', false),
        config('acl.user.edit', false)
      ]))
        <a href="{{ route('user.show', $user->id) }}" class="btn btn-default btn-xs">
          <i class="fa fa-user fa-fw"></i>
          <span class="hidden-xs hidden-sm">View</span>
        </a>
      @endif

      @if ( Shinobi::can( config('acl.user.edit', false)) )
        <a href="{{ route('user.edit', $user->id) }}">
          <button type="button" class="btn btn-default btn-xs">
          <i class="fa fa-pencil fa-fw"></i>
          <span class="hidden-xs hidden-sm">Edit</span>
          </button>
        </a>
      @endif

      @if ( Shinobi::can( config('acl.user.roles', false)) )
        <a href="{{ route('user.roles.edit', $user->id) }}">
          <button type="button" class="btn btn-default btn-xs">
            <i class="fa fa-users fa-fw"></i>
            <span class="hidden-xs hidden-sm">Roles</span>
          </button>
        </a>
      @endif

      @if ( Shinobi::can( config('acl.user.destroy', false)) )
        {!! Form::open(['method'=>'delete','route'=> ['user.destroy',$user->id], 'style' => 'display:inline']) !!}
          <button type="submit" class="btn btn-danger btn-xs">
          <i class="fa fa-trash-o fa-lg"></i>
          <span class="hidden-xs hidden-sm">Delete</span>
          </button>
        {!! Form::close() !!}
      @endif
      </td>
       </tr>
      @empty
      <tr><td>There are no users</td></tr>
      @endforelse

      <!-- pagination -->
      <tfoot>
      <tr>
       <td colspan="3" class="text-center small">
        {!! $users->render() !!}
       </td>
      </tr>
      </tfoot>
    </tbody>
  </table>

@endsection
