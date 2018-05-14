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
	    <h2>Categories</h2>
	    <a href="{{route('add-category')}}" class="btn btn-info" style="float: right;">Add category</a>
	    @if (count($data) > 0)
		   <input class="form-control" id="filter" type="text" placeholder="Search for category..." style="width: 20%;">
		   <br>
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Name</th>
		      <th>Meals count</th>
		      <th>Active</th>
		      <th colspan="2"></th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($data as $category)
		     <tr>
		      <td>{{$category['id']}}</td>
		      <td>{{$category['name']}}</td>
		      <td>{{$category['foods_number']}}</td>
		      <td>{{$category['active']}}</td>
		      <td><a href="{{action('CategoriesController@editCategory', ['id'=>$category['id']])}}" class="btn btn-warning">Edit category</a></td>
		      <td>
		      	<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$category->id}}">Delete</button>
		      </td>
		     </tr>
		    @endforeach
		    </tbody>
		   </table>
		   @foreach($data as $category)
		   	<div class="modal fade" id="deleteModal{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			      	<h4 class="modal-title" id="myModalLabel">Delete category</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete the category {{$category->name}}? All meals belonging to this category will be deleted too. You can deactivate it instead, if you do so, all meals belonging to this category will be deactivated too and you will need to activate each meal manually.
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			      	<form action="{{route('delete-category')}}" method="post">
				        @csrf
				        <input name="id" type="hidden" value="{{$category['id']}}">
				        <button class="btn btn-danger" type="submit">Yes</button>
			       	</form>
			      </div>
			    </div>
			  </div>
			</div>
		   @endforeach
		@endif
		@if (count($data) == 0)
			<h3>There are no categories</h3>
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