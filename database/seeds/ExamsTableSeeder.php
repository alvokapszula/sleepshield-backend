<?php

use Illuminate\Database\Seeder;
use App\Exam;

class ExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<30;$i++) {
            $newUser = Exam::create([
                'patient_id'     => $i % 13 + 1,
                'shield_id'      => $i % 5 + 1,
                'user_id'     => $i % 5 + 1,
                'begin'        => '2019-03-0'.($i % 3 + 1).' 0'.($i % 9 + 1).':00:00',
                'end'        => '2019-03-0'.($i % 3 + 1).' 1'.($i % 9 + 1).':00:00',
				'comments'	=> 'valami jó hoszú komment, hogy itt is legyen némi adat, hamár meg akarjuk nézni, hogy hogyan is fog kinézni a felületen ez az egész hóbelebanc.',
            ]);
        }
    }
}
