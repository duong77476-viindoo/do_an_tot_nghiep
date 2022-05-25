@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-product-spec',$product_group) }}
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
                <div id="notify">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                </div>
                <form id="form-product" action="{{route('insert-product-spec',['id'=>$product_group->id])}}" method="post">
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
                                            <div class="form-group">
                                                <label>
                                                    Giá bán
                                                    <input type="text" class="form-control money" name="gia_ban[]" style="background: #CCCCCC">
                                                </label>
                                            </div>
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
                    <input type="submit" class="btn btn-primary" value="Thêm">
                </form>

                <div class="panel-body">
                    <div class="container">
                        <input type="hidden" value="{{$product_group->id}}" name="product_group_id" class="product_group_id">
                        <form action="{{route('update-product-spec',['id'=>$product_group->id])}}" method="post">
                            @csrf
                        <div id="load-product-spec">
                        </div>
                            <input class="form-control btn btn-primary" type="submit" name="save_change_product" value="Lưu thay đổi">
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
                    new AutoNumeric('.money'+x+'', {
                        currencySymbol :'đ',
                        decimalPlaces: 2,
                        digitGroupSeparator : ',',
                        decimalCharacter : '.',
                        currencySymbolPlacement : 's'
                    });
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
                    '<div class="form-group">' +
                    '<label>' +
                    'Giá bán' +
                    '<input type="text" class="form-control money'+dem+'" name="gia_ban[]" style="background: #CCCCCC">'+
                    '</label>'+
                    '</div>' +
                    '<a href="javascript:void(0);" class="remove_button">' +
                    '<i class="fa fa-times"></i>' +
                    'Xóa</a>' +
                    '</div>';
            }
        });
    </script>
{{-- Load các phiên bản sản phẩm   --}}
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

            $(document).on('click','.delete-product',function (){
                var product_id = $(this).data('product_id');
                if(confirm('Bạn muốn xóa sản phẩm này không?')){
                    $.ajax({
                        url: "{{url('/delete-product-spec')}}",
                        method: "POST",
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            product_id:product_id
                        },
                        success:function (data){
                            if($.isEmptyObject(data.error)){
                                $("#form-product")[0].reset();
                                $(".print-error-msg").css('display','none');
                                load_product_spec();
                                $('#notify').html(data.success);
                            }else{
                                printErrorMsg(data.error);
                            }

                        }
                    });
                }
            });
        })
    </script>
{{-- xóa phiên bản sản phẩm   --}}
    <script type="text/javascript">

    </script>
@endsection
