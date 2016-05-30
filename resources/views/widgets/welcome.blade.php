@extends('widgets.widget')

@section('widget-content')
  {{ $widget['content'] or 'You are logged in!' }}
{{-- See https://github.com/laravel/framework/issues/1058#issuecomment-17194530 --}}
@overwrite
