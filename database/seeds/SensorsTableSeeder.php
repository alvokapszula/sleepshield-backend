<?php

use Illuminate\Database\Seeder;
use App\Sensor;
use App\Shield;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $shields = Shield::all();

        $sensors = [
            [ "Pulzus", "pulse", 55, 70, "/perc"],
            [ "Légzésszám", "resp", 20, 40, "/perc"],
            [ "Testhőmérséklet", "temp", 36, 37.3, "°C"],
            [ "Izom rángás", "muscle", 0, 0, "/perc"],
            [ "Oxigén szint", "spo2", 96, 100, "%"],
            [ "Pozíció", "bodypos", 0, 0, null],
            [ "Horkolás", "snore", 0, 0, "/perc"],
            [ "Galvanic?", "galvanic", 0, 100, "NaN"],
        ];

        $descriptions = [
            $sensors[0][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[1][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[2][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[3][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[4][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[5][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[6][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
            $sensors[7][0].' leírása nagyon hosszú mert ez sok szöveg és kell valami, hogy legyen itt különben nem látszik a képen hogyan fog kinézni és nem is tudom mit kéne még ide gépelni de úgyis rossz lesz mert nagyon gyorsan csinálom annyira unoiom.',
        ];

        foreach ($shields as $shield) {
            for ($i=0;$i<8;$i++) {
                $sensor = Sensor::create([
                    'name'     => $sensors[$i][0],
                    'uid'     => $sensors[$i][1],
                    'shield_id' => $shield->id,
                    'normlow'   => $sensors[$i][2],
                    'normhigh'   => $sensors[$i][3],
                    'unit'  => $sensors[$i][4],
                    'description' => $descriptions[$i],
                ]);
            }
        }

    }
}
