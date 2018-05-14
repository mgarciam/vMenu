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
	    <h2>Administrative users</h2>
	    <a href="{{route('add-user')}}" class="btn btn-info" style="float: right;">Add user</a>
	    @if (count($data) > 0)
		   <input class="form-control" id="filter" type="text" placeholder="Search for user..." style="width: 20%;">
		   <br>
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Name</th>
		      <th>Last Name</th>
		      <th>Email</th>
		      <th>Role</th>
		      <th colspan="2"></th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($data as $user)
		     <tr>
		      <td>{{$user['id']}}</td>
		      <td>{{$user['name']}}</td>
		      <td>{{$user['surname']}}</td>
		      <td>{{$user['email']}}</td>
		      <td>{{$user['role']}}</td>
		      <td><a href="{{action('AdminsController@editUser', ['id'=>$user['id']])}}" class="btn btn-warning">Edit role</a></td>
		      <td>
		      	<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$user->id}}">Delete</button>
		      </td>
		     </tr>
		    @endforeach
		    </tbody>
		   </table>
		   @foreach($data as $user)
		   	<div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			      	<h4 class="modal-title" id="myModalLabel">Delete user</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete the account associated with {{$user->email}}?
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			      	<form action="{{route('delete-user')}}" method="post">
				        @csrf
				        <input name="id" type="hidden" value="{{$user['id']}}">
				        <button class="btn btn-danger" type="submit">Yes</button>
			       	</form>
			      </div>
			    </div>
			  </div>
			</div>
		   @endforeach
		@endif
		@if (count($data) == 0)
			<h3>There are no users</h3>
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