<?php

use Illuminate\Database\Seeder;
use Freshwork\ChileanBundle\Rut;
use Faker\Factory as Faker;

class PersonasTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i < 20; $i++) {

            $edadAnios = 0;
            $edadMeses = $faker->numberBetween(1,204);
            if($edadMeses>11){
                $edadAnios =  floor($edadMeses/12);
            }

            $random_number = rand(1000000, 25000000);

            //We create a new RUT wihtout verification number (the second paramenter of Rut constructor)
            $rut = new Rut($random_number);

            //The fix method calculates the
            $rutNum = Rut::parse($rut->fix()->format())->number();
            $rutDv = Rut::parse($rut->fix()->format())->vn();

            //}


            \DB::table('AI_PERSONA')->insert(array(
                'PER_ACT'  => $faker->numberBetween(0,1),
                'PER_RUN' => $rutNum,
                'PER_DIG' => $rutDv,
                'PER_NOM' => $faker->firstName." ".$faker->firstName,
                'PER_PAT' => $faker->lastName,
                'PER_MAT' => $faker->lastName,
                'PER_NAC' => $faker->date('y-m-d'),
                'PER_ANI' => $edadAnios,
                'PER_MES' => $edadMeses,
                'PER_SEX' => $faker->numberBetween(1,2),
                'PER_COD_ENS' => $faker->numberBetween(1,8),
                'PER_COD_GRA' => $faker->numberBetween(1,8),
                'PER_GRA_LET' => $faker->randomElement(['A','B','C','D','E','F'])
            ));

        }
    }

}
