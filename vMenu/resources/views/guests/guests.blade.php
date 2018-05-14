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
	    <h2>Guests</h2>
	    <a href="{{route('add-guest')}}" class="btn btn-info" style="float: right;">Add guest</a>
	    @if (count($data) > 0)
		   <input class="form-control" id="filter" type="text" placeholder="Search for guest..." style="width: 20%;">
		   <br>
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Registered at</th>
		      <th>Name</th>
		      <th>Last Name</th>
		      <th>Room #</th>
		      <th>Email</th>
		      <th>Phone</th>
		      <th>Invoice total</th>
		      <th>Active</th>
		      <th colspan="2"></th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($data as $guest)
		     <tr>
		      <td>{{$guest['id']}}</td>
		      <td>{{$guest['created_at']}}</td>
		      <td>{{$guest['name']}}</td>
		      <td>{{$guest['surname']}}</td>
		      <td>{{$guest['room_number']}}</td>
		      <td>{{$guest['email']}}</td>
		      <td>{{$guest['phone']}}</td>
		      <td>$ {{$guest['invoice_total']}}</td>
		      <td>{{$guest['active']}}</td>
		      <td><a href="{{action('GuestsController@editGuest', ['id'=>$guest['id']])}}" class="btn btn-warning">Edit guest</a></td>
		      <td>
		      	<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$guest->id}}">Delete</button>
		      </td>
		     </tr>
		    @endforeach
		    </tbody>
		   </table>
		   @foreach($data as $guest)
		   	<div class="modal fade" id="deleteModal{{$guest->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			      	<h4 class="modal-title" id="myModalLabel">Delete guest</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete the guest associated with {{$guest->email}}?
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			      	<form action="{{route('delete-guest')}}" method="post">
				        @csrf
				        <input name="id" type="hidden" value="{{$guest['id']}}">
				        <button class="btn btn-danger" type="submit">Yes</button>
			       	</form>
			      </div>
			    </div>
			  </div>
			</div>
		   @endforeach
		@endif
		@if (count($data) == 0)
			<h3>There are no guests</h3>
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