<?php

use Illuminate\Database\Seeder;

class AccessibilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('accessibilities')->insert([
            ['nombre' => "Cantidad de ambientes (sólo los disponibles para el uso de invitados)"],
            ['nombre' => "Cantidad de baños"],
            ['nombre' => "Piso (si corresponde)"],
            ['nombre' => "Superficie estimada del espacio utilizable (m2)"]
        ]);
    }
}
