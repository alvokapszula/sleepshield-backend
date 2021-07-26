<?php

use Illuminate\Database\Seeder;
use App\Patient;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<14;$i++) {
            $newUser = Patient::create([
                'firstname'     => 'First'.$i,
                'lastname'      => 'Last'.$i,
                'birthdate'     => '198'.($i % 9 + 1).'-0'.($i % 9 + 1).'-2'.($i % 9 + 1),
                'gender'        => ($i % 2) + 1,
                'height'        => 130 + $i*7,
                'weight'        => 50 + $i*9,
                'comments'      => 'Patient'.$i.' megjegyzések.',
            ]);
        }

    }
}
