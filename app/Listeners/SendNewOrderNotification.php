<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Models\Order;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $orders = Order::where('trang_thai','Đang chờ xử lý')->orderBy('created_at','DESC')->first();
        $admin_user = Admin::find(1);
        \Illuminate\Support\Facades\Notification::send($admin_user, new NewOrderNotification($event->order));
    }
}
