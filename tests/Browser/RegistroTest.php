<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Institucion;
use App\InstitucionRegion;

use DB;

class RegistroTest extends DuskTestCase
{
    public function testFormularioRegistroPaso1()
    {
        //return true;
        $rut = '23575060-0';

        DB::connection()->getPdo()->beginTransaction();

        $institucion = Institucion::where('rut',$rut)->get();
        foreach ($institucion as $key => $value) {
            DB::table('institucion_region')->where('folio', $value->folio)->delete();
            DB::table('directorio')->where('folio', $value->folio)->delete(); 
            DB::table('institucion')->where('folio', $value->folio)->delete();
        }

        
        DB::connection()->getPdo()->commit();

        $this->browse(function (Browser $browser) use ($rut) {
            $browser->visit('/adm/sistema/institucion/crear1')
            ->assertSourceHas('<option value="13129">SAN JOAQUIN</option>')
            ->type('nombre', 'institucion prueba')
            ->type('rut', $rut)
            ->radio('ley', '1')
            ->type('finestatutario','Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas Letraset, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.')
            ->select('id_beneficiario', '1')
            ->select('id_categoria_servicio', '3')
            ->type('personalidadjuridica', 'Mauris vitae iaculis enim. Vestibulum nulla odio, ullamcorper et arcu at, maximus ultricies urna. Quisque semper dignissim iaculis. In mauris enim, pharetra et nibh sit amet, suscipit placerat nisl. ')
            ->type('otorgamientopersjuridica', '2017-03-25')
            ->click('#IDareaespecializacion')
            ->type('areaespecializacion', 'Vestibulum iaculis iaculis feugiat. Praesent lobortis ultrices mauris sodales tempus. Nam eleifend ligula et convallis hendrerit. Curabitur nulla velit, placerat quis magna ut, ultrices maximus dolor. Nam semper enim ut tortor rhoncus commodo. Integer pharetra mi id nisi bibendum cursus. Integer dignissim ac mauris ac ultrices. Quisque mi felis, scelerisque nec dapibus sit amet, varius sit amet nisi. In id dapibus massa. Aenean et nunc in neque commodo tincidunt. Cras eleifend ullamcorper vulputate. Suspendisse posuere laoreet velit, sed iaculis nibh imperdiet ac. Phasellus id est ut nisi eleifend tincidunt.')
            ->type('link', 'http://www.mideplan.cl')
            ->check('region[13]')
            ->check('region[5]')
            ->type('calle', 'Catedral')
            ->type('numero', '1234')
            ->select('reg_id', '13')
            ->waitFor('#com_id')
            ->select('#com_id', '13101')
            ->type('fono', '123456789')
            ->type('email', 'correo@institucion.cl')
            ->press('Guardar y continuar con el paso 2')
            ->assertPathIs('/adm/sistema/institucion/crear2');
        });    

    }

    public function testFormularioRegistroValidaRUT()
    {
        return true;
        $this->browse(function (Browser $browser)  {
            $browser->visit('/adm/sistema/institucion/crear1')
            ->assertSourceHas('<option value="13129">SAN JOAQUIN</option>')
            ->type('nombre', 'institucion prueba')
            ->type('rut', "23545487-5")            
            ->radio('ley', '1')
            ->type('finestatutario','Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500')
            ->select('id_beneficiario', '1')
            ->select('id_categoria_servicio', '3')
            ->type('personalidadjuridica', 'Mauris vitae iaculis enim. Vestibulum nulla odio, ullamcorper et arcu at, maximus ultricies urna. Quisque semper dignissim iaculis. ')
            ->type('otorgamientopersjuridica', '2017-03-25')
            ->click('#IDareaespecializacion')
            ->type('areaespecializacion', 'Vestibulum iaculis iaculis feugiat. Praesent lobortis ultrices mauris sodales tempus. Nam eleifend ligula et convallis hendrerit.')
            ->type('link', 'http://www.mideplan.cl')
            ->check('region[13]')
            ->check('region[5]')
            ->type('calle', 'Catedral')
            ->type('numero', '1234')
            ->select('reg_id', '13')
            ->waitFor('#com_id')
            ->select('#com_id', '13101')
            ->type('fono', '123456789')
            ->type('email', 'correo@institucion.cl')
            ->press('Guardar y continuar con el paso 2')
            ->waitFor('#modalMsj')
            ->whenAvailable('#modalMsj', function ($modal) 
            {
                $modal->assertSee('RUN ingresado no es')
                      ->press('Aceptar');
            })            
            ->assertPathIsNot('/adm/sistema/institucion/crear2');
        }); 
    }
    
