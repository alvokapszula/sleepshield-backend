<?php

use Illuminate\Database\Seeder;
use App\ExamType;

class ExamTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            ExamType::create([
                'name'     => 'Alvászavar',
                'description' => 'Alvászavar leírása nagyon hosszú mert ez sok szöveg és kell valami,
                 hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit
                  kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.'
            ]);

            ExamType::create([
                'name'     => 'Horkolás',
                'description' => 'Alvászavar leírása nagyon hosszú mert ez sok szöveg és kell valami,
                 hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit
                  kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.'
            ]);

            ExamType::create([
                'name'     => 'Meditáció',
                'description' => 'Alvászavar leírása nagyon hosszú mert ez sok szöveg és kell valami,
                 hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit
                  kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.'
            ]);
    }
}
