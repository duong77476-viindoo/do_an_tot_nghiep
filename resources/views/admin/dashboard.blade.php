@extends('admin.admin_layout')
@section('admin_content')


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('admin') }}
                        </div>
                        <div class="card-body">
                            @if(session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if(auth()->id()==1)
                                @forelse($notifications as $notification)
                                    <div class="alert alert-success" role="alert">
                                        Đơn hàng ngày #{{ $notification->data['order_id'] }} của khách hàng ({{ $notification->data['customer'] }}) vào ngày ({{ $notification->data['order_date'] }})
                                        vừa mới được order.
                                        <a href="#" class="float-right mark-as-read" data-order_id="{{$notification->data['order_id']}}"  data-id="{{ $notification->id }}">
                                            Đánh dấu đã đọc
                                        </a>
                                    </div>

                                    @if($loop->last)
                                        <a href="#" id="mark-all">
                                            Đánh dấu đã đọc tất cả
                                        </a>
                                    @endif
                                @empty
                                    Không có thông báo mới
                                @endforelse
                            @else
                                Chào !
                            @endif
                        </div>
                    </div>
                </div>
                </div>
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-3">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$order_count}}</h3>

                                <p>ĐƠN HÀNG</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{route('all-customer-order')}}" class="small-box-footer">Xem <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-3">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$product_count}}</h3>

                                <p>KHO</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route('all-ton-kho')}}" class="small-box-footer">Xem <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-3">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$customer_count}}</h3>

                                <p>KHÁCH HÀNG</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('all-customer')}}" class="small-box-footer">Xem <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-3">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$rating_count}}</h3>

                                <p>ĐÁNH GIÁ</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{route('all-rating')}}" class="small-box-footer">Xem <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

@endsection

@section('pagescript')
    @if(auth()->id()==1)
        <script type="text/javascript">
            function sendMarkRequest(id = null,order_id = null) {
                return $.ajax("{{ route('admin.markNotification') }}", {
                    method: 'POST',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        order_id,
                        id
                    }
                });
            }
            $(function() {
                $('.mark-as-read').click(function() {
                    let request = sendMarkRequest($(this).data('id'), $(this).data('order_id'));
                    request.done(() => {
                        $(this).parents('div.alert').remove();
                    });
                });
                $('#mark-all').click(function() {
                    let request = sendMarkRequest();
                    request.done(() => {
                        $('div.alert').remove();
                    })
                });
            });
        </script>
    @endif
@endsection
