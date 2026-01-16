@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Dokter</h2>

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $doctor->name }}">
            </div>
            <div class="mb-3">
                <label>Spesialisasi</label>
                <input type="text" name="specialization" class="form-control" value="{{ $doctor->specialization }}">
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ $doctor->phone }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
