@extends('layouts.app')

@section('content')
    <h1>Buat Pesanan</h1>
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <label>Nama Pelanggan:</label>
        <input type="text" name="customer_name" required>

        <label>No. HP:</label>
        <input type="text" name="customer_phone" required>

        <label>Alamat:</label>
        <textarea name="address" required></textarea>

        <h3>Pilih Menu</h3>
        @foreach ($menus as $index => $menu)
            <div>
                <input type="checkbox" name="menus[]" value="{{ $menu->id }}">
                {{ $menu->name }} - Rp{{ number_format($menu->price, 0, ',', '.') }}
                <label>Jumlah:</label>
                <input type="number" name="quantities[]" min="1" value="1">
            </div>
        @endforeach

        <button type="submit">Pesan Sekarang</button>
    </form>
@endsection
