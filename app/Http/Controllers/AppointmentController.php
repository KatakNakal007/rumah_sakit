<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Schedule;
use Illuminate\Http\Request;

use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date');
        $status = $request->input('status');
        $doctorId = $request->input('doctor_id');

        $appointments = Appointment::with(['patient', 'doctor', 'schedule', 'queue'])
            ->when($date, fn($query) => $query->whereDate('appointment_date', $date))
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($doctorId, fn($query) => $query->where('doctor_id', $doctorId))
            // ->get();
            ->paginate(10)
            ->withQueryString();

        $doctors = Doctor::orderBy('name')->get();

        $today = Carbon::today()->toDateString();

        $todayAppointments = Appointment::with(['patient', 'doctor', 'schedule'])
            ->whereDate('appointment_date', $today)
            ->orderBy('schedule_id')
            ->get();

        $antrianPerDokter = Appointment::select('doctor_id', DB::raw('count(*) as total'))
            ->whereDate('appointment_date', $today)
            ->groupBy('doctor_id')
            ->with('doctor')
            ->get();

        $dailyCounts = Appointment::selectRaw('DATE(appointment_date) as date, COUNT(*) as total')
            ->whereBetween('appointment_date', [Carbon::today()->subDays(6), Carbon::today()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // $perDokterChart = Appointment::select('doctor_id', DB::raw('count(*) as total'))
        //     ->whereDate('appointment_date', Carbon::today())
        //     ->groupBy('doctor_id')
        //     ->with('doctor')
        //     ->get();

        $perDokter = Appointment::select('doctor_id', DB::raw('count(*) as total'))
            ->whereDate('appointment_date', Carbon::today())
            ->groupBy('doctor_id')
            ->with('doctor')
            ->get();

        $statusCounts = Appointment::select('status', DB::raw('count(*) as total'))
            ->whereDate('appointment_date', Carbon::today())
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = $perDokter->pluck('doctor.name')->toArray();
        $data = $perDokter->pluck('total')->toArray();

        return view('appointments.index', compact(
            'appointments',
            'date',
            'status',
            'doctorId',
            'doctors',
            'todayAppointments',
            'antrianPerDokter',
            'dailyCounts',
            // 'perDokterChart',
            'labels',
            'data',
            'perDokter',
            'statusCounts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);
        $dayName = Carbon::parse($request->appointment_date)->locale('id')->dayName;

        if (strtolower($dayName) !== strtolower($schedule->day)) {
            return back()->withErrors(['appointment_date' => 'Tanggal tidak sesuai dengan hari praktik dokter.']);
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:menunggu',
        ]);

        // Simpan appointment baru
        Appointment::create($request->all());


        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dibuat');
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
    public function edit(Appointment $appointment)
    {
        $patients = \App\Models\Patient::all();
        $doctors = \App\Models\Doctor::with('schedules')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // // $request->validate([
        // //     'patient_id' => 'required|exists:patients,id',
        // //     'doctor_id' => 'required|exists:doctors,id',
        // //     'schedule_id' => 'required|exists:schedules,id',
        // //     'appointment_date' => 'required|date',
        // //     'status' => 'required|in:menunggu,diproses,selesai,batal',
        // // ]);

        // // $appointment->update($request->all());

        // $validated = $request->validate([
        //     'status' => 'required|in:menunggu,diproses,selesai,batal',
        // ]);

        // $appointment->update(['status' => $validated['status']]);

        // return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil diperbarui.');

        // Jika hanya status yang dikirim (dari dropdown di index)
        if ($request->has('status') && $request->keys() === ['_token', '_method', 'status']) {
            $request->validate([
                'status' => 'required|in:menunggu,dipanggil,selesai',
            ]);

            $appointment->update(['status' => $request->status]);

            return redirect()->route('appointments.index')->with('success', 'Status janji temu diperbarui.');
        }

        // Jika update dari halaman edit (semua field)
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:menunggu',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dihapus.');
    }

    public function exportPdf(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'schedule']);

        $html = view('appointments.pdf', compact('appointment'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="janji-temu-' . $appointment->id . '.pdf"');
    }

    public function printToday()
    {
        $today = Carbon::today()->toDateString();

        $appointments = \App\Models\Appointment::with(['patient', 'doctor', 'schedule'])
            ->whereDate('appointment_date', $today)
            ->orderBy('schedule_id')
            ->get();

        $html = view('appointments.print_today', compact('appointments', 'today'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="antrian-' . Carbon::today()->format('Ymd') . '.pdf"');
    }


    // public function exportChartImage(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|string'
    //     ]);

    //     $imageData = $request->image;

    //     $html = view('appointments.chart_image_pdf', compact('imageData'))->render();

    //     $dompdf = new Dompdf();
    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();

    //     return response($dompdf->output())
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'attachment; filename="grafik-janji-temu.pdf"');
    // }

    public function exportCombinedChart(Request $request)
    {
        $request->validate([
            'grafikDokter' => 'required|string',
            'grafikStatus' => 'required|string',
        ]);

        $img1 = $request->grafikDokter;
        $img2 = $request->grafikStatus;

        $html = view('appointments.combined_chart_pdf', compact('img1', 'img2'))->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="grafik-gabungan.pdf"');
    }

    public function dashboard()
    {
        $totalAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $statusCounts = Appointment::select('status', DB::raw('count(*) as total'))
            ->whereDate('appointment_date', Carbon::today())
            ->groupBy('status')
            ->pluck('total', 'status');

        $perDokter = Appointment::select('doctor_id', DB::raw('count(*) as total'))
            ->whereDate('appointment_date', Carbon::today())
            ->groupBy('doctor_id')
            ->with('doctor')
            ->get();

        return view('admin.dashboard', compact('totalAppointments', 'statusCounts', 'perDokter'));
    }
}
