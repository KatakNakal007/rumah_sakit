<?php

namespace Database\Seeders;

use App\Models\Patient;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            'name' => 'Test Pasien A',
            'gender' => 'L',
            'birth_date' => '1990-01-01',
            'address' => 'Jl. Uji Filter No. 1',
            'phone' => '081111111111',
        ]);

        Patient::create([
            'name' => 'Test Pasien B',
            'gender' => 'P',
            'birth_date' => '1995-05-05',
            'address' => 'Jl. Uji Filter No. 2',
            'phone' => '082222222222',
        ]);

        Patient::create([
            'name' => 'Test Pasien C',
            'gender' => 'L',
            'birth_date' => '2000-12-31',
            'address' => 'Jl. Uji Filter No. 3',
            'phone' => '083333333333',
        ]);

        $faker = Faker::create('id_ID');
        foreach (range(1, 47) as $i) {
            Patient::create([
                'name' => $faker->name,
                'gender' => $faker->randomElement(['L', 'P']),
                'birth_date' => $faker->date('Y-m-d', '2005-12-31'),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
            ]);
        }
    }
}
