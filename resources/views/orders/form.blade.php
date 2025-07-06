@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Form Pemesanan Katering</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_name" class="form-label">Nama Pemesan</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="customer_email" class="form-label">Email (Opsional)</label>
            <input type="email" name="customer_email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="customer_phone" class="form-label">Nomor Telepon</label>
            <input type="text" name="customer_phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat Lengkap</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>

        <h5 class="mt-4">Pilih Menu</h5>
        <div id="menu-items">
            @foreach($menus as $menu)
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6>{{ $menu->name }}</h6>
                            <p class="mb-1">{{ $menu->description }}</p>
                            <strong>Rp {{ number_format($menu->price, 0, ',', '.') }}</strong>
                        </div>
                        <div>
                            <input type="hidden" name="menu_id[]" value="{{ $menu->id }}">
                            <label>Jumlah:</label>
                            <input type="number" name="quantity[]" class="form-control" value="0" min="0">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Kirim Pesanan</button>
    </form>
</div>
@endsection
