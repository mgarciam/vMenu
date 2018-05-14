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
	    <a href="{{route('rooms')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
	    <h2>Edit room</h2>
	    <form action="{{action('RoomsController@updateRoom')}}" method="post" >
	    @csrf
	    <input name="id" type="hidden" value="{{$data->id}}">
	    <div class="row">
	     <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="number">Number:</label>
	      <input type="text" class="form-control" name="number" value="{{$data->number}}">
	     </div>
	    </div>
	    <div class="row">
	     <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="price">Price per night:</label>
	      <div class="input-group">
	        <span class="input-group-addon">$</span>
	        <input type="text" class="form-control" name="price" value="{{$data->price}}">
	      </div>
	     </div>
	    </div>
	    <div class="row">
	     <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="available">Available:</label>
	      <input type="radio" class="radio-inline" id="yes" name="available" value="yes"><label for="yes">Yes</label>
		  <input type="radio" class="radio-inline" id="no" name="available" value="no"><label for="no">No</label>
	     </div>
	    </div>
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4" style="margin-top:10px">
	      <button type="submit" class="btn btn-success" style="margin-left:38px">Update room</button>
	     </div>
	    </div>
	   </form>
	@endif
@endsection