    public function testFormularioRegistroPaso2()
    {
        //obtiene el folio del run de prueba
        $rut = '23575060-0';
        $institucion = Institucion::where('rut',$rut)->first();
        \Session::put('session_folio', $institucion->folio);

        $this->browse(function (Browser $browser) use ($institucion) {
            $browser->visit('/adm/sistema/institucion/crear2')
            ->assertSourceHas('<tbody><tr class="odd">')
            ->waitFor('.dataTables_empty')
            ->press('#btnAddDirectorio')
            ->waitFor('#frmAddDirectorio')
            ->whenAvailable('#frmAddDirectorio', function ($modal) 
            {
                $modal->type('rut','1-9')
                      ->type('nombre', 'Profesional 1')
                      ->type('email', 'profesional1@institucion.cl')
                      ->type('telefono', '11239')
                      ->type('celular', '456789')                      
                      ->select('cargo', '1')                      
                      ->press('Guardar');                     
            })
            ->pause(2000)
            ->waitFor('#btnMsjConfirm')
            ->press('#btnMsjConfirm')
            ->waitFor('.table tbody .odd')
            ->waitFor('#btnAddDirectorio') 
            ->press('#btnAddDirectorio')                        
            ->waitFor('#frmAddDirectorio')
            ->whenAvailable('#frmAddDirectorio', function ($modal) 
            {
                $modal->type('rut','1-9')
                      ->type('nombre', 'Profesional 1')
                      ->type('email', 'profesional1@institucion.cl')
                      ->type('telefono', '11239458')
                      ->type('celular', '456789871')                      
                      ->select('cargo', '2')                      
                      ->press('Guardar');  
            })
            ->pause(2000)
            ->waitFor('#btnMsjConfirm')
            ->press('#btnMsjConfirm')
            ->waitFor('.table tbody .odd')
            ->waitFor('#btnAddDirectorio') 
            ->press('#btnAddDirectorio')                        
            ->waitFor('#frmAddDirectorio')
            ->whenAvailable('#frmAddDirectorio', function ($modal) 
            {
                $modal->type('rut','3-5')
                      ->type('nombre', 'Profesional 3')
                      ->type('email', 'profesional3@institucion.cl')
                      ->type('telefono', '11239458')
                      ->type('celular', '456789871')                      
                      ->select('cargo', '3')                      
                      ->press('Guardar');  
            })
            ->pause(2000)
            ->waitFor('#btnMsjConfirm')
            ->press('#btnMsjConfirm')
            ->waitFor('.table tbody .odd')
            ->waitFor('#btnAddDirectorio') 
            ->press('#btnAddDirectorio')                        
            ->waitFor('#frmAddDirectorio')
            ->whenAvailable('#frmAddDirectorio', function ($modal) 
            {
                $modal->type('rut','4-3')
                      ->type('nombre', 'Profesional 4')
                      ->type('email', 'profesional4@institucion.cl')
                      ->type('telefono', '11239458')
                      ->type('celular', '456789871')                      
                      ->select('cargo', '4')
                      ->press('Guardar');  
            })
            ->pause(2000)
            ->waitFor('#btnMsjConfirm')
            ->press('#btnMsjConfirm')
            ->waitFor('.table tbody .odd')
            ->waitFor('#btnAddDirectorio') 
            ->press('#btnAddDirectorio')                        
            ->waitFor('#frmAddDirectorio')
            ->whenAvailable('#frmAddDirectorio', function ($modal) 
            {
                $modal->type('rut','5-1')
                      ->type('nombre', 'Profesional 5')
                      ->type('email', 'profesional5@institucion.cl')
                      ->type('telefono', '11239458')
                      ->type('celular', '456789871')                      
                      ->select('cargo', '4')
                      ->press('Guardar');  
            })
            ->pause(2000)
            ->waitFor('#btnMsjConfirm')
            ->press('#btnMsjConfirm')
            ->waitFor('.table tbody .odd')
            ->waitFor('#btnAddDirectorio') 
            ->press('#btnAddDirectorio')                        
            ->waitFor('#frmAddDirectorio')
            ->whenAvailable('#frmAddDirectorio', function ($modal) 
            {
                $modal->type('rut','6-k')
                      ->type('nombre', 'Profesional 6')
                      ->type('email', 'profesional6@institucion.cl')
                      ->type('telefono', '11239458')
                      ->type('celular', '456789871')                      
                      ->select('cargo', '4')
                      ->press('Guardar');  
            })
            ->pause(2000)
            ->waitFor('#btnMsjConfirm')
            ->press('#btnMsjConfirm')
            ->waitFor('.table tbody .odd')
            ->waitFor('#btnFinalizar') 
            ->press('#btnFinalizar')
            ->assertPathIs('/adm/sistema/institucion/crear3');

            //btnFinalizar
        });
    }
}
