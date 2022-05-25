@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('comment') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Bình luận sản phẩm
            </div>
            <div id="notify-comment">

            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>

{{--                <div class="col-sm-3">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" class="input-sm form-control" placeholder="Search">--}}
{{--                        <span class="input-group-btn">--}}
{{--            <button class="btn btn-sm btn-default" type="button">Go!</button>--}}
{{--          </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Duyệt</th>
                        <th>Tên người bình luận</th>
                        <th>Email</th>
                        <th>Sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $key => $comment)
                        @if($comment->parent_id==null)
                        <tr>
                            <td>
                                @if($comment->da_duyet==0)
                                    <input type="button" data-comment_duyet="1" data-comment_id="{{$comment->id}}" class="btn_duyet_comment btn btn-success" value="Duyệt">
                                @else
                                    <input type="button" data-comment_duyet="0" data-comment_id="{{$comment->id}}" class="btn_duyet_comment btn btn-danger" value="Bỏ duyệt">
                                @endif
                            </td>
                            <td>{{$comment->name}}</td>
                            <td>{{$comment->email}}</td>
                            <td>
                                <a href="{{route('product',['code'=>$comment->product->code])}}" target="_blank">
                                    {{$comment->product->name}}
                                </a>
                            </td>
                            <td>
                                {{$comment->content}}
                                <ul style="list-style-type: none;padding-left: 0">
                                    @foreach($comments as $comment_reply)
                                        @if($comment_reply->parent_id==$comment->id)
                                            <li>
                                                <i class="far fa-user-circle"></i>{{$comment_reply->name}}: {{$comment_reply->content}}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                @if($comment->da_duyet==1)
                                    <br><textarea class="reply_comment_{{$comment->id}} form-control" rows="8" style="resize: none"></textarea>
                                    <br><button data-comment_id="{{$comment->id}}" data-product_id="{{$comment->product_id}}" class="btn-sm btn_reply_comment">Trả lời bình luận</button>
                                @endif
                            </td>
                            <td>{{$comment->created_at}}</td>
                            <td>
                                <a href="{{route('delete-comment',['id'=>$comment->id])}}"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')"
                                   class="active" ui-toggle-class=""><i class="fa fa-trash text-danger text"></i></a>
                            </td>
                        </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    {{--                    <div class="col-sm-5 text-center">--}}
                    {{--                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>--}}
                    {{--                    </div>--}}
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
{{--                            {{ $product_groups->links() }}--}}
                            {{--                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>--}}
                            {{--                            <li><a href="">1</a></li>--}}
                            {{--                            <li><a href="">2</a></li>--}}
                            {{--                            <li><a href="">3</a></li>--}}
                            {{--                            <li><a href="">4</a></li>--}}
                            {{--                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function (){
            $('.btn_duyet_comment').click(function (){
               var comment_duyet = $(this).data('comment_duyet');
               var comment_id = $(this).data('comment_id');
               if(comment_duyet==1){
                   var alert = 'Bỏ duyệt thành công';
               }else{
                   var alert = 'Duyệt thành công';

               }
                $.ajax({
                    url: "{{url('/duyet-comment')}}",
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{comment_duyet:comment_duyet,comment_id:comment_id},
                    success:function (data){
                        location.reload();
                        $('#notify-comment').html('<span class="text text-success">'+alert+'</span>');
                        $('#notify-comment').fadeOut(5000);
                    }
                });
            });
            $('.btn_reply_comment').click(function (){

                var comment_id = $(this).data('comment_id');
                var comment_content = $('.reply_comment_'+comment_id).val();
                var comment_product_id = $(this).data('product_id');
                var alert = 'Phản hồi bình luận thành công';
                $.ajax({
                    url: "{{url('/reply-comment')}}",
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{comment_content:comment_content,comment_id:comment_id,comment_product_id:comment_product_id},
                    success:function (data){
                        $('.reply_comment_'+comment_id).val('');
                        $('#notify-comment').html('<span class="text text-success">'+alert+'</span>');
                        $('#notify-comment').fadeOut(5000);
                    }
                });
            });
        })
    </script>
@endsection
