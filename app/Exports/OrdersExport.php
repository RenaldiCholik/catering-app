<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::with('menus')->get()->map(function ($order) {
            return [
                'Nama Pemesan' => $order->customer_name,
                'No. Telepon'  => $order->customer_phone,
                'Alamat'       => $order->address,
                'Total'        => $order->total_price,
                'Tanggal'      => $order->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Pemesan', 'No. Telepon', 'Alamat', 'Total', 'Tanggal'];
    }
}
