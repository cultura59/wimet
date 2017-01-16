<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$reuniones = new Categoria();
    	$reuniones->name = "Reuniones";
    	$reuniones->save();
    	$reuniones->subCategory()->saveMany([
		    new App\Subcategory(['name' => 'Workshops']),
		    new App\Subcategory(['name' => 'Presentaciones']),
		    new App\Subcategory(['name' => 'Jornadas de Trabajo/Offsites']),
		]);

		$eventos = new Categoria();
    	$eventos->name = "Eventos";
    	$eventos->save();
    	$eventos->subCategory()->saveMany([
		    new App\Subcategory(['name' => 'Corporativos']),
		    new App\Subcategory(['name' => 'Sociales']),
		    new App\Subcategory(['name' => 'Acciones /Promociones']),
		]);

		$producciones = new Categoria();
    	$producciones->name = "Producciones";
    	$producciones->save();
    	$producciones->subCategory()->saveMany([
		    new App\Subcategory(['name' => 'Fotográficas']),
		    new App\Subcategory(['name' => 'Filmaciones']),
		    new App\Subcategory(['name' => 'Escénicas (musicales y teatrales)']),
		]);

		$popUps = new Categoria();
    	$popUps->name = "Pop-ups";
    	$popUps->save();
    	$popUps->subCategory()->saveMany([
		    new App\Subcategory(['name' => 'Store']),
		    new App\Subcategory(['name' => 'Cursos']),
		    new App\Subcategory(['name' => 'Exhibiciones & Cenas']),
		]);
    }
}
