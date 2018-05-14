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
    <a href="{{route('categories')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
   <h2>Add category</h2><br/>
   <form method="post" action="{{action('AddCategoryController@addCategory')}}" enctype="multipart/form-data">
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
      <label for="image">Image:</label>
      <input type="file" name="image" accept=".png, .jpg, .jpeg" />
     </div>
    </div>
    <div class="row">
     <div class="col-md-4"></div>
     <div class="form-group col-md-4" style="margin-top:60px">
      <button type="submit" class="btn btn-success">Add category</button>
	     <button type="reset" class="btn btn-danger">Reset</button>
     </div>
    </div>
   </form>
	@endif
@endsection