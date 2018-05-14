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
	    <h2>Orders</h2>
	    @if (count($data) > 0)
		   <input class="form-control" id="filter" type="text" placeholder="Search for order..." style="width: 20%;">
		   <br>
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Creation date</th>
		      <th>Name</th>
		      <th>Last name</th>
		      <th>Total</th>
		      <th>Status</th>
		      <th colspan="2"></th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($data as $order)
		     <tr>
		      <td>{{$order['id']}}</td>
		      <td>{{$order['created_at']}}</td>
		      <td>{{$order['name']}}</td>
		      <td>{{$order['surname']}}</td>
		      <td>$ {{$order['total']}}</td>
		      <td>{{$order['stat']}}</td>
		      <td><a href="{{action('OrdersController@editOrder', ['id'=>$order['id']])}}" class="btn btn-warning">Update order</a></td>
		      <td>
		      	<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$order->id}}">Delete</button>
		      </td>
		     </tr>
		    @endforeach
		    </tbody>
		   </table>
		   @foreach($data as $order)
		   	<div class="modal fade" id="deleteModal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			      	<h4 class="modal-title" id="myModalLabel">Delete order</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete the order #{{$order->id}}?
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			      	<form action="{{route('delete-order')}}" method="post">
				        @csrf
				        <input name="id" type="hidden" value="{{$order['id']}}">
				        <button class="btn btn-danger" type="submit">Yes</button>
			       	</form>
			      </div>
			    </div>
			  </div>
			</div>
		   @endforeach
		@endif
		@if (count($data) == 0)
			<h3>There are no orders</h3>
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