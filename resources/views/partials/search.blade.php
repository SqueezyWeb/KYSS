{!! Form::open([
	'method' => 'get',
	'route' => [$search_route],
	'style' => 'display:inline'
]) !!}
	<div class="input-group">
		<input type="search" class="form-control" name="q" placeholder="Search for&hellip;" value="{{ session('q') }}">
		<span class="input-group-btn">
		@if (session()->has('q'))
			<a href="{{ route($search_route) }}" class="btn btn-default">
				<i class="fa fa-close fa-fw"></i>
				<span class="sr-only">Reset</span>
			</a>
		@endif
			<button class="btn btn-default" type="submit">
				<i class="fa fa-search fa-fw"></i>
				<span class="sr-only">Search</span>
			</button>
		</span>
	</div>

{!! Form::close() !!}
