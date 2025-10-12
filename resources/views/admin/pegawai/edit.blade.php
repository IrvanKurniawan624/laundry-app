@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Pegawai</h2>

    <form method="POST" action="{{ route('admin.pegawai.update', $pegawai->id_user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $pegawai->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $pegawai->email }}" required>
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" value="{{ $pegawai->nomor_telepon }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ $pegawai->alamat }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
