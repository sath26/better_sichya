@extends('layouts.front')
@section('heading')
<a class="btn btn-primary pull-right"  href="{{route('note.create')}}">Upload Note</a> <br>

@endsection
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Uploaded Files</div>

	<div class="table-responsive text-center">
		<table class="table table-bordered dt-responsive nowrap" id="abc">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			@foreach($notes as $note)
			<tr>
				<td>{{ $note->title }}</td>
				<td>
					{{ $note->description }}
				</td>	
				<td>
					<a href="{{ route('note.show', ['id' => $note->id ]) }}" class="btn btn-default">view</a>
					@if (Auth::id()==$note->user_id)
					<a href="{{ route('note.destroy', ['id' => $note->id ]) }}" class="btn btn-danger">delete</a>
					@endif
				</td>
			</tr>

			@endforeach
		</table>
	</div>
	<div class="text-center">
	{!! $notes->links() !!}
	</div>
</div>
@endsection