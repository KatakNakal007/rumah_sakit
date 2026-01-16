@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Pasien</h2>

        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $patient->name }}">
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="gender" class="form-control">
                    <option value="L" {{ $patient->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $patient->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" value="{{ $patient->birth_date }}">
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="address" class="form-control">{{ $patient->address }}</textarea>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ $patient->phone }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
