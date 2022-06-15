<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    /**
     * @var int
     */
    private $id;
    /**

    /**
     * @param int $id
     */
    public function setID(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getid(): int
    {
        return $this->id;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        $order = Order::find($this->getid());
        $order_detail = OrderDetail::where('order_id',$order->id)->get();
        return view('admin.order.export_order',['order'=>$order,'order_detail'=>$order_detail]);
    }
}
