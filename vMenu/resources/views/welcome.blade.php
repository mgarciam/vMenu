<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <title>vMenu</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        
        <link href="{{ asset('css/square_images.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .full-height {
                height: 10vh;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            body{
               background: #f5f8fa;
               font-family: Raleway;
               text-align: center;
            }

            .label {
                font-size: 25px;
                color: #000;
            }

            .slide-button {
                position: absolute;
                top: 0;
                bottom: 0;
                width: 5%;
                text-align: center;
                cursor: pointer;
            }

            .carousel-images{
               display: block;
               margin: 30px;
               max-width:1000px;
               max-height:431px;
               width: auto;
               height: auto;
            }

            .slide-button img {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                font-size: 35px;
                font-weight: bold;
                background: rgba(255,255,255,0.4);
                border-radius: 50%;
                height: 40px;
                width: 40px;
                color: white;
            }

            .button-prev {
                left: 15px;
            }

            .button-next {
                right: 15px;
            }

            .slider ul {
                list-style: none;
                width: 500px;
                position: relative;
                left: 0;
                padding: 0;
                margin: 0;
            }

            .slider ul li {
                float: left;
            }

            .slider {
                position: relative;
                width: 100%;
                padding: 10px ;
                overflow: hidden;
                margin: 0 auto;
            }

        </style>
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
        <h1>Menu</h1>
        <div class="position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Admin panel</a>
                    @else
                        <a href="{{ route('login') }}">Login (admins only)</a>
                    @endauth
                    @if (Cart::count() > 0)
                        <a href="{{ route('see-cart') }}" class="btn btn-info">See cart</a>
                    @endif
                </div>
            @endif
        </div>
        @if (count($data) > 0)
         <div class="slider col-xs-12">
            <ul>
                @foreach($data as $category)
                <li><img class="carousel-images" src="{{ url('/') }}/images/{{$category->image}}" alt="{{$category->name}}"><p class="label">{{$category->name}}<p></li>
                @endforeach  
            </ul>
            <a class="slide-button button-prev clickable" data-nav="prev"><img src="https://cdn3.iconfinder.com/data/icons/faticons/32/arrow-left-01-256.png"/> </a>
            <a class="slide-button button-next clickable" data-nav="next"><img src="https://cdn3.iconfinder.com/data/icons/faticons/32/arrow-right-01-512.png"/></a>
        </div>
        @endif
        @if (count($data) == 0)
        <h1>There are no categories yet!</h1>
        @endif
        @if (count($meals) > 0)
        <h2>Meals</h2>
        <br>
        <br>
        <div class="row" style="margin: 20px;">
            @foreach($meals as $key => $meal)
                @if ($key % 4 == 0)
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="row">
                            <a href="#detailModal{{$meal->id}}" data-toggle="modal" data-target="#detailModal{{$meal->id}}"><img src="{{ url('/') }}/images/{{$meal->image}}"></a>
                        </div>
                        <div class="row">
                            <p>{{$meal->name}}</p>
                        </div>
                        <div class="row">
                            <p>$ {{$meal->price}}</p>
                        </div>
                    </div>
                    @if (count($meals) > ($key + 1))
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="row">
                            <a href="#detailModal{{$meals[$key + 1]->id}}" data-toggle="modal" data-target="#detailModal{{$meals[$key + 1]->id}}"><img src="{{ url('/') }}/images/{{$meals[$key + 1]->image}}"></a>
                        </div>
                        <div class="row">
                            <p>{{$meals[$key + 1]->name}}</p>
                        </div>
                        <div class="row">
                            <p>$ {{$meals[$key + 1]->price}}</p>
                        </div>
                    </div>
                    @endif
                    @if (count($meals) > ($key + 2))
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="row">
                            <a href="#detailModal{{$meals[$key + 2]->id}}" data-toggle="modal" data-target="#detailModal{{$meals[$key + 2]->id}}"><img src="{{ url('/') }}/images/{{$meals[$key + 2]->image}}"></a>
                        </div>
                        <div class="row">
                            <p>{{$meals[$key + 2]->name}}</p>
                        </div>
                        <div class="row">
                            <p>$ {{$meals[$key + 2]->price}}</p>
                        </div>
                    </div>
                    @endif
                    @if (count($meals) > ($key + 3))
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="row">
                            <a href="#detailModal{{$meals[$key + 3]->id}}" data-toggle="modal" data-target="#detailModal{{$meals[$key + 3]->id}}"><img src="{{ url('/') }}/images/{{$meals[$key + 3]->image}}"></a>
                        </div>
                        <div class="row">
                            <p>{{$meals[$key + 3]->name}}</p>
                        </div>
                        <div class="row">
                            <p>$ {{$meals[$key + 3]->price}}</p>
                        </div>
                    </div>
                    @endif
                @endif
            @endforeach
        </div>
        @endif
        @if (count($meals) == 0)
        <h1>There are no meals yet!</h1>
        @endif
        @foreach($meals as $meal)
            <div class="modal fade" id="detailModal{{$meal->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{$meal->name}} ({{$meal->category}})</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <img src="{{ url('/') }}/images/{{$meal->image}}">
                    <p>{{$meal->description}}</p>
                    <strong>$ {{$meal->price}}</strong>
                  </div>
                  <div class="modal-footer">
                    <form action="{{route('add-cart')}}" method="post">
                        @csrf
                        <input name="id" type="hidden" value="{{$meal['id']}}">
                        Quantity: <input type="number" name="qty" min="1" value="1">
                        <button class="btn btn-info" type="submit">Add to cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        @endforeach
    </body>
    <script type="text/javascript">
        $(document).ready(function () {
        var imageBox = $('.slider ul');
        var imageWidth = $('.slider ul li img').width();
        var imageQuantity = $('.slider ul li').length;
        var currentImage = 0;

        imageBox.css('width', imageWidth * imageQuantity);

        $(document).on("click", '.clickable', function () {
            var whichButton = $(this).data('nav');
            if (whichButton === "next") {
                currentImage++;
                if (currentImage >= imageQuantity) {
                    currentImage = 1;
                    nextImage(currentImage, imageWidth);
                }
                else {
                    nextImage(currentImage, imageWidth);
                }

            } else {
                currentImage--;
                if (currentImage <= 0) {
                    currentImage = imageQuantity;
                    nextImage(currentImage, imageWidth)
                }
                else {
                    nextImage(currentImage, imageWidth)
                }
            }
        });

        function nextImage(currentImage, imageWidth) {
            var pxValue = -(currentImage - 1) * imageWidth;
            imageBox.animate({
                'left': pxValue
            })
        }
        });
    </script>
</html>
