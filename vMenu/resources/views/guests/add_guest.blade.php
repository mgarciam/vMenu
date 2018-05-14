@extends('layouts.app')

@section('content')
	@if (Auth::Check())
	@if (count( $errors ) > 0) 
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          {{ $error }}
        <br>
        @endforeach
      </div>
    @endif
    <br>
    <a href="{{route('guests')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
   <h2>Add guest</h2><br/>
   <form method="post" action="{{action('AddGuestController@addGuest')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="name">Name:</label>
      <input type="text" class="form-control" name="name" value="{{old('name')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="surname">Last name:</label>
      <input type="text" class="form-control" name="surname" value="{{old('surname')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="rooms">Select room:</label>
      <select class="form-control" name="rooms" id="rooms">
        @foreach($availableRooms as $id => $room)
          <option value="{{$room->id}}" id="{{$room->id}}" {{ (collect(old('rooms'))->contains($room->id)) ? 'selected':'' }}>Room number: {{ $room['number'] }}, Price per night: $ {{ $room['price'] }}</option>
        @endforeach
      </select>
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="stay">Stay duration (days):</label>
      <input type="text" class="form-control" name="stay" value="{{old('stay')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="email">Email:</label>
      <input type="text" class="form-control" name="email" value="{{old('email')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="phone">Phone number (10 digits):</label>
      <input type="text" class="form-control" name="phone" value="{{old('phone')}}" maxlength="10">
     </div>
    </div>
    <div class="row">
     <div class="col-md-4"></div>
     <div class="form-group col-md-4" style="margin-top:60px">
      <button type="submit" class="btn btn-success">Register guest</button>
	  <button type="reset" class="btn btn-danger">Reset</button>
     </div>
    </div>
   </form>
	@endif
@endsection