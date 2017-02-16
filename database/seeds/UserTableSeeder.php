<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'firstname'				=> 'Ejemplo',
        	'lastname'				=> 'Usuario',
        	'email'					=> 'soporte@wimet.co',
        	'phone'					=> 1534151780,
        	'password'				=> bcrypt('wimet'),
        	'businessName'			=> 'Wimet',
        	'industry'				=> 'E-commerce',
        	'personaldescription'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim diam, vehicula eu pulvinar sed, aliquet id metus. Sed vel arcu arcu. Maecenas vitae consectetur orci, ut malesuada diam. Donec porta, dui sed laoreet pellentesque, lectus lectus sagittis quam, eu placerat massa neque nec massa. Cras porta, enim pulvinar tempus bibendum, urna felis rhoncus est, vel vehicula nibh enim at erat. Donec aliquet suscipit enim, sit amet mollis eros lobortis eu. Pellentesque nec metus lorem. Cras et lorem sed nulla pulvinar varius congue nec velit. Aliquam posuere, sem in laoreet suscipit, neque ante consequat risus, vitae rhoncus erat est vel ante.',
        	'tipo_clientes_id' => 1
    	]);
    }
}
