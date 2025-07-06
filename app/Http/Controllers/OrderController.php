<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /* ========== FORM & LIST ========== */

    public function form()
    {
        $menus = Menu::all();
        return view('orders.form', compact('menus'));
    }

    public function index()
    {
        // pastikan relasi menus di‑load
        $orders = Order::with('menus')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /* ========== EXPORT CSV ========== */

    public function exportCsv()   // ←  sudah tanpa tipe return
    {
        $orders = Order::with('menus')->get();

        $csv  = "Nama Pemesan,No Telepon,Alamat,Menu Dipesan,Total,Tanggal\n";

        foreach ($orders as $order) {
            $menus = $order->menus
                ->map(fn ($m) => $m->name . ' x' . $m->pivot->quantity)
                ->implode('; ');

            $csv .= "\"{$order->customer_name}\",";
            $csv .= "\"{$order->customer_phone}\",";
            $csv .= "\"{$order->address}\",";
            $csv .= "\"{$menus}\",";
            $csv .= "\"Rp " . number_format($order->total_price, 0, ',', '.') . "\",";
            $csv .= "\"{$order->created_at->format('d/m/Y H:i')}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=\"orders.csv\"');
    }
// menyelesaikan pesanan
    public function markAsDone(Order $order)
{
    try {
        $order->delete(); // menghapus pesanan dan relasinya
        return back()->with('success', 'Pesanan telah diselesaikan.');
    } catch (\Throwable $e) {
        return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
    }
}


    /* ========== SIMPAN ORDER ========== */

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'address'        => 'required|string',
            'menu_id'        => 'required|array',
            'menu_id.*'      => 'required|exists:menus,id',
            'quantity'       => 'required|array',
            'quantity.*'     => 'required|integer|min:0',
        ]);
        // Tambahan keamanan (eksplisit, meski $menuPivot sudah menanganinya)
if (! collect($request->quantity)->contains(fn ($q) => (int)$q > 0)) {
    return back()->with('error', 'Silakan pilih setidaknya satu menu.');
}

    
        DB::beginTransaction();
    
        try {
            $total      = 0;
            $menuPivot  = [];
    
            foreach ($request->menu_id as $index => $menuId) {
                $qty = (int) $request->quantity[$index];
                if ($qty <= 0) continue;
    
                $menu = Menu::findOrFail($menuId);
                $subtotal = $menu->price * $qty;
    
                // Cek jika menu sudah ada di array, jumlahkan qty dan subtotal
                if (isset($menuPivot[$menuId])) {
                    $menuPivot[$menuId]['quantity'] += $qty;
                    $menuPivot[$menuId]['subtotal'] += $subtotal;
                } else {
                    $menuPivot[$menuId] = [
                        'quantity' => $qty,
                        'subtotal' => $subtotal,
                    ];
                }
    
                $total += $subtotal;
            }
    
            if (empty($menuPivot)) {
                return back()->with('error', 'Silakan pilih setidaknya satu menu.');
            }
    
            $order = Order::create([
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'address'        => $request->address,
                'total_price'    => $total,
                'status'         => 'baru',              // default
                'note'           => $request->note ?? null,
            ]);
    
            $order->menus()->attach($menuPivot);
    
            DB::commit();
    
            $order->load('menus');
            return view('orders.invoice', compact('order'));
    
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: '.$e->getMessage());
        }
    }
    /* ========== FITUR BARU: STATUS & CATATAN ========== */

    // ubah status: diproses / selesai
    public function updateStatus(Order $order, string $status)
    {
        if (!in_array($status, ['diproses', 'selesai'])) {
            return back()->with('error', 'Status tidak valid.');
        }

        $order->update(['status' => $status]);
        return back()->with('success', "Pesanan #{$order->id} ditandai {$status}.");
    }

    // simpan atau ubah catatan
    public function updateNote(Request $request, Order $order)
    {
        $request->validate(['note' => 'nullable|string']);
        $order->update(['note' => $request->note]);
        return back()->with('success', 'Catatan diperbarui.');
    }
    //Payment
    public function pay(Request $request, Order $order)
{
    $request->validate([
        'payment_method' => 'required|in:transfer,cod,qris',
    ]);

    $order->update([
        'payment_method' => $request->payment_method,
        'status' => 'diproses', // ubah status agar tercatat
    ]);

    return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil diproses.');
}
   
} 