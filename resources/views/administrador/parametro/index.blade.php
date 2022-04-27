@extends('administrador.layouts.main')


@section('content')

<div class="row" style="padding-top: 20px;">

    <ul class="breadcrumb">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Administracion Sistema</a></li>
        <li class="active">Mantención de Parámetros</li>
    </ul>

</div>

<div class="row">
	<div class="clearfix"></div>
		<div class="col-lg-12">
            <br>
            <div class="col-lg-1" >
                <button type="button" class="btn btn-success btn-xs " data-toggle="tooltip" data-placement="left" title="Crear Mantenedor" onclick="agregarMantenedor();" id="IDagregar" ><i class="fa fa-plus" aria-hidden="true"></i> Crear Mantenedor</button>
            </div>            
            <label class="col-lg-1 control-label" for="telefono">Mentenedor: </label>
            <div class="col-lg-4">
                <select class="form-control" id="IDpadre" name="id_padre" onchange="cargarMantenedor(this.value);">
                   <option>Seleccione Mantenedor:</option>
                    <?php 
                        foreach($lstMantenedor as $llave => $valor) {
                            $selected ="";
                            echo "<option value='{$llave}' {$selected}>".$valor."</option>";
                        }
                    ?>  
                </select>
            </div>
            <div class="col-lg-4" >
                <button type="button" class="btn btn-success btn-xs " data-toggle="tooltip" data-placement="left" title="Agregar un Parametro" onclick="agregarParametro();" style="display: none;" id="IDagregarParametro"><i class="fa fa-plus" aria-hidden="true"></i> Agregar un Parametro</button>
            </div>
				<div class="panel-body" id="IDtblParametro" style="display: none;">
		            <div class="table-responsive">
		                <table class="table table-striped table-bordered table-hover" cellspacing="0" id="tblParametros">
		                    <thead>
		                        <tr>
		                            <th>Id</th>
		                            <th>Id Padre</th>
		                            <th>Nombre</th>     
                                    <th>Valor</th>                                                                
                                    <th>Estado</th>     
                                    <th>Orden</th> 
		                            <th>Acción</th>                            
		                        </tr>                        
		                    </thead> 

		                    <tbody>
		                                                               
		                    </tbody>                   
		                </table>
		            </div>
		        </div>




