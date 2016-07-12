<div class="panel panel-{{ array_get($widget, 'style', config('widgets.style')) }}">
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
