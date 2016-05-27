@extends('widgets.widget')

@section('widget-content')
  {{ $widget['content'] or 'You are logged in!' }}
@endsection
