@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-xs-12">
      @widgetGroup('dashboard.main')
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      @widgetGroup('dashboard.left')
    </div>
    <div class="col-sm-6">
      @widgetGroup('dashboard.right')
    </div>
  </div>
@endsection
