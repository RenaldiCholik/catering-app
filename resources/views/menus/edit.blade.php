@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Menu</h1>

    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" name="name" value="{{ $menu->name }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" name="price" value="{{ $menu->price }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Menu</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $menu->description ?? '') }}</textarea>
        </div>
        

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
