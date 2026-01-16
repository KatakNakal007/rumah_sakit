<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Tampilkan semua pasien
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $birth_date = $request->input('birth_date');

        $patients = Patient::query()
            ->when($keyword, fn($query) => $query->where('name', 'like', "%{$keyword}%"))
            ->when($birth_date, fn($query) => $query->whereDate('birth_date', $birth_date))
            ->paginate(10) // tampilkan 10 pasien per halaman
            ->withQueryString(); // agar filter tetap saat pindah halaman

        // $patients = Patient::query()
        //     ->when($keyword, fn($query) => $query->where('name', 'like', "%{$keyword}%"))
        //     ->when($birth_date, fn($query) => $query->whereDate('birth_date', $birth_date))
        //     ->get();

        // $patients = Patient::when($keyword, function ($query, $keyword) {
        //     return $query->where('name', 'like', "%{$keyword}%");
        // })->get();

        // $patients = Patient::all();
        return view('patients.index', compact('patients', 'keyword', 'birth_date'));
    }

    // Tampilkan form tambah pasien
    public function create()
    {
        return view('patients.create');
    }

    // Simpan data pasien baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        Patient::create($request->all());

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    // Tampilkan detail pasien (opsional)
    public function show(Patient $patient)
    {
        $patient->load('appointments.doctor', 'appointments.schedule'); // eager load relasi
        return view('patients.show', compact('patient'));
    }

    // Tampilkan form edit pasien
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    // Update data pasien
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    // Hapus data pasien
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
