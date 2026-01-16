<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Tampilkan semua dokter
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    // Tampilkan form tambah dokter
    public function create()
    {
        return view('doctors.create');
    }

    // Simpan data dokter baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'specialization' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('succes', 'Data dokter berhasil ditambahkan.');
    }

    // Tampilkan detail dokter
    public function show(Doctor $doctor)
    {
        $doctor->load('schedules');
        return view('doctors.show', compact('doctor'));
    }

    // Tampilkan form edit dokter
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    // Update data dokter
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'specialization' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        $doctor->update($request->all());

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    // Hapus data dokter
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
