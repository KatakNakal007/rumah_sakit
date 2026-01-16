<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queues = Queue::with(['appointment.patient', 'appointment.doctor', 'appointment.schedule'])
            ->orderBy('queue_number')
            ->get();

        return view('queues.index', compact('queues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $allAppointments = Appointment::with(['patient', 'doctor'])->get(); // ambil semua
        $availableAppointments = Appointment::whereDoesntHave('queue')->with(['patient', 'doctor'])->get(); // untuk dropdown
        $selectedAppointmentId = $request->appointment_id;
        $nextQueueNumber = null;

        if ($selectedAppointmentId) {
            $appointment = Appointment::find($selectedAppointmentId);

            if ($appointment) {
                $tanggal = \Carbon\Carbon::parse($appointment->appointment_date)->toDateString();

                // $maxQueue = Queue::whereHas('appointment', function ($query) use ($appointment) {
                //     $query->where('doctor_id', $appointment->doctor_id)
                //         ->whereDate('appointment_date', $appointment->appointment_date);
                // })->max('queue_number');

                $maxQueue = Queue::max('queue_number');

                $nextQueueNumber = $maxQueue ? $maxQueue + 1 : 1;

                Log::info("Hitung max queue → dokter={$appointment->doctor_id}, tanggal={$tanggal}, hasil={$maxQueue}");
                Log::info("Cek appointment → ID={$appointment->id}, dokter={$appointment->doctor_id}, tanggal={$tanggal}");

                $queues = Queue::with('appointment')->get();
                foreach ($queues as $q) {
                    Log::info("Queue ID={$q->id}, appointment_id={$q->appointment_id}, dokter={$q->appointment->doctor_id}, tanggal={$q->appointment->appointment_date}");
                }
            }
        }

        return view('queues.create', [
            'appointments' => $availableAppointments,
            'selectedAppointmentId' => $selectedAppointmentId,
            'nextQueueNumber' => $nextQueueNumber,
            'appointment' => $appointment ?? null, // tambahkan ini
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|unique:queues,appointment_id',
            'queue_number' => 'required|min:1',
        ], [
            'appointment_id.required' => 'Silakan pilih janji temu terlebih dahulu.',
            'appointment_id.unique' => 'Janji temu ini sudah masuk dalam antrian.',
            'queue_number.required' => 'Nomor antrian wajib diisi.',
            'queue_number.min' => 'Nomor antrian minimal adalah 1.',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $tanggal = \Carbon\Carbon::parse($appointment->appointment_date)->toDateString();

        // cek duplikat nomor untuk dokter + tanggal
        $exists = Queue::whereHas('appointment', function ($query) use ($appointment, $tanggal) {
            $query->where('doctor_id', $appointment->doctor_id)
                ->whereDate('appointment_date', $tanggal);
        })->where('queue_number', $request->queue_number)->exists();

        if ($exists) {
            return back()->withErrors(['queue_number' => 'Nomor ini sudah dipakai untuk dokter & tanggal tersebut.'])->withInput();
        }

        Queue::create([
            'appointment_id' => $request->appointment_id,
            'queue_number' => $request->queue_number,
            'called' => 0,
        ]);

        return redirect()->route('queues.index')->with('success', 'Antrian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function call($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->called = 1;
        $queue->save();

        return redirect()->route('queues.index')->with('success', 'Pasien telah dipanggil.');
    }

    public function finish($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->called = 2;
        $queue->save();

        // // update status appointment
        // $appointment = $queue->appointment;
        // $appointment->status = 'Selesai Diperiksa';
        // $appointment->save();


        return redirect()->route('queues.index')->with('success', 'Pasien telah selesai diperiksa.');
    }
}
