<?php

use Illuminate\Database\Seeder;

class AccessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('accesses')->insert([
            ['nombre' => "Acceso para discapacitados"],
            ['nombre' => "Acceso para entregas"],
            ['nombre' => "Escaleras"],
            ['nombre' => "Elevador"],
            ['nombre' => "Estacionamiento cercano"],
            ['nombre' => "Estacionamiento propio"],
            ['nombre' => "Montacargas"],
            ['nombre' => "Planta baja"],
            ['nombre' => "Otro"]
        ]);
    }
}
