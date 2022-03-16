<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        @php
                            $i = 0;
                        @endphp
                        @foreach($sliders as $key => $slider)
                            @php
                                $i++;
                            @endphp
                            <div class="item {{$i==1 ? 'active' : ''}}">
                                <div class="col-sm-12">
{{--                                    <h1><span>BC</span>-MAR</h1>--}}
{{--                                    <h2>{{$slider->name}}</h2>--}}
{{--                                    <p>{{$slider->desc}}</p>--}}
{{--                                    <button type="button" class="btn btn-default get">Xem ngay</button>--}}
                                    <img src="{{url('public/uploads/sliders/'.$slider->image)}}" class="img img-responsive" width="950px" alt="{{$slider->name}}" />
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('frontend.sidebar')
            </div>

            <div class="col-sm-9 padding-right">
                @yield('content')
            </div>
        </div>
    </div>
</section>

<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->




</body>
</html>
