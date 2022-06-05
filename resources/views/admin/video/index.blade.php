@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('video') }}
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục video
            </div>
            <?php
            $message = \Illuminate\Support\Facades\Session::get('message');
            if($message){
                echo $message;
                \Illuminate\Support\Facades\Session::put('message',null);
            }
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="position-center">
                        <div id="notify">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                        </div>
                        <form id="form-video">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề video</label>
                                <input type="text" class="form-control video-title" id="exampleInputEmail1" name="title" placeholder="Nhập tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả</label>
                                <input type="text" class="form-control video-desc" id="exampleInputEmail1" name="desc" placeholder="Nhập mô tả">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Đường link</label>
                                <input type="text" class="form-control video-link" id="exampleInputEmail1" name="link" placeholder="Nhập đường link">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="file" class="form-control video-image" id="video_image" name="image" accept="image/*" placeholder="Nhập đường link">
                            </div>

                            <button type="button" name="add_video" class="btn btn-info add-video">Thêm video</button>

                        </form>
                    </div>
                </div>
            </div>
            <div id="load-video">

            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="video_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tên video</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Xem video
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
