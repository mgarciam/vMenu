@extends('layouts.app')

@section('content')
	@if(Auth::check())
		@if (\Session::has('success'))
	      <div class="alert alert-success">
	       	<p>{{\Session::get('success')}}</p>
	      </div><br />
    	@endif
	    @if (count( $errors ) > 0) 
	      <div class="alert alert-danger">
	        @foreach ($errors->all() as $error)
	          {{ $error }}
	        <br>
	        @endforeach
	      </div>
	    @endif
	    <a href="{{route('admins')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
	    <h2>Edit role for {{$data->name}} {{$data->surname}}</h2>
	    <p>Email: {{$data->email}}</p>
	    <p>Current role: {{$data->role}}</p>
	    <br>
	    <br>
	    <form method="post" action="{{route('update-user')}}" enctype="multipart/form-data">
	    	@csrf
	    	<h4>Select new role:</h4>
		    <div class="row">
		    <div class="col-md-4"></div>
		     <div class="form-group col-md-4">
		     <input name="id" type="hidden" value="{{$data->id}}">
		      <label for="peso">Role:</label>
		      <input type="radio" class="radio-inline" id="role1" name="role" value="admin"><label for="role1">Admin</label>
		      <input type="radio" class="radio-inline" id="role2" name="role" value="cook"><label for="role2">Cook</label>
		      <input type="radio" class="radio-inline" id="role3" name="role" value="front"><label for="role3">Front-desk</label>
		     </div>
	    	</div>
	    	<button type="submit" class="btn btn-success">Update user</button>
	    </form>
	@endif
@endsection