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
    <a href="{{route('admins')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
   <h2>Add administrative user</h2><br/>
   <form method="post" action="{{action('AddUserController@addUser')}}" enctype="multipart/form-data">
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
      <label for="email">Email:</label>
      <input type="text" class="form-control" name="email" value="{{old('email')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="password">Password:</label>
      <input type="password" class="form-control" name="password" autocomplete="new-password" value="{{old('password')}}">
     </div>
    </div><div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="password_confirmation">Confirm Password:</label>
      <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password" value="{{old('password_confirmation')}}">
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="peso">Role:</label>
      <input type="radio" class="radio-inline" id="role1" name="role" value="admin"><label for="role1">Admin</label>
      <input type="radio" class="radio-inline" id="role2" name="role" value="cook"><label for="role2">Cook</label>
      <input type="radio" class="radio-inline" id="role3" name="role" value="front"><label for="role3">Front-desk</label>
     </div>
    </div>
    <div class="row">
     <div class="col-md-4"></div>
     <div class="form-group col-md-4" style="margin-top:60px">
      <button type="submit" class="btn btn-success">Add user</button>
	  <button type="reset" class="btn btn-danger">Reset</button>
     </div>
    </div>
   </form>
	@endif
@endsection