@extends('layouts.front')

@section('content')
<h3>Upload files</h3>

{!! Form::open(array('route'=>'note.store','method'=>'POST', 'files'=>true,'class'=>'form-horizontal	')) !!}
<div class="form-group">
	{{ Form::label('title', 'Title:',array('class'=>'control-label') )}}
	{{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

</div>
<div class="form-group">
	{{ Form::label('description', 'Description:',array('class'=>'control-label')) }}
	{{ Form::text('description', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

</div>
<br>
<div class="form-group">
	{!! Form::file('images[]', array('class' => 'form-control','multiple'=>true)) !!}
	<p class="errors">{!!$errors->first('images')!!}</p>
	@if(Session::has('error'))
	<p class="errors">{!! Session::get('error') !!}</p>
	@endif
</div>

<div class="form-group">
	{!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}
	{!! Form::close() !!}
</div>
@endsection