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
	    <a href="{{route('orders')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
	    <h2>Order #{{$data->id}}</h2>
	    @if ($guest == null)
	    <p>Guest: Admin</p>
	    @endif
	    @if ($guest)
	    <p>Guest: {{$guest->name}} {{$guest->surname}}</p>
	    <p>Room number: {{$guest->room_number}}</p>
	    @endif
	    <p>Current status: {{$data->stat}}</p>
	    <p>Total: $ {{$data->total}}</p>
	    <h4>Order items:</h4>
	    <ul>
	    	@foreach($goodMeals as $meal)
	    		<li>{{$meal->name}}</li>
	    	@endforeach
	    </ul>
	    <br>
	    <br>
	    <form method="post" action="{{route('update-order')}}" enctype="multipart/form-data">
	    	@csrf
	    	<h4>Select new status:</h4>
		    <div class="row">
		    <div class="col-md-4"></div>
		     <div class="form-group col-md-4">
		     <input name="id" type="hidden" value="{{$data->id}}">
		      <label for="peso">Status:</label>
		      <input type="radio" class="radio-inline" id="status1" name="status" value="0"><label for="status1">Pending</label>
		      <input type="radio" class="radio-inline" id="status2" name="status" value="1"><label for="status2">In process</label>
		      <input type="radio" class="radio-inline" id="status3" name="status" value="2"><label for="status3">Sent</label>
		      <input type="radio" class="radio-inline" id="status4" name="status" value="3"><label for="status4">Delivered</label>
		     </div>
	    	</div>
	    	<button type="submit" class="btn btn-success">Update order</button>
	    </form>
	@endif
@endsection