<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriasTableSeeder::class);
        $this->call(ServiciosTableSeeder::class);
        $this->call(tipoClienteTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EspacioTableSeeder::class);
    }
}
