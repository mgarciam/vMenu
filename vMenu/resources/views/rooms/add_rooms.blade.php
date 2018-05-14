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
    <br>
    <a href="{{route('rooms')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
    <h2>Add room</h2>
    <form method="post" action="{{action('AddRoomController@addRoom')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="number">Number:</label>
      <input type="text" class="form-control" name="number" value="{{old('number')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="price">Price per night:</label>
      <div class="input-group">
        <span class="input-group-addon">$</span>
        <input type="text" class="form-control" name="price" value="{{old('price')}}">
      </div>
     </div>
    </div>
    <div class="row">
     <div class="col-md-4"></div>
     <div class="form-group col-md-4" style="margin-top:60px">
      <button type="submit" class="btn btn-success">Add room</button>
    <button type="reset" class="btn btn-danger">Reset</button>
     </div>
    </div>
   </form>
  @endif
@endsection