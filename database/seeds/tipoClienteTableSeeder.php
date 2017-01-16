<?php

use Illuminate\Database\Seeder;

class tipoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('tipo_clientes')->insert([
    		['nombre' => 'Cliente final'],
    		['nombre' => 'Particular'],
    		['nombre' => 'Agencia']
		]);
    }
}
