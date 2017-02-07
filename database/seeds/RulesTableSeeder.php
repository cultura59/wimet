<?php

use Illuminate\Database\Seeder;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('rules')->insert([
            ['nombre' => "No fumar"],
            ['nombre' => "No fumar en ningún ambiente"],
            ['nombre' => "No hay música"],
            ['nombre' => "No hay música fuerte / baile"],
            ['nombre' => "No hay fiestas nocturnas"],
            ['nombre' => "No hay venta de entradas"],
            ['nombre' => "No es “puertas abiertas"],
            ['nombre' => "No catering externo"],
            ['nombre' => "No se puede cocinar"],
            ['nombre' => "Sin alcohol"],
            ['nombre' => "Sin venta de alcohol"],
            ['nombre' => "No adolescentes (10-18)"],
            ['nombre' => "No menores de 21 años"],
            ['nombre' => "No niños (0-10)"],
            ['nombre' => "No se permiten mascotas"]
        ]);
    }
}
