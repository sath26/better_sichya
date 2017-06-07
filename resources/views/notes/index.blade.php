@extends('layouts.front')

@section('content')
	<h2>Upload files</h2>
	<ul>
		@foreach ($files as $file)
			<li>{{ asset('storage/'.$file)}}</li>
		@endforeach
	</ul>

	
@endsection