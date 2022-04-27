<!-- INICIO DC SPRINT 66 -->
<section>
	<div class="container-fluid" style="width: 90%;overflow-x: auto;margin-left:-10px">
		<div class="card p-4 shadow-sm">
				<div class="row">
					<div class="col-10 text-left">
						<h5><b>Gestionar Usuarios</b></h5>
					</div>
                </div>
				<div class="row">
					<div class="table-responsive">
						<table class="table table-striped table-hover encabezado_datatable cell-border w-100" cellspacing="0" id="tabla_usuario_oln">
							<thead>
							<tr>
								<th class="text-center">Run</th>
                                <th class="text-center">Nombres</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Región</th>
                                <th class="text-center">Comuna</th>
                                <th class="text-center">Institución</th>
                                <th class="text-center">Perfil</th>
                                <th class="text-center">Vigencia</th>
								<!-- INICIO CZ SPRINT 77 -->
								<th class="text-center">Usuarios a nivel central (MDSF)</th>
                                <th class="text-center">Acciones</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>				
		</div>
	</div>
</section>
<!-- FIN DC SPRINT 66 -->

<script type="text/javascript">
//INICIO CZ SPRINT 72 
	function dgv(T)    //digito verificador
	{  
		var M=0,S=1;
		for(;T;T=Math.floor(T/10))
		S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'k';
		
		// alert(S?S-1:'k');
	}
	function formatoRun(run){
		var div1, div2, div3, div4;
        rut=run;

        if(rut.length==9){    
            div1=rut.slice(0,2);
            div2=rut.slice(2,5);
            div3=rut.slice(5,8);
            div4=rut.slice(8,9);

            rut=div1 + "." + div2 + "." + div3 + "-" + div4;
        }

        if(rut.length==8){    
            div1=rut.slice(0,1);
            div2=rut.slice(1,4);
            div3=rut.slice(4,7);
            div4=rut.slice(7,8);

            rut=div1 + "." + div2 + "." + div3 + "-" + div4;
        }
		return rut;
	}
	//FIN CZ SPRINT 72 
	$(document).ready( function () {
		
		oln = $('#opc_oln option:selected').val();
		
		perfil = $('#cbxPerfil option:selected').val();
		
		let data = new Object();
		data.oln = oln;
		data.perfil = perfil;
		
		tabla_usuario_oln = $('#tabla_usuario_oln').on('error.dt',
		function (e, settings, techNote, message) {
			tabla_usuario_oln.ajax.reload(null,false);
    		console.log('Ocurrió un error en el datatable de: rpt_usuario_perfil.index.blade.php, el error es: ', message);
		}).DataTable({
			"serverSide": true,
			"order":[[ 4, "asc" ]],
			"language"	: { "url": "{{ route('index') }}/js/dataTables.spanish.json"},			
			"ajax": {
                "url": "{{ route('rpt.usuario.oln2') }}",
                "type": "GET",
                "data": data
            },
			
			"columns": [
				{
				 "data": "run",
				 "className": "text-left",
				 "width": "10%", 
				 "render" : function (data, type, full, meta){
					 let dig = dgv(data);
					let rut = data +  dig;			
					return formatoRun(rut);
				}
				},
				{
				 "data": "nombres",
                 "className": "text-center",
                //  "render": function(data, type, row){
                //         let nombres = row.nombres+' '+row.apellido_paterno+' '+row.apellido_materno;
                //         return nombres;
                //  }
                },
                {
				 "data": "email",
				 "className": "text-center"
				},
				{
				 "data": "telefono",
				 "className": "text-center"
                },
                {
				 "data": "reg_nom",
				 "className": "text-center"
				},
				{
				 "data": "com_nom",
				 "className": "text-center"
				},
				{
				 "data": "nom_ins",
				 "className": "text-center"
                },
                {
				 "data": "perfil",
				 "className": "text-center"
                },
                {
				 "data": "estado_usuario",
				 "className": "text-center"
				},
				// INICIO CZ SPRINT 77
				{
				 "data": "flag_usuario_central",
				 "className": "text-center"
				},
				
				{ //ACCIONES
                	"data": "id",
                    "className": "text-center",
                    "render": function(data, type, row){
                    	let html = '<button class="btn btn-success" onclick="editarUsuario('+data+')">Editar</button>';										
						return html;
                    }
                }
			],
			 footerCallback: function ( row, data, start, end, display ) {
        		
    		}

		});

	});
	

	function descargarReporteXComuna(){
		oln = $('#opc_oln option:selected').val();
		//perfil = 3;
		window.location.assign("{{ route('usuario.oln.export') }}" + "/" + oln);
	}

</script>