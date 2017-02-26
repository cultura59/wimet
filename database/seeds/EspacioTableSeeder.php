<?php

use Illuminate\Database\Seeder;
use App\Espacio;
use App\Categoria;
use App\Price;

class EspacioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($var = 1; $var < 5; $var ++) 
        {
        	// En esta parte se crea el espacio de prueba con todos los datos
            $espacio = new Espacio();
            $espacio->user_id = 1;
            $espacio->name = "Espacio de prueba Wimet " . $var;
            $espacio->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse enim diam, vehicula eu pulvinar sed, aliquet id metus. Sed vel arcu arcu. Maecenas vitae consectetur orci, ut malesuada diam. Donec porta, dui sed laoreet pellentesque, lectus lectus sagittis quam, eu placerat massa neque nec massa. Cras porta, enim pulvinar tempus bibendum, urna felis rhoncus est, vel vehicula nibh enim at erat. Donec aliquet suscipit enim, sit amet mollis eros lobortis eu. Pellentesque nec metus lorem. Cras et lorem sed nulla pulvinar varius congue nec velit. Aliquam posuere, sem in laoreet suscipit, neque ante consequat risus, vitae rhoncus erat est vel ante.";
            $espacio->rule = "Integer mi purus, mattis nec mi quis, ullamcorper vulputate sem. Aenean arcu ipsum, sagittis non facilisis vehicula, molestie in libero. Donec eleifend erat ante, at condimentum enim lobortis non. Praesent id erat sed enim hendrerit auctor. Morbi eget pulvinar enim. Mauris in est vel risus aliquam mattis. Duis fringilla leo vitae neque feugiat luctus. In placerat libero eu ultrices maximus. Integer interdum ante in ultricies molestie. Sed condimentum volutpat nibh consectetur dignissim. Proin porttitor ultrices metus in ultricies. Vivamus vestibulum justo sed posuere posuere. Aliquam sagittis sem sit amet libero dictum, ut cursus dolor aliquet.";
            $espacio->politcancel = "Sed posuere egestas ipsum et dignissim. Nullam nec tempor diam. Sed tincidunt sed sem sit amet imperdiet. Duis tristique bibendum risus, eget ullamcorper nibh elementum quis. Ut aliquam leo eu enim tincidunt auctor. Etiam vitae scelerisque neque. Fusce imperdiet dapibus ipsum et vehicula. Aliquam tincidunt lacus sit amet nulla laoreet dictum. Nullam a congue lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam sodales sem sed eleifend ullamcorper. Vivamus at pulvinar dolor. Pellentesque eget velit commodo, imperdiet libero accumsan, scelerisque mi. Sed vitae metus eget magna feugiat maximus ac non lacus. Suspendisse quis lectus at nulla elementum mattis eu a turpis. Mauris pretium fringilla orci mollis tristique.";
            $espacio->quantyrooms = 2;
            $espacio->quantybathrooms = 1;
            $espacio->floor = 4;
            $espacio->surface = 34;
            $espacio->quanty = 12;
            $espacio->foot = 8;
            $espacio->seated = 4;
            $espacio->adress = "El salvador 5218";
            $espacio->city = "CABA";
            $espacio->state = "Buenos Aires";
            $espacio->country = "Argentina";
            $espacio->long = "58.4341036";
            $espacio->lat = "-34.5860955";
            $espacio->securitydeposit = 1200;
            $espacio->type = "comercial";
            $espacio->save();

            //En esta parte se asocian las primeras 3 categorias, servicios y tipo de espacio al espacio
        	$espacio->categorias()->sync([1, 2, 3]);
            $espacio->servicios()->sync([1, 2, 3]);
            $espacio->estilosEspacio()->sync([1, 2, 3, 4, 5]);
            $espacio->rules()->sync([1, 2, 3, 4, 5]);
            $espacio->characteristics()->sync([1, 2, 3, 4, 5]);
        	$espacio->access()->sync([1, 2, 3, 4, 5, 6, 7, 8]);
            $espacio->save();

            //Se asocia un nuevo precio para cada categoria
            DB::table('prices')->insert([
            	['price' => 250 + $var, 'espacio_id' => $espacio->id, 'categoria_id' => 1, 'minhours' => 4 + $var],
            	['price' => 180 + $var, 'espacio_id' => $espacio->id, 'categoria_id' => 2, 'minhours' => 5 + $var],
            	['price' => 460 + $var, 'espacio_id' => $espacio->id, 'categoria_id' => 3, 'minhours' => 6 + $var]
        	]);

            //Se crean imagenes para los espacios de prueba
            DB::table('images')->insert([
                ['name' => 'fotosespacios/m9aR2piW_wimet_inspiring_venue_startup.jpg', 'espacio_id' => $espacio->id]
            ]);
        }
    }
}
