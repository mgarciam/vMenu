@extends('layouts.app')

@section('content')
@if(Auth::check())

  <h1 style="text-align: center;">Hola {{Auth::user()->name}} {{Auth::user()->surname}}</h1>
  <img src="http://pix10.agoda.net/hotelImages/661/66154/66154_16042216400041723233.jpg?s=1024x768" style="width: 100%;">

@endif
@endsection