<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Pharmacy;
use App\Models\Transaction;
use App\Models\Representative;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class FilesImport implements OnEachRow
{
    protected $fileId;
    protected $warehouseId;

    public function __construct($fileId, $warehouseId)
    {
        $this->fileId = $fileId;
        $this->warehouseId = $warehouseId;
    }

    public function onRow(Row $row)
    {
        $r = $row->toArray();  // مصفوفة عادية مثل [0 => ..., 1 => ...]

        // تخطي الصف الأول (العناوين)
        if ($row->getIndex() === 1) {
            return;
        }

        // خريطة الأعمدة حسب ملفك
        $factoryName      = $r[0];
        $movementName     = $r[1];
        $pharmacyName     = $r[2];
        $quantityProduct  = $r[3];
        $productName      = $r[4];
        $quantityGift     = $r[5];
        $valueIncome      = $r[6];
        $valueOutput      = $r[7];
        $representativeName = $r[8];
        $areaName         = $r[9];
        $valueGift        = $r[10];

        // 1️⃣ المصنع
        $factory = Factory::firstOrCreate(['name' => $factoryName]);

        // 2️⃣ المنطقة
        $area = Area::firstOrCreate(
            ['name' => $areaName, 'warehouse_id' => $this->warehouseId]
        );

        // 3️⃣ المندوب
        $representative = Representative::firstOrCreate(
            ['name' => $representativeName, 'area_id' => $area->id],
            ['warehouse_id' => $this->warehouseId]
        );

        // 4️⃣ الصيدلية
        $pharmacy = Pharmacy::firstOrCreate([
            'name'               => $pharmacyName,
            'area_id'            => $area->id,
            'warehouse_id'       => $this->warehouseId,
            'representative_id'  => $representative->id
        ]);

        // 5️⃣ المنتج
        $product = Product::firstOrCreate([
            'name'         => $productName,
            'factory_id'   => $factory->id,
            'warehouse_id' => $this->warehouseId
        ]);

        // 6️⃣ نوع الحركة
        $movement = strtolower($movementName);

        if (str_contains($movement, 'مبيع')) {
            $type = 'Wholesale Sale';
        } elseif (str_contains($movement, 'مرتجع')) {
            $type = 'Wholesale Return';
        } else {
            $type = 'Wholesale Sale';
        }

        // 7️⃣ إنشاء العملية
        Transaction::create([
            'factory_id'        => $factory->id,
            'type'              => $type,
            'pharmacy_id'       => $pharmacy->id,
            'quantity_product'  => $quantityProduct,
            'product_id'        => $product->id,
            'quantity_gift'     => $quantityGift,
            'value_income'      => abs($valueIncome),
            'value_output'      => abs($valueOutput),
            'representative_id' => $representative->id,
            'area_id'           => $area->id,
            'value_gift'        => abs($valueGift),
            'warehouse_id'      => $this->warehouseId,
            'file_id'           => $this->fileId,
        ]);
    }
}
