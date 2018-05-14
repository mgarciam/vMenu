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
	    <a href="{{route('categories')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
	    <h2>Edit category {{$data->name}}</h2>
	    <form action="{{action('CategoriesController@updateCategory')}}" method="post" enctype="multipart/form-data">
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
	      <label for="active">Active:</label>
	      <input type="radio" class="radio-inline" id="yes" name="active" value="yes"><label for="yes">Yes</label>
		  <input type="radio" class="radio-inline" id="no" name="active" value="no"><label for="no">No</label>
	     </div>
	    </div>
	    <div class="row">
	    <div class="col-md-4"></div>
	     <div class="form-group col-md-4" style="margin-top:10px">
	      <button type="submit" class="btn btn-success" style="margin-left:38px">Update category</button>
	     </div>
	    </div>
	   </form>
	   @if (!empty($meals) && count($meals) > 0)
	   	<h2>Meals belonging to {{$data->name}}</h2>
	   	<br>
		   <input class="form-control" id="filter" type="text" placeholder="Search for meal..." style="width: 20%;">
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Name</th>
		      <th>Price</th>
		      <th>Available</th>
		      <th>Sold items</th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($meals as $meal)
		     <tr>
		      <td>{{$meal['id']}}</td>
		      <td>{{$meal['name']}}</td>
		      <td>$ {{$meal['price']}}</td>
		      <td>{{$meal['available']}}</td>
		      <td>{{$meal['sold_amount']}}</td>
		     </tr>
		    @endforeach
		    </tbody>
		   </table>
		  </div>
		  <script>
		    $(document).ready(function () {

		        (function ($) {

		            $('#filter').keyup(function () {

		                var rex = new RegExp($(this).val(), 'i');
		                $('.searchable tr').hide();
		                $('.searchable tr').filter(function () {
		                    return rex.test($(this).text());
		                }).show();

		            })

		        }(jQuery));
		    });
		  </script>
	   @endif
	@endif
@endsection