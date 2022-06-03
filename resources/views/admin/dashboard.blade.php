@extends('admin.admin_layout')
@section('admin_content')
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
