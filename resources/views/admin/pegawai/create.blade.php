@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Pegawai</h2>

    <form method="POST" action="{{ route('admin.pegawai.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
