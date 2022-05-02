<?php
?>
<!-- jQuery -->
<script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('public/backend/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('public/backend/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('public/backend/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('public/backend/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('public/backend/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('public/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('public/backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('public/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/backend/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('public/backend/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('public/backend/dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
{{--link script cho việc tìm kiếm data ở table sản phẩm, đơn hàng,...--}}
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
{{--link script cho thêm từ khóa, tag sản phẩm--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//unpkg.com/autonumeric"></script>


<!-- morris JavaScript -->
@yield('pagescript')
<script>
    $(document).ready(function() {
        //BOX BUTTON SHOW AND CLOSE
        jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
        }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
        });
        jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
        });

        //CHARTS
        function gd(year, day, month) {
            return new Date(year, month - 1, day).getTime();
        }

        graphArea2 = Morris.Area({
            element: 'hero-area',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth:true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity:0.85,
            data: [
                {period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
                {period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
                {period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
                {period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
                {period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
                {period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
                {period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
                {period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
                {period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},

            ],
            lineColors:['#eb6f6f','#926383','#eb6f6f'],
            xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });


    });
</script>
<!-- calendar -->
<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
<script type="text/javascript">
    $(window).load( function() {

        $('#mycalendar').monthly({
            mode: 'event',

        });

        $('#mycalendar2').monthly({
            mode: 'picker',
            target: '#mytarget',
            setWidth: '250px',
            startHidden: true,
            showTrigger: '#mytarget',
            stylePast: true,
            disablePast: true
        });

        switch(window.location.protocol) {
            case 'http:':
            case 'https:':
                // running on a server, should be good.
                break;
            case 'file:':
                alert('Just a heads-up, events will not work when run locally.');
        }

    });
</script>
<!-- //calendar -->
{{--Ckeditor--}}
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<script>
    CKEDITOR.config.extraPlugins = "toc"
    CKEDITOR.replace('mo_ta_chi_tiet');
    CKEDITOR.replace('content');
</script>

{{--Format money--}}
<script type="text/javascript">
    $(document).ready(function (){
        new AutoNumeric('.money', {
            currencySymbol :'đ',
            decimalPlaces: 2,
            digitGroupSeparator : ',',
            decimalCharacter : '.',
            currencySymbolPlacement : 's'
        });
    })
</script>

{{--script dể thêm từ khóa, tag sản phẩm--}}
<script type="text/javascript">
    $("#tags").selectize({
        delimiter: ",",
        plugins: ['remove_button'],
        create: true,
        showAddOptionOnCreate:false,
    });
</script>

{{--plugin datatable js--}}
<script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
{{--script liên quan đến video--}}
<script type="text/javascript">
    $(document).ready(function (){
        load_video();
        function load_video(){
            $.ajax({
                url: "{{url('/select-video')}}",
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (data){
                   $('#load-video').html(data);
                }
            });
        }
        $(document).on('click','.add-video',function (){
            var video_title = $('.video-title').val();
            var video_desc = $('.video-desc').val();
            var video_link = $('.video-link').val();
            var video_image = $('#video_image')[0].files[0];
            var form_data = new FormData();
            form_data.append("video_title",video_title);
            form_data.append("video_desc",video_desc);
            form_data.append("video_link",video_link);
            form_data.append("video_image",video_image);

            $.ajax({
                url: "{{url('/insert-video')}}",
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function (data){
                    if($.isEmptyObject(data.error)){
                        $("#form-video")[0].reset();
                        $(".print-error-msg").css('display','none');
                        load_video();
                        $('#notify').html(data.success);
                    }else{
                        printErrorMsg(data.error);
                    }

                }
            });

        });
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

        $(document).on('blur','.video_edit',function (){
            var video_col = $(this).data('video_col');
            var video_data = $(this).text();
            var video_id = $(this).data('video_id');
            // alert(video_data);
            $.ajax({
                url: "{{url('/update-video')}}",
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{video_col:video_col,video_data:video_data,video_id:video_id},
                success:function (data){
                    if($.isEmptyObject(data.error)){
                        $("#form-video")[0].reset();
                        $(".print-error-msg").css('display','none');
                        load_video();
                        $('#notify').html(data.success)
                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        })

        $(document).on('click','.delete-video',function (){
            var video_id = $(this).data('video_id');
            if(confirm('Bạn muốn xóa video này không?')){
                $.ajax({
                    url: "{{url('/delete-video')}}",
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        video_id:video_id
                    },
                    success:function (data){
                        if($.isEmptyObject(data.error)){
                            $("#form-video")[0].reset();
                            $(".print-error-msg").css('display','none');
                            load_video();
                            $('#notify').html(data.success);
                        }else{
                            printErrorMsg(data.error);
                        }

                    }
                });
            }
        });

        $(document).on('change','.video_image',function (){
            var video_id = $(this).data('video_id');
            var image = $('#file_'+video_id)[0].files[0];
            var form_data = new FormData();
            form_data.append('video_image',image);
            form_data.append('video_id',video_id);
            $.ajax({
                url: "{{url('/update-video-image')}}",
                method: "POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function (data){
                    if($.isEmptyObject(data.error)){
                        $("#form-video")[0].reset();
                        $(".print-error-msg").css('display','none');
                        load_video();
                        $('#notify').html(data.success)
                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        });
    })

</script>

{{--Script gallery của 1 sản phẩm khi click vào thư viện ảnh ở trong sản phẩm--}}
<script type="text/javascript">
    $(document).ready(function (){
        load_gallery();
        function load_gallery(){
            var product_group_id = $('.product_group_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
               url: "{{url('/select-gallery')}}",
               method: "POST",
               data: {
                   product_group_id:product_group_id,
                   _token:_token
               },
               success:function (data){
                   $('#load-gallery').html(data);
               }
            });
        }

        $('#file').change(function (){
            var error = '';
            var files = $('#file')[0].files;

            if(files.length>5){
                error+='<p>Tối đa được chọn 5 ảnh</p>';
            }else if(files.length==0){
                error+='<p>Bạn không được bỏ trống ảnh</p>';
            }else if(files.size > 2000000){
                error+='<p>File ảnh không được lớn hơn 2MB</p';
            }

            if(error==''){

            }else {
                $('#file').val('');//làm rỗng file ảnh
                $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                return false;
            }
        })

        $(document).on('blur','.edit_gallery_name',function (){
            var gallery_id = $(this).data('gallery_id');
            var gallery_name = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('/update-gallery-name')}}",
                method: "POST",
                data: {
                    gallery_id:gallery_id,
                    gallery_name:gallery_name,
                    _token:_token
                },
                success:function (data){
                    load_gallery();
                    $('#error_gallery').html('<span class="text-success">Cập nhật tên hình ảnh thành công</span>');
                }
            });
        });

        $(document).on('click','.delete-gallery',function (){
            var gallery_id = $(this).data('gallery_id');
            var _token = $('input[name="_token"]').val();
            if(confirm('Bạn có muốn xóa?')){
                $.ajax({
                    url: "{{url('/delete-gallery')}}",
                    method: "POST",
                    data: {
                        gallery_id:gallery_id,
                        _token:_token
                    },
                    success:function (data){
                        load_gallery();
                        $('#error_gallery').html('<span class="text-success">Xóa hình ảnh thành công</span>');
                    }
                });

            }
        });

        $(document).on('change','.gallery_image',function (){
            var gallery_id = $(this).data('gallery_id');
            var image = $('#file_'+gallery_id)[0].files[0];
            var form_data = new FormData();
            form_data.append('file',image);
            form_data.append('gallery_id',gallery_id);
            var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('/update-gallery')}}",
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function (data){
                        load_gallery();
                        $('#error_gallery').html('<span class="text-success">Cập nhật hình ảnh thành công</span>');
                    }
                });
        });

    })
</script>



{{--Script thêm phí vận chuyển ajax--}}
<script type="text/javascript">
    $(document).ready(function(){
        load_fee_ship();
        function load_fee_ship() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/load-fee-ship')}}',
                method: 'POST',
                data: {
                    _token:_token
                },
                success: function (data){
                    $('#load-fee-ship').html(data)
                }
            });
        }
        $(document).on('focus','.fee_ship_edit',function(e){
            var feeValue = $(this).text();
            feeValue = feeValue.replace('.','');
            feeValue = feeValue.slice(0, feeValue.length - 2);
            e.target.innerText = feeValue;
        });
        $(document).on('blur','.fee_ship_edit',function (){
           var fee_ship_id = $(this).data('fee_ship_id');
           var fee_ship = $(this).text();
            var _token = $('input[name="_token"]').val();
           $.ajax({
                url: '{{url('/update-fee-ship')}}',
                method: 'POST',
                data: {
                    fee_ship_id:fee_ship_id,
                    fee_ship:fee_ship,
                    _token:_token
                },
                success: function (data){
                    load_fee_ship();
                }
            });

        });
        $('.add_fee_ship').click(function (e){
            e.preventDefault();
            var city = $('.city').val();
            var province = $('.province').val();
            var ward = $('.ward').val();
            var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/add-fee-ship')}}',
                method: 'POST',
                data: {
                    city:city,
                    province:province,
                    ward:ward,
                    fee_ship:fee_ship,
                    _token:_token
                },
                success: function (data){
                    load_fee_ship();
                    if($.isEmptyObject(data.error)){
                        $("#form-fee-ship")[0].reset();
                        $(".print-error-msg").css('display','none');
                        swal({
                            title: "Thêm phí vận chuyển thành công",
                            // text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                            // showCancelButton: true,
                            // cancelButtonText: "Tiếp tục",
                            // confirmButtonClass: "btn-success",
                            // confirmButtonText: "Đi đến giỏ hàng",
                            closeOnConfirm: false
                        })

                    }else{
                        printErrorMsg(data.error);
                    }

                        {{--function() {--}}
                        {{--    window.location.href = "{{url('/gio-hang')}}";--}}
                        {{--});--}}
                }
            });
        });
        $('.choose').on('change',function (){
            var action = $(this).attr('id');//
            var id = $(this).val();//Nếu chọn city thì id này sẽ nhận id của city, và tương tự khi chọn province
            var _token = $('input[name="_token"]').val();
            var result = '';
            if(action=='city'){
                result = 'province';
            }else{
                result = 'ward';
            }
            $.ajax({
                url: '{{url('/select-province-ward')}}',
                method: 'POST',
                data: {
                    action:action,
                    id:id,
                    _token:_token
                },
                success: function (data){
                    $('#'+result).html(data);
                }
            });
        });
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    })
</script>

{{--Script thay đổi trạng thái đơn hàng--}}
<script type="text/javascript">
    $('.update_order_status').on('focusin', function(){
        console.log("Saving value " + $(this).val());
        $(this).data('val', $(this).val());
    });
 $('.update_order_status').change(function (){

     var pre_order_status = $(this).data('val');
    var order_status = $(this).val();
    var order_id = $(this).children(":selected").attr("id");
    var _token = $('input[name="_token"]').val();

    //Lấy số lượng của mỗi sản phẩm trong đơn hàng
    var order_product_qty = [];
    $('input[name="product_qty"]').each(function (){
        order_product_qty.push($(this).val());
    });
    //Lấy id của mỗi sản phẩm
    var order_product_id = [];
     $('input[name="product_id"]').each(function (){
         order_product_id.push($(this).val());
     });
     var dem=0;
     //Kiểm tra số lượng đặt với số lượng trong kho
     if(order_status!="Đã hủy" && order_status!="Chờ xác nhận hủy"){
         $.ajax({
             url: '{{url('/update-order-status')}}',
             method: 'POST',
             data: {
                 pre_order_status:pre_order_status,
                 order_status:order_status,
                 order_id:order_id,
                 order_product_qty:order_product_qty,
                 order_product_id:order_product_id,
                 _token:_token,
             },
             success: function (data){
                 alert("Cập nhật trạng thái thành công");
                 location.reload();
             }
         });
     }
     else{
         if(order_status=="Đã hủy"){
             if(confirm("Bạn có chắc chắn muốn hủy đơn hàng?")){
                alert("Đã hủy đơn hàng");
                $.ajax({
                     url: '{{url('/update-order-status')}}',
                     method: 'POST',
                     data: {
                         pre_order_status:pre_order_status,
                         order_status:order_status,
                         order_id:order_id,
                         order_product_qty:order_product_qty,
                         order_product_id:order_product_id,
                         _token:_token,
                     },
                     success: function (data){
                         alert("Cập nhật trạng thái thành công");
                         location.reload();
                     }
                 });
             }else{
                location.reload();
             }
         }
         else{
             $.ajax({
                 url: '{{url('/update-order-status')}}',
                 method: 'POST',
                 data: {
                     pre_order_status:pre_order_status,
                     order_status:order_status,
                     order_id:order_id,
                     order_product_qty:order_product_qty,
                     order_product_id:order_product_id,
                     _token:_token,
                 },
                 success: function (data){
                     alert("Cập nhật trạng thái thành công");
                     location.reload();
                 }
             });
         }
     }

 });
</script>

