<?php

use Illuminate\Database\Seeder;

class ServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('servicios')->insert([
            ['nombre' => "Aire acondicionado"],
            ['nombre' => "Baños"],
            ['nombre' => "Calefacción"],
            ['nombre' => "Cocina"],
            ['nombre' => "Escenario"],
            ['nombre' => "Iluminación para fotografía"],
            ['nombre' => "Luz natural"],
            ['nombre' => "Mesas redondas"],
            ['nombre' => "Mesas de trabajo"],
            ['nombre' => "Muebles de calidad"],
            ['nombre' => "Pantalla"],
            ['nombre' => "Paredes libres"],
            ['nombre' => "Pizarra blanca"],
            ['nombre' => "Proyector"],
            ['nombre' => "Sillas adicionales"],
            ['nombre' => "Sistema de iluminación"],
            ['nombre' => "Sistema de sonido"],
            ['nombre' => "TV"],
            ['nombre' => "Vajilla"],
            ['nombre' => "Wifi"]
        ]);
    }
}
