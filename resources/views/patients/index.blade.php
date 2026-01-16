@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Pasien</h2>
        <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Tambah Pasien</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- <form action="{{ route('patients.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama pasien..."
                    value="{{ request('keyword') }}">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </div>
        </form> --}}

        <form action="{{ route('patients.index') }}" method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari nama pasien..."
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="birth_date" class="form-control" value="{{ request('birth_date') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $patient->birth_date }}</td>
                        <td>{{ $patient->address }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $patients->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
