<?php

use Illuminate\Database\Seeder;
use Freshwork\ChileanBundle\Rut;
use Faker\Factory as Faker;

class PredictivosTableSeeder extends Seeder
{

    public function run()
	{
		$comunas = ["10208","10209","10210","10301","10302","10303","10304","10305","10306","10307","10401","10402","10403","10404","11101","11102","11201","11202","11203","11301","11302","11303","11401","11402","12101","12102","12103","12104","12201","12202","12301","12302","12303","12401","12402","13101","13102","13103","13104","13105","13106","13107","13108","13109","13110","13111","13112","13113","13114","13115","13116","13117","13118","13119","13120","13121","13122","13123","13124","13125","13126","13127","13128","13129","13130","13131","13132","13201","13202","13203","13301","13302","13303","13401","13402","13403","13404","13501","13502","13503","13504","13505","13601","13602","13603","13604","13605","05101","15101","15102","15201","15202","01101","01107","01401","01402","01403","01404","01405","02101","02102","02103","02104","02201","02202","02203","02301","02302","03101","03102","03103","03201","03202","03301","03302","03303","03304","04101","04102","04103","04104","04105","04106","04201","04202","04203","04204","04301","04302","04303","04304","04305","05102","05103","05104","05105","05801","05107","05804","05109","05201","05301","05302","05303","05304","05401","05402","05403","05404","05405","05501","05502","05503","05504","05802","05506","05803","05601","05602","05603","05604","05605","05606","05701","05702","05703","05704","05705","05706","06101","06102","06103","06104","06105","06106","06107","06108","06109","06110","06111","06112","06113","06114","06115","06116","06117","06201","06202","06203","06204","06205","06206","06301","06302","06303","06304","06305","06306","06307","06308","06309","06310","07101","07102","07103","07104","07105","07106","07107","07108","07109","07110","07201","07202","07203","07301","07302","07303","07304","07305","07306","07307","07308","07309","07401","07402","07403","07404","07405","07406","07407","07408","08101","08102","08103","08104","08105","08106","08107","08108","08109","08110","08111","08112","08201","08202","08203","08204","08205","08206","08207","08301","08302","08303","08304","08305","08306","08307","08308","08309","08310","08311","08312","08313","08314","08401","08402","08403","08404","08405","08406","08407","08408","08409","08410","08411","08412","08413","08414","08415","08416","08417","08418","08419","08420","08421","09101","09102","09103","09104","09105","09106","09107","09108","09109","09110","09111","09112","09113","09114","09115","09116","09117","09118","09119","09120","09121","09201","09202","09203","09204","09205","09206","09207","09208","09209","09210","09211","14101","14102","14103","14104","14105","14106","14107","14108","14201","14202","14203","14204","10101","10102","10103","10104","10105","10106","10107","10108","10109","10201","10202","10203","10204","10205","10206","10207"];
        
        
        
        
        
        
        $faker = Faker::create();
        
        
        
        
        for ($i=0; $i < 40; $i++) {

            $edadAnios = 0;
            $edadMeses = $faker->numberBetween(1,204);
           if($edadMeses>11){
            $edadAnios =  floor($edadMeses/12);
           }
           //echo $edadAnios." --  \n";


            //for($i = 0; $i < 2; $i++)
            //{
                //generate random number between 1.000.000 and 25.000.000
                $random_number = rand(1000000, 25000000);

                //We create a new RUT wihtout verification number (the second paramenter of Rut constructor)
                $rut = new Rut($random_number);

                //The fix method calculates the
                $rutNum = Rut::parse($rut->fix()->format())->number();
                $rutDv = Rut::parse($rut->fix()->format())->vn();

            //}


            \DB::table('AI_PREDICTIVO')->insert(array(
                'RUN' => $rutNum,
                'DV_RUN'  => $rutDv,
                'PERIODO' => $faker-> date('Y-m'),
                'SCORE' => $faker->numberBetween(1,100),
                'NOMBRES' => $faker->firstName." ".$faker->firstName,
                'AP_PATERNO' => $faker->lastName,
                'AP_MATERNO' => $faker->lastName,
                'EDAD_AGNO' => $edadAnios,
                'EDAD_MESES' => $edadMeses,
                'SEXO' => $faker->numberBetween(1,2),
                'INFO_NOM_CONTACTO_1' => $faker->firstName,
                'INFO_APP_CONTACTO_1' => $faker->lastName,
                'INFO_APM_CONTACTO_1' => $faker->lastName,
                'INFO_NUM_CONTACTO_1' => "+569".$faker->numberBetween(1000,9999).$faker->numberBetween(1000,9999),
                'INFO_NOM_CONTACTO_2' => $faker->firstName,
                'INFO_APP_CONTACTO_2' => $faker->lastName,
                'INFO_APM_CONTACTO_2' => $faker->lastName,
                'INFO_NUM_CONTACTO_2' => "+569".$faker->numberBetween(1000,9999).$faker->numberBetween(1000,9999),
                'DIR_CALLE_1' => $faker->sentence($nbWords = 1, $variableNbWords = true),
                'DIR_NUM_1' => $faker->numberBetween(100,9999),
                'DIR_COM_1' => $faker->randomElement($comunas),
                'DIR_REG_1' => $faker->numberBetween(1,16),
                'DIR_CALLE_2' => $faker->sentence($nbWords = 1, $variableNbWords = true) ,
                'DIR_NUM_2' => $faker->numberBetween(100,9999),
                'DIR_COM_2' => $faker->randomElement($comunas),
                'DIR_REG_2' => $faker->numberBetween(1,16),
                'DIR_CALLE_3' => $faker->sentence($nbWords = 1, $variableNbWords = true),
                'DIR_NUM_3' => $faker->numberBetween(100,9999),
                'DIR_COM_3' => $faker->randomElement($comunas),
                'DIR_REG_3' => $faker->numberBetween(1,16),
                'RBD' => $faker->numberBetween(1000,9999),
                'NOMBRE_RBD' => $faker->company,
                'COD_ENS' => $faker->numberBetween(1,8),
                'COD_GRA' => $faker->numberBetween(1,8),
                'LET_CUR' => $faker->randomElement(['A','B','C','D','E','F']),
                'VAR_FLAG_1' => $faker->numberBetween(0,1),
                'VAR_FLAG_2' => $faker->numberBetween(0,1),
                'VAR_FLAG_3' => $faker->numberBetween(0,1),
                'VAR_FLAG_4' => $faker->numberBetween(0,1),
                'VAR_FLAG_5' => $faker->numberBetween(0,1),
                'VAR_FLAG_6' => $faker->numberBetween(0,1)
            ));

        }
    }

}
