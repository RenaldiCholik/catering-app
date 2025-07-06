@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Menu</h1>

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" name="price" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Menu</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $menu->description ?? '') }}</textarea>
        </div>
        

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
