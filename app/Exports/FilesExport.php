<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FilesExport implements FromArray, WithHeadings, WithEvents
{
    public function array(): array
    {
        // بيانات فارغة
        return [];
    }

    public function headings(): array
    {
        return [
          'المصنع',	'الحركة',	'حساب الصيدلية',	'عدد',	'الاسم التجاري',	'هدية',	'مجموع الداخل',	'مجموع الخارج',	'المندوب',	'المنطقة',	'قيمة الهدايا'

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // تعيين اتجاه الورقة من اليمين لليسار
                $event->sheet->getDelegate()->setRightToLeft(true);

                // محاذاة النص في الأعمدة لليمين
                $event->sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
