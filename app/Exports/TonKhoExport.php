<?php

namespace App\Exports;

use App\Models\TonKho;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TonKhoExport implements FromView
{
    /**
     * @var string
     */
    private $year;
    /**
     * @var string
     */
    private $month;

    /**
     * @param string $month
     */
    public function setMonth(string $month): void
    {
        $this->month = $month;
    }

    /**
     * @param string $year
     */
    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

//    public function __construct(string $month, string $year) {
//        $this->month = $month;
//        $this->year = $year;
//    }

    public function view(): View
    {
        $ton_khos = TonKho::where('trang_thai','Hoàn thành')->where('year',$this->getYear())->where('month',$this->getMonth())->get();
        return view('admin.ton_kho.export',['ton_khos'=>$ton_khos]);
    }
}
