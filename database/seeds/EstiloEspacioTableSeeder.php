<?php

use Illuminate\Database\Seeder;

class EstiloEspacioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('estilo_espacios')->insert([
    		['nombre' => "Bar / Café / Restaurant"],
            ['nombre' => "Casa"],
            ['nombre' => "Centro cultural / Museo"],
            ['nombre' => "Club"],
            ['nombre' => "Departamento"],
            ['nombre' => "Depósito / Galpón"],
            ['nombre' => "Estancia / Chacra / Campo"],
            ['nombre' => "Estudio"],
            ['nombre' => "Estudio de fotografía"],
            ['nombre' => "Galería"],
            ['nombre' => "Jardín / Parque"],
            ['nombre' => "Local con vidriera"],
            ['nombre' => "Loft"],
            ['nombre' => "Mansión"],
            ['nombre' => "Oficina / Coworking"],
            ['nombre' => "Parking / Garage"],
            ['nombre' => "Rooftop"],
            ['nombre' => "Terraza / Patio"]
		]);
    }
}
