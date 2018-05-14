<!DOCTYPE html>
<html>
  <head>
    <title>vMenu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">  
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
  </head>

  <body>
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
    <nav class="navbar">
      <div class="container">
        <a class="navbar-brand">Cart</a>
        <div class="navbar-right">
          <div class="container minicart"></div>
        </div>
      </div>
    </nav>
    
    <div class="container-fluid breadcrumbBox text-center">
      <a href="{{route('menu')}}" class="btn btn-info" style="float: right;"><span class="glyphicon glyphicon-chevron-left"></span></a>
    </div>
    
    <div class="container text-center">

      <div class="col-md-5 col-sm-12">
        <div class="bigcart"></div>
        <h1>Your cart</h1>
        <p>
          The total for the order will be accounted to your total invoice.
        </p>
      </div>
      
      <div class="col-md-7 col-sm-12 text-left">
        <ul>
          <li class="row list-inline columnCaptions">
            <span>QTY</span>
            <span>ITEM</span>
            <span>Price</span>
          </li>
          @foreach(Cart::content() as $item)
          <li class="row">
            <span class="quantity">{{$item->qty}}</span>
            <span class="itemName">{{$item->name}}</span>
            <span class="popbtn"><a href="{{route('delete-item', ['id'=>$item->rowId])}}"><span class="glyphicon glyphicon-remove"></span></a></span>
            <span class="price">$ {{$item->price}}</span>
          </li>
          @endforeach
          <li class="row totals">
            <span class="itemName">Total:</span>
            <span class="price">$ {{Cart::subtotal()}}</span>
            <form method="post" action="{{route('checkout')}}">
              @csrf
              <p>Enter the email address you provided at check-in, if you are an admin leave it blank</p>
              <input type="text" name="email">
              <span class="order"><button class="btn btn-info" type="submit">ORDER</button></span>
            </form>
          </li>
        </ul>
      </div>

    </div>
    
    <!-- JavaScript includes -->

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> 
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="assets/js/customjs.js"></script>

  </body>
</html>