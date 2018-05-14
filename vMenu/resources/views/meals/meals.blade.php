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
	    <h2>Meals</h2>
	    <a href="{{route('add-meal')}}" class="btn btn-info" style="float: right;">Add meal</a>
	    @if (count($data) > 0)
		   <input class="form-control" id="filter" type="text" placeholder="Search for meal..." style="width: 20%;">
		   <br>
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Name</th>
		      <th>Category</th>
		      <th>Price</th>
		      <th>Available</th>
		      <th colspan="2"></th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($data as $meal)
		     <tr>
		      <td>{{$meal['id']}}</td>
		      <td>{{$meal['name']}}</td>
		      <td>{{$meal['category']}}</td>
		      <td>$ {{$meal['price']}}</td>
		      <td>{{$meal['available']}}</td>
		      <td><a href="{{action('MealsController@editMeal', ['id'=>$meal['id']])}}" class="btn btn-warning">See and edit meal</a></td>
		      <td>
		      	<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$meal->id}}">Delete</button>
		      </td>
		     </tr>
		    @endforeach
		    </tbody>
		   </table>
		   @foreach($data as $meal)
		   	<div class="modal fade" id="deleteModal{{$meal->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			      	<h4 class="modal-title" id="myModalLabel">Delete meal</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete the meal {{$meal->name}}? You can deactivate it instead.
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			      	<form action="{{route('delete-meal')}}" method="post">
				        @csrf
				        <input name="id" type="hidden" value="{{$meal['id']}}">
				        <button class="btn btn-danger" type="submit">Yes</button>
			       	</form>
			      </div>
			    </div>
			  </div>
			</div>
		   @endforeach
		@endif
		@if (count($data) == 0)
			<h3>There are no meals</h3>
		@endif
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
@endsection