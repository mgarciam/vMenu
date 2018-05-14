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
	    <a href="{{route('guests')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
	    <h2>Edit guest</h2>
	    <form method="post" action="{{route('update-guest')}}" enctype="multipart/form-data">
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
		      <label for="surname">Last name:</label>
		       <input type="text" class="form-control" name="surname" value="{{$data->surname}}">
		     </div>
		    </div>
		    <div class="row">
		    <div class="col-md-4"></div>
		     <div class="form-group col-md-4">
		      <label for="email">Email:</label>
		      <input type="text" class="form-control" name="email" value="{{$data->email}}">
		     </div>
		    </div>
		    <div class="row">
		    <div class="col-md-4"></div>
		     <div class="form-group col-md-4">
		      <label for="phone">Phone number (10 digits):</label>
		      <input type="text" class="form-control" name="phone" value="{{$data->phone}}" maxlength="10">
		     </div>
		    </div>
		    <div class="row">
		    <div class="col-md-4"></div>
		     <div class="form-group col-md-4" style="margin-top:10px">
		      <button type="submit" class="btn btn-success" style="margin-left:38px">Update room</button>
		     </div>
		    </div>
	    </form>
	    @if (!empty($ord) && count($ord) > 0)
	   	<h2>Orders made by {{$data->name}} {{$data->surname}}</h2>
	   	<br>
		   <input class="form-control" id="filter" type="text" placeholder="Search for order..." style="width: 20%;">
		   <table class="table table-hover">
		    <thead>
		     <tr>
		      <th>ID</th>
		      <th>Date of creation</th>
		      <th>Total</th>
		      <th>Status</th>
		     </tr>
		    </thead>
		    <tbody class="searchable">
		    @foreach($ord as $o)
		     <tr>
		      <td>{{$o['id']}}</td>
		      <td>{{$o['created_at']}}</td>
		      <td>$ {{$o['total']}}</td>
		      <td>{{$o['stat']}}</td>
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