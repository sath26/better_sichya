 
	@extends('layouts.front')
@section('heading')
<a class="btn btn-primary pull-right"  href="{{route('note.create')}}">Upload Note</a> <br>

@endsection
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Uploaded Files</div>

		
	<ul>
{{$notes}}
		@foreach ($notes as $note)
			<li><img src="{{ asset($note->file_name)}}"></li>
		
		@endforeach
	</ul>
</div>

@endsection
	