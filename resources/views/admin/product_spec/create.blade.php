@extends('admin.admin_layout')
@section('admin_content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm phiên bản sản phẩm cho <span class="text-primary">nhóm sản phẩm {{$product_group->name}}</span>
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <form action="{{route('insert-product-spec',['id'=>$product_group->id])}}" method="post">
                    @csrf
                    <div class="row">

                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin thuộc tính phiên bản</h3>
                                    </div>
                                    <div class="card-body">
                                        <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field"><i class="fas fa-plus"></i>Thêm mới trường nhập</a>
                                        <h3>#1</h3>
                                        <div class="row field_wrapper">
                                        @foreach($dac_tinhs as $dac_tinh)
                                            <div class="form-group">
                                                <label>
                                                    {{$dac_tinh->name}}
                                                    <input class="form-control col" type="text" name="{{$dac_tinh->code}}[]">
                                                </label>
                                            </div>
                                        @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>

{{--                        <div class="col-md-3">--}}

{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="file" class="form-control" name="file[]" id="file" accept="image/*" multiple>--}}
{{--                            <span id="error_gallery"></span>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <input type="submit" name="upload" value="Tải ảnh" class="btn btn-primary">--}}
{{--                        </div>--}}
                    </div>
                    <input type="submit" class="btn btn-primary" value="Lưu">
                </form>

                <div class="panel-body">
                    <div class="container">
                        <input type="hidden" value="{{$product_group->id}}" name="product_group_id" class="product_group_id">
                        <form>
                            @csrf
                        <div id="load-product-spec">
                        </div>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>

@endsection
@section('pagescript')
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper

            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(html_input(x)); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
            function html_input(dem){
                //New input field html
                return '<div class="row" style="border-top: 1px solid #8c8b8b">' +
                    '<h3 class="col-md-12">#' + dem +
                    '</h3>'+
                    '@foreach($dac_tinhs as $dac_tinh)' +

                    '<div class="form-group">' +
                    '<label>' +
                    '{{$dac_tinh->name}}' +
                    '<input class="form-control col" type="text" name="{{$dac_tinh->code}}[]">' +
                    '</label>' +

                    '</div>' +
                    '@endforeach' +
                    '<a href="javascript:void(0);" class="remove_button">' +
                    '<i class="fa fa-times"></i>' +
                    'Xóa</a>' +
                    '</div>';
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function (){
            load_product_spec();
            function load_product_spec(){
                var product_group_id = $('.product_group_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('/select-product-spec')}}",
                    method: "POST",
                    data: {
                        product_group_id:product_group_id,
                        _token:_token
                    },
                    success:function (data){
                        $('#load-product-spec').html(data);
                    }
                });
            }

            {{--$('#file').change(function (){--}}
            {{--    var error = '';--}}
            {{--    var files = $('#file')[0].files;--}}

            {{--    if(files.length>5){--}}
            {{--        error+='<p>Tối đa được chọn 5 ảnh</p>';--}}
            {{--    }else if(files.length==0){--}}
            {{--        error+='<p>Bạn không được bỏ trống ảnh</p>';--}}
            {{--    }else if(files.size > 2000000){--}}
            {{--        error+='<p>File ảnh không được lớn hơn 2MB</p';--}}
            {{--    }--}}

            {{--    if(error==''){--}}

            {{--    }else {--}}
            {{--        $('#file').val('');//làm rỗng file ảnh--}}
            {{--        $('#error_gallery').html('<span class="text-danger">'+error+'</span>');--}}
            {{--        return false;--}}
            {{--    }--}}
            {{--})--}}

            {{--$(document).on('blur','.edit_gallery_name',function (){--}}
            {{--    var gallery_id = $(this).data('gallery_id');--}}
            {{--    var gallery_name = $(this).text();--}}
            {{--    var _token = $('input[name="_token"]').val();--}}
            {{--    $.ajax({--}}
            {{--        url: "{{url('/update-gallery-name')}}",--}}
            {{--        method: "POST",--}}
            {{--        data: {--}}
            {{--            gallery_id:gallery_id,--}}
            {{--            gallery_name:gallery_name,--}}
            {{--            _token:_token--}}
            {{--        },--}}
            {{--        success:function (data){--}}
            {{--            load_gallery();--}}
            {{--            $('#error_gallery').html('<span class="text-success">Cập nhật tên hình ảnh thành công</span>');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            {{--$(document).on('click','.delete-gallery',function (){--}}
            {{--    var gallery_id = $(this).data('gallery_id');--}}
            {{--    var _token = $('input[name="_token"]').val();--}}
            {{--    if(confirm('Bạn có muốn xóa?')){--}}
            {{--        $.ajax({--}}
            {{--            url: "{{url('/delete-gallery')}}",--}}
            {{--            method: "POST",--}}
            {{--            data: {--}}
            {{--                gallery_id:gallery_id,--}}
            {{--                _token:_token--}}
            {{--            },--}}
            {{--            success:function (data){--}}
            {{--                load_gallery();--}}
            {{--                $('#error_gallery').html('<span class="text-success">Xóa hình ảnh thành công</span>');--}}
            {{--            }--}}
            {{--        });--}}

            {{--    }--}}
            {{--});--}}

            {{--$(document).on('change','.gallery_image',function (){--}}
            {{--    var gallery_id = $(this).data('gallery_id');--}}
            {{--    var image = $('#file_'+gallery_id)[0].files[0];--}}
            {{--    var form_data = new FormData();--}}
            {{--    form_data.append('file',image);--}}
            {{--    form_data.append('gallery_id',gallery_id);--}}
            {{--    var _token = $('input[name="_token"]').val();--}}
            {{--    $.ajax({--}}
            {{--        url: "{{url('/update-gallery')}}",--}}
            {{--        method: "POST",--}}
            {{--        headers:{--}}
            {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        data: form_data,--}}
            {{--        contentType:false,--}}
            {{--        cache:false,--}}
            {{--        processData:false,--}}
            {{--        success:function (data){--}}
            {{--            load_gallery();--}}
            {{--            $('#error_gallery').html('<span class="text-success">Cập nhật hình ảnh thành công</span>');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

        })
    </script>
@endsection
