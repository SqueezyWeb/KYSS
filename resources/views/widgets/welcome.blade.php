@extends('widgets.widget')

@section('widget-content')
  {{-- {{ $widget['content'] or 'You are logged in!' }} --}}
  <table class="table table-hover">
    <thead>
        <tr>
          <th>Name</th>
          <th>Route</th>
          <th>Colour</th>
        </tr>
    </thead>
    <tbody>
      @foreach (config('watchtower.dashboard') as $row)
        <tr>
          <td>{{ array_get($row, 'name') }}</td>
          <td>{{ array_get($row, 'route') }}</td>
          <td>{{ array_get($row, 'colour') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
{{-- See https://github.com/laravel/framework/issues/1058#issuecomment-17194530 --}}
@overwrite
