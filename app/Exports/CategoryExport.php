<?php

namespace App\Exports;

use App\Models\CategoryProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CategoryProduct::all();
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'Mã phân loại',
            'Tên phân loại',
            'Mô tả',
            'Ẩn hiện',
            'Từ khóa meta',
            'Code',
            'Ngày tạo',
            'Ngày sửa'
        ];
    }
}