@stop
@section('js')
<script>
	
   function cargaTablaParametros(id_padre) {
        var tblParametros = $('#tblParametros').DataTable();
        tblParametros.destroy();


        tU = $('#tblParametros').DataTable({
            "bLengthChange": false,
            "ajax": {
                "url": "/administrador/api/parametros/get-parametros",
                "dataSrc": "",
                "type": "POST",
                "data": { "id_padre": id_padre,"_token" : "{{csrf_token()}}" }
            },
            "columns": [
                { "data": 'id', "width": "5%" },
                { "data": 'id_padre', "width": "5%" },
                { "data": 'nombre', "width": "30%" },
                { "data": 'valor', "width": "10%" },
                { "data": 'nombre_estado', "width": "15%" },
                { "data": 'orden', "width": "5%" },
                {
                    "data": null, "width": "30%", "className": "dt-center", "orderable": false,
                    "render": function (data, type, full, meta) {
                        return '<button type="button" class="btn btn-success btn-xs " data-toggle="tooltip" data-placement="left" title="Editar datos" onclick="grabar(' + full.id + ',\'Editar Parametro\');"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                    }
                },
                /*{ "data": 'EmailConfirmed', "visible": false },
                { "data": 'estado', "visible": false }*/
            ],
            "order": [[0, "asc"]],
            "language"  : { "url": "{{ route('index') }}/js/dataTables.spanish.json"},
            //"language": { "url": "/js/jquery.dataTables.es.json?v={{date("YmdHis")}}" },
            "initComplete": function (settings, json) {
                
                this.css('width', '100%');

               
            },
            "drawCallback": function (settings) { $("[data-toggle=tooltip]").tooltip({ html: true }); }
        });

        
    }



    function grabar(id,msj){
         url = '/administrador/mantenedores/parametro/grabar/' + id + '/';
         btnGuardando('#btnGuardar');
         showModalAjax('#xModal',msj, url, '', 2, 'enviaFormModal(\'#frmGrabarParametro\',\'\',\'grabarOK()\',\'grabarError\');');
    }

    function grabarOK(){
        $('#xModal').modal('hide');        
        cargaTablaParametros($('#IDpadre').val());
        modalMsj("<p> Se grabó correctamente el parametro.</p>");
    }



  function modalDetalle(folio) {
    		$('#txtFolioDetalle').val(folio);
            $("#modalDetalle").modal('show');
    }


    function showModalEditar(id){
        url = '/adm/sistema/parametro/editar/' + id + '/';
        showModal('Editar Registro', url, 0);//cambiar la funcion

    } 

    function cargarMantenedor(id_padre){
        $('#IDtblParametro').show();
        cargaTablaParametros(id_padre);
        $('#IDagregarParametro').show();

    } 


    function showModalAgregar(){
        id_padre = $('#IDreg_id').val();
        url = '/adm/sistema/parametro/agregar/' + id_padre + '/';
        showModal('Agregar Registro', url, 0);

    }

    function showModalAgregarMantenedor(){
        id_padre = $('#IDreg_id').val();
        url = '/adm/sistema/parametro/agregarmantenedor/';
        showModal('Agregar Nuevo Mantenedor', url, 0);

    }



    function editar(id,id_padre,nombre,valor,orden,estado){
        $('#txtIdParametro').val(id);   
        $('#IDid_padreEditar').val(id_padre);   
        $('#IDnombre').val(nombre);   
        $('#IDvalor').val(valor);   
        $('#IDestado').val(estado);   
        $('#IDorden').val(orden);
        $('#modalEditar').modal('show');
    }

    function guardarEditar(){
        btnGuardando('#btnGuardar');
        enviaFormModal('#frmEditarParametro','','editarOK()','editarError');

    }    

    function editarOK(){
       $('#modalEditar').modal('hide');        
        cargaTablaParametros($('#IDid_padreEditar').val());        
        modalMsj("<p>Se grabo exitosamente el parametro.</p>");
    }

    function editarError(msj){
       $('#modalEditar').modal('hide');        
        modalMsj("<p>"+msj+"</p>");
    } 


   function agregarParametro(){

        id_padre = $('#IDpadre').val();
        url = '/administrador/mantenedores/parametro/ingresar/' + id_padre + '/';
        btnGuardando('#btnGuardar');
        msj="Agregar Parametros";
        showModalAjax('#xModal',msj, url, '', 2, 'enviaFormModal(\'#frmGrabarParametro\',\'\',\'grabarOK()\',\'grabarError\');');
    }

    function guardarAgregar(){
        btnGuardando('#btnGuardar');
        enviaFormModal('#frmAgregarParametro','','agregarOK()','agregarError');

    }    

    function agregarOK(){
       $('#modalAgregar').modal('hide');        
        cargaTablaParametros($('#IDid_padreAgregar').val());
        modalMsj("<p>Se grabo exitosamente el parametro.</p>");
    }

    function agregarError(msj){
       $('#modalAgregar').modal('hide');        
        modalMsj("<p>"+msj+"</p>");
    } 

   function agregarMantenedor(){

        url = '/administrador/mantenedores/mantenedor/ingresar/';
        btnGuardando('#btnGuardar');
        msj="Agregar Mantenedor";
        showModalAjax('#xModal',msj, url, '', 2, 'enviaFormModal(\'#frmGrabarMantenedor\',\'\',\'grabarMantenedorOK()\',\'grabarMantenedorError\');');
    }

    function grabarMantenedorOK(){
        $('#xModal').modal('hide');        
        modalMsj("<p> Se grabó correctamente el mantenedor.</p>");
        reCargarMantenedor();
    }

    function grabarMantenedorOK_(){
        btnGuardando('#btnGuardar');
        enviaFormModal('#frmAgregarMantenedor','','agregarMOK()','agregarMError');

    }    

    function agregarMOK(){
       $('#modalAgregarM').modal('hide');        
        titulo = "Información";
        mensaje = "Se grabo exitosamente el parametro";
        fnc = "reCargarMantenedor();";
        modalMsjConfirm(titulo, mensaje, fnc);
        

    }

    function agregarMError(msj){
       $('#modalAgregarM').modal('hide');        
        modalMsj("<p>"+msj+"</p>");
    } 

    function reCargarMantenedor(){
        window.location.href = "{{asset('/administrador/sistema/parametro/')}}";
    }

</script>

@stop
 