<?php

namespace App\Exports;

use App\Models\CongNoNcc;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class BaoCaoCongNoExport implements FromView
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


    public function view(): View
    {

        $cong_no_nccs = CongNoNcc::where('trang_thai','Hoàn thành')->where('year',$this->getYear())->where('month',$this->getMonth())->get();
        return view('admin.cong_no_ncc.export_so_cong_no',['cong_no_nccs'=>$cong_no_nccs]);
    }
}
