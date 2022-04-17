<?php

namespace App\Exports;

use App\Models\CongNoNcc;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CongNoNccExport implements FromView
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
     * @var string
     */
    private $NCC;

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

    public function setNCC(int $NCC): void{
        $this->NCC = $NCC;
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

    /**
     * @return string
     */
    public function getNCC(): string
    {
        return $this->NCC;
    }

//    public function __construct(string $month, string $year) {
//        $this->month = $month;
//        $this->year = $year;
//    }

    public function view(): View
    {
        $cong_no_nccs = CongNoNcc::where('nha_cung_cap_id',$this->getNCC())->where('year',$this->getYear())->where('month',$this->getMonth())->get();
        return view('admin.cong_no_ncc.export',['cong_no_nccs'=>$cong_no_nccs]);
    }
}
