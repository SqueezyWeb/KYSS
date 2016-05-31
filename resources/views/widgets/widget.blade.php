@extends(isset($layout) && !empty($layout) ? $layout : 'layouts.dashboard.two-columns')

@section('widget')
  <div class="panel panel-default">
    @if (isset($widget['title']) && !empty($widget['title']))
      <div class="panel-heading">{{ $widget['title'] }}</div>
    @endif

    <div class="panel-body">
      @yield('widget-content')
    </div>

    @if (isset($widget['footer']) && !empty($widget['footer']))
      <div class="panel-footer">{{ $widget['footer'] }}</div>
    @endif
  </div>
{{-- See https://github.com/laravel/framework/issues/1058#issuecomment-17194530 --}}
@overwrite
