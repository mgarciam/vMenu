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
    <h2>Change your password</h2>
    <form id="form-change-password" role="form" method="POST" action="{{ action('SettingsController@update') }}" novalidate class="form-horizontal">
      @csrf
      <div class="col-md-9">
        <input name="id" type="hidden" value="{{$id}}">             
        <label for="current-password" class="col-sm-4 control-label">Current Password</label>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Password">
          </div>
        </div>
        <label for="password" class="col-sm-4 control-label">New Password</label>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
        </div>
        <label for="password_confirmation" class="col-sm-4 control-label">Re-enter Password</label>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password">
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-5 col-sm-6">
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      </div>
    </form>
    <h2>Update your info</h2>
    <form id="form-update-info" role="form" method="POST" action="{{ action('SettingsController@updateInfo') }}" novalidate class="form-horizontal">
      @csrf
      <div class="col-md-9">
        <input name="id" type="hidden" value="{{$id}}">             
        <label for="name" class="col-sm-4 control-label">Name</label>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{Auth::user()->name}}">
          </div>
        </div>
        <label for="password" class="col-sm-4 control-label">Last name</label>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Last name" value="{{Auth::user()->surname}}">
          </div>
        </div>
        <label for="password_confirmation" class="col-sm-4 control-label">Email</label>
        <div class="col-sm-8">
          <div class="form-group">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{Auth::user()->email}}">
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-5 col-sm-6">
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      </div>
    </form>
  @endif
@endsection