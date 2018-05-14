@extends('layouts.app')
<link href="{{ asset('css/square_images.css') }}" rel="stylesheet">
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
	    <a href="{{route('meals')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
	    <h2>Edit meal {{$data->name}}</h2>
	    <h4>Sold items: {{$data->sold_amount}}</h4>
	    <form action="{{action('MealsController@updateMeal')}}" method="post" enctype="multipart/form-data">
	    @csrf
	    <input name="id" type="hidden" value="{{$data->id}}">
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="name">Name:</label>
	      <input type="text" class="form-control" name="name" value="{{$data->name}}">
	     </div>
	    </div>
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="description">Description:</label>
	      <textarea class="form-control" name="description">{{$data->description}}</textarea>
	     </div>
	    </div>
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="price">Price:</label>
	      <div class="input-group">
	        <span class="input-group-addon">$</span>
	        <input type="text" class="form-control" name="price" value="{{$data->price}}">
	      </div>
	     </div>
	    </div>
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label>Current image:</label>
	      <img src="{{ url('/') }}/images/{{$data->image}}" width="400" height="400">
	      <br>
	      <label for="image">Upload new image:</label>
	      <input type="file" name="image" accept=".png, .jpg, .jpeg" />
	     </div>
	    </div>
	    <div class="row">
	     <div class="col-md-4"></div>
	     <div class="form-group col-md-4">
	      <label for="active">Available:</label>
	      <input type="radio" class="radio-inline" id="yes" name="available" value="yes"><label for="yes">Yes</label>
		  <input type="radio" class="radio-inline" id="no" name="available" value="no"><label for="no">No</label>
	     </div>
	    </div>
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4" style="margin-top:10px">
	      <button type="submit" class="btn btn-success" style="margin-left:38px">Update meal</button>
	     </div>
	    </div>
	   </form>
	@endif
@endsection