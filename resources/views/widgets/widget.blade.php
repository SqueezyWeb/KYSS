@extends(isset($layout) && !empty($layout) ? $layout : 'layouts.dashboard.two-columns')

@section('widget')
  @can($widget['permissions']['view'])
    <div class="panel panel-default">
      @if (isset($widget['title']) && !empty($widget['title']))
        <div class="panel-heading">{{ $widget['title'] }}</div>
      @endif

      <div class="panel-body">
        @yield('widget-content')
      </div>
    </div>
  @endcan
{{-- See https://github.com/laravel/framework/issues/1058#issuecomment-17194530 --}}
@overwrite
