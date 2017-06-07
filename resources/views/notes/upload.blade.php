@extends('layouts.front')

@section('content')
	<h2>Upload files</h2>
		 {!! Form::open(array('route'=>'note.store','method'=>'POST', 'files'=>true)) !!}
    <div class="control-group">
      <div class="controls">
      {!! Form::file('images[]', array('multiple'=>true)) !!}
	<p class="errors">{!!$errors->first('images')!!}</p>
	@if(Session::has('error'))
	<p class="errors">{!! Session::get('error') !!}</p>
	@endif
     </div>
</div>
{!! Form::submit('Submit', array('class'=>'send-btn')) !!}
{!! Form::close() !!}
@endsection