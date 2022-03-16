@extends('frontend.layout')
@section('content')
    <div class="blog-post-area">
        <h2 class="title text-center">{{$post->post_type->name}}</h2>
        <div class="single-blog-post">
            <h3>{{$post->title}}</h3>
            <?php
            $currentDateTime = $post->updated_at;
            $Time = date('h:i A', strtotime($currentDateTime));
            $Date = date('d/m/Y', strtotime($currentDateTime))
            ?>

            <div class="post-meta">
                <ul>
                    <li><i class="fa fa-user"></i> {{$post->nguoi_sua}}</li>
                    <li><i class="fa fa-clock-o"></i> {{$Time}}</li>
                    <li><i class="fa fa-calendar"></i> {{$Date}}</li>
                </ul>
                <span>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-half-o"></i>
								</span>
            </div>
            <a href="">
                <img src="{{asset('public/uploads/posts/'.$post->image)}}" height="300px" alt="{{$post->title}}">
            </a>
            <p>{!! $post->content !!}</p>
{{--            <div class="pager-area">--}}
{{--                <ul class="pager pull-right">--}}
{{--                    <li><a href="#">Pre</a></li>--}}
{{--                    <li><a href="#">Next</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
        </div>
    </div><!--/blog-post-area-->

    <div class="rating-area">
        <ul class="ratings">
            <li class="rate-this">Rate this item:</li>
            <li>
                <i class="fa fa-star color"></i>
                <i class="fa fa-star color"></i>
                <i class="fa fa-star color"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </li>
            <li class="color">(6 votes)</li>
        </ul>
{{--        <ul class="tag">--}}
{{--            <li>TAG:</li>--}}
{{--            <li><a class="color" href="">Pink <span>/</span></a></li>--}}
{{--            <li><a class="color" href="">T-Shirt <span>/</span></a></li>--}}
{{--            <li><a class="color" href="">Girls</a></li>--}}
{{--        </ul>--}}
    </div><!--/rating-area-->

    <div class="socials-share">
        <div class="fb-like"
             data-href="{{$url_canonical}}"
             data-width="" data-layout="button_count"
             data-action="like" data-size="small" data-share="true"></div>
    </div><!--/socials-share-->

    <div class="media commnets">
        <h3>Xem thêm bài viết liên quan</h3>
        <ul>
            @foreach($related_posts as $related_post)
                <li style="list-style-type: disc">
                    <a href="{{route('chi-tiet-bai-viet',['danh_muc'=>$related_post->post_type->code,'bai_viet'=>$related_post->code])}}">
                        <div class="media-body">
                            <h4 class="media-heading">{{$related_post->title}}</h4>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div><!--Comments-->
    <div class="response-area">
        <div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="5"></div>
    </div><!--/Response-area-->
{{--    <div class="replay-box">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-4">--}}
{{--                <h2>Leave a replay</h2>--}}
{{--                <form>--}}
{{--                    <div class="blank-arrow">--}}
{{--                        <label>Your Name</label>--}}
{{--                    </div>--}}
{{--                    <span>*</span>--}}
{{--                    <input type="text" placeholder="write your name...">--}}
{{--                    <div class="blank-arrow">--}}
{{--                        <label>Email Address</label>--}}
{{--                    </div>--}}
{{--                    <span>*</span>--}}
{{--                    <input type="email" placeholder="your email address...">--}}
{{--                    <div class="blank-arrow">--}}
{{--                        <label>Web Site</label>--}}
{{--                    </div>--}}
{{--                    <input type="email" placeholder="current city...">--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <div class="col-sm-8">--}}
{{--                <div class="text-area">--}}
{{--                    <div class="blank-arrow">--}}
{{--                        <label>Your Name</label>--}}
{{--                    </div>--}}
{{--                    <span>*</span>--}}
{{--                    <textarea name="message" rows="11"></textarea>--}}
{{--                    <a class="btn btn-primary" href="">post comment</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div><!--/Repaly Box-->--}}
@endsection
