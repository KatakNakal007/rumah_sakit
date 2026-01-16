<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorWithScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['name' => 'dr. Andi Wijaya', 'specialization' => 'Penyakit Dalam', 'phone' => '081234567890'],
            ['name' => 'dr. Rina Kartika', 'specialization' => 'Anak', 'phone' => '082345678901'],
            ['name' => 'dr. Budi Santoso', 'specialization' => 'Bedah', 'phone' => '083456789012'],
        ];

        foreach ($doctors as $data) {
            $doctor = Doctor::create($data);

            // Tambahkan jadwal praktik untuk setiap dokter
            $days = ['Senin', 'Rabu', 'Jumat'];
            foreach ($days as $day) {
                Schedule::create([
                    'doctor_id' => $doctor->id,
                    'day' => $day,
                    'start_time' => '08:00',
                    'end_time' => '12:00',
                ]);
            }
        }
    }
}
