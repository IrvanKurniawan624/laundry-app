@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pegawai</h2>

    <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary mb-3">+ Tambah Pegawai</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pegawais as $index => $pegawai)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pegawai->name }}</td>
                    <td>{{ $pegawai->email }}</td>
                    <td>{{ $pegawai->nomor_telepon }}</td>
                    <td>{{ $pegawai->alamat }}</td>
                    <td>
                        <a href="{{ route('admin.pegawai.edit', $pegawai->id_user) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.pegawai.destroy', $pegawai->id_user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus pegawai ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada pegawai</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pegawais->links() }}
</div>
@endsection
