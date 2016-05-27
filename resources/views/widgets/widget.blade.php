<div class="panel panel-default">
  @if (isset($widget['title']))
    <div class="panel-heading">{{ $widget['title'] }}</div>
  @endif

  <div class="panel-body">
    @yield('widget-content')
  </div>
</div>
