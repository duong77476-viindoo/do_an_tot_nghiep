
@extends('frontend.layout')
@section('content')
    <div class="blog-post-area">
        <h2 class="title text-center">Bài viết cho {{$post_type->name}}</h2>
        @foreach($posts as $post)
            <?php
            $currentDateTime = $post->updated_at;
            $Time = date('h:i A', strtotime($currentDateTime));
            $Date = date('d/m/Y', strtotime($currentDateTime))
            ?>

        <div class="single-blog-post">
            <h3>{{$post->title}}</h3>
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
            <p>{{$post->desc}}</p>
            <a  class="btn btn-primary" href="{{route('chi-tiet-bai-viet',['danh_muc'=>$post->post_type->code,'bai_viet'=>$post->code])}}">Đọc thêm</a>
        </div>
        @endforeach
        <div class="pagination-area">

            <ul class="pagination">
                {{$posts->links()}}
{{--                <li><a href="" class="active">1</a></li>--}}
{{--                <li><a href="">2</a></li>--}}
{{--                <li><a href="">3</a></li>--}}
{{--                <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>--}}
            </ul>
        </div>
    </div>
@endsection
