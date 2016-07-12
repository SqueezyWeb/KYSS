@extends('widgets.widget')

@section('widget-content')
  {{-- {{ $widget['content'] or 'You are logged in!' }} --}}
  @if (array_has($widget, 'content'))
    {{ array_get($widget, 'content') }}
  @else
    <p>Hi {{ Auth::user()->name }}!</p>
    <p>Welcome to <b>KYSS</b>. I'm here to <em>Keep Your Stuff Simple</em>!</p>
  @endif
{{-- See https://github.com/laravel/framework/issues/1058#issuecomment-17194530 --}}
@overwrite
