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
    <a href="{{route('meals')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left">Back</span></a>
   <h2>Add category</h2><br/>
   <form method="post" action="{{action('AddMealController@addMeal')}}" enctype="multipart/form-data">
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
      <label for="description">Description:</label>
      <textarea class="form-control" name="description">{{old('description')}}</textarea>
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="price">Price:</label>
      <div class="input-group">
        <span class="input-group-addon">$</span>
        <input type="text" class="form-control" name="price" value="{{old('price')}}">
      </div>
     </div>
    </div>
    <div class="row">
    <div class="col-md-4"></div>
     <div class="form-group col-md-4">
      <label for="rooms">Select category:</label>
      <select class="form-control" name="categories" id="categories">
        @foreach($activeCats as $id => $category)
          <option value="{{$category->id}}" id="{{$category->id}}" {{ (collect(old('categories'))->contains($category->id)) ? 'selected':'' }}>{{ $category['name'] }}</option>
        @endforeach
      </select>
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
      <button type="submit" class="btn btn-success">Add meal</button>
	     <button type="reset" class="btn btn-danger">Reset</button>
     </div>
    </div>
   </form>
	@endif
@endsection