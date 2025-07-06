@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Daftar Pesanan</h2>

    <a href="{{ route('admin.home') }}" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
    <a href="{{ route('orders.export') }}" class="btn btn-success mb-3">📥 Export ke CSV</a>

    @if($orders->isEmpty())
        <p>Tidak ada pesanan saat ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Pemesan</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Menu Dipesan</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Status Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        <ul class="mb-0 ps-3">
                            @foreach($order->menus as $menu)
                                <li>
                                    {{ $menu->name }} ({{ $menu->pivot->quantity }}) 
                                    - Rp {{ number_format($menu->pivot->subtotal, 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>

                    {{-- ✅ Status --}}
                    <td>
                        <span class="badge 
                            {{ $order->status === 'baru' ? 'bg-secondary'
                                : ($order->status === 'diproses' ? 'bg-warning' : 'bg-success') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    {{-- ✅ Status Bayar --}}
                    <td>
                        <span class="badge {{ $order->payment_method ? 'bg-success' : 'bg-secondary' }}">
                            {{ $order->payment_method ? 'Sudah Bayar' : 'Belum Bayar' }}
                        </span>
                    </td>

                    {{-- ✅ Aksi --}}
                    <td>
                        {{-- Ubah status --}}
                        @if($order->status === 'baru')
                            <form action="{{ route('orders.status', [$order, 'diproses']) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-info">Proses</button>
                            </form>
                        @elseif($order->status === 'diproses')
                            <form action="{{ route('orders.status', [$order, 'selesai']) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">Selesai</button>
                            </form>
                        @endif

                        {{-- Tombol "Selesai" aslinya --}}
                        <form action="{{ route('orders.done', $order->id) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini sebagai selesai?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mt-1">
                                ✅ Selesai
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
