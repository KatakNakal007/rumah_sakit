<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schedules = Schedule::with('doctor')
            ->when($request->doctor_id, fn($q) => $q->where('doctor_id', $request->doctor_id))
            ->when($request->day, fn($q) => $q->where('day', $request->day))
            ->paginate(10);

        $doctors = Doctor::all();

        return view('schedules.index', compact('schedules', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schedule = Schedule::with('doctor')->findOrFail($id);

        // $appointments = Appointment::where('doctor_id', $schedule->doctor_id)
        //     // ->where('day', $schedule->day) // jika ada kolom 'day' di appointment
        //     ->whereTime('appointment_time', '>=', $schedule->start_time)
        //     ->whereTime('appointment_time', '<=', $schedule->end_time)
        //     ->get();
        $appointments = Appointment::where('schedule_id', $schedule->id)->get();

        return view('schedules.show', compact('schedule', 'appointments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getByDoctor($doctorId)
    {
        $schedules = Schedule::where('doctor_id', $doctorId)->get();

        return response()->json($schedules);
    }
}
