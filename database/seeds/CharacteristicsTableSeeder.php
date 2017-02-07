<?php

use Illuminate\Database\Seeder;

class CharacteristicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('characteristics')->insert([
            ['nombre' => "Accesorios"],
            ['nombre' => "Acústico / Insonoro"],
            ['nombre' => "Amueblado"],
            ['nombre' => "Arte"],
            ['nombre' => "Baño moderno"],
            ['nombre' => "Bar"],
            ['nombre' => "Biblioteca"],
            ['nombre' => "Chimenea"],
            ['nombre' => "Columnas"],
            ['nombre' => "Cocina abierta"],
            ['nombre' => "Comedor"],
            ['nombre' => "Deck / patio"],
            ['nombre' => "Espacio Blanco"],
            ['nombre' => "Frente de local"],
            ['nombre' => "Hormigón"],
            ['nombre' => "Jardín"],
            ['nombre' => "Ladrillo a la vista"],
            ['nombre' => "Multi-nivel"],
            ['nombre' => "Piano"],
            ['nombre' => "Pisos de madera"],
            ['nombre' => "Plantas"],
            ['nombre' => "Sala de proyección"],
            ['nombre' => "Sala de reunión"],
            ['nombre' => "Techo"],
            ['nombre' => "Techo alto"],
            ['nombre' => "Tubos expuestos"],
            ['nombre' => "Vacío"],
            ['nombre' => "Ventanas grandes"],
            ['nombre' => "Vigas de madera"],
            ['nombre' => "Vista"]
        ]);
    }
}
