@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="mb-3">Invoice Pemesanan</h2>

            <div class="mb-4">
                <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</p>
                <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Alamat:</strong> {{ $order->address }}</p>
                <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>

            <h5>Detail Pesanan:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($order->menus as $menu)
                        @php
                            $quantity = $menu->pivot->quantity;
                            $subtotal = $menu->price * $quantity;
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>{{ $quantity }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-end">Total Bayar:</th>
                        <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                    </tr>
                </tbody>
            </table>

            {{-- Form Pembayaran --}}
            <div class="mt-4">
                <h5>Pilih Metode Pembayaran:</h5>
                <form action="{{ route('order.pay', $order->id) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <select name="payment_method" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cod">Bayar di Tempat (COD)</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success">Lanjutkan Pembayaran</button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('order.form') }}" class="btn btn-primary">Pesan Lagi</a>
                <button onclick="window.print()" class="btn btn-outline-secondary">Cetak Invoice</button>
            </div>
        </div>
    </div>
</div>
@endsection
