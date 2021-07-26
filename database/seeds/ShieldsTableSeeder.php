<?php

use Illuminate\Database\Seeder;
use App\Shield;

class ShieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<6;$i++) {
            $newUser = Shield::create([
                'uid'     => 'dev'.$i,
                'name'     => $i.". kapszula",
            ]);
        }
    }
}
