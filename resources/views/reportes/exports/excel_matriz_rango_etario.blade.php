<br>
<br>
<br>
<br>
<br>
<!-- INICIO DC -->
@php
	if(count($prob) > 0){
@endphp
<!-- FIN DC -->
<br>
<br>
<table class="table table-striped table-hover" cellspacing="0" id="tabla_registros">
	<thead>
		<tr>
            <th style="text-align: center;width: 25%">{{$prob[0]->mat_tip_ran_eta_nom}}</th>
            <th style="text-align: center;width: 25%">Problemática</th>
            <th style="text-align: center;width: 25%">Magnitud</th>
            <th style="text-align: center;width: 25%">Gravedad</th>
            <th style="text-align: center;width: 25%">Capacidad</th>
            <th style="text-align: center;width: 25%">Alternativa de Solución</th>
            <th style="text-align: center;width: 25%">Beneficio</th>
		</tr>
    </thead>   
    <tbody>     
	
    	@php
			$indice = 1;
		@endphp
		 @foreach($prob as $rango1) 
                <tr>
                    <td>Problema {{$indice++}}</td>
                    <td>{{$rango1->problematica}}</td>
                    <td>{{$rango1->mat_ran_eta_mag}}</td>
                    <td>{{$rango1->mat_ran_eta_grav}}</td>
                    <td>{{$rango1->mat_ran_eta_cap}}</td>
                    <td>{{$rango1->mat_ran_eta_alt_sol}}</td>
                    <td>{{$rango1->mat_ran_eta_ben}}</td>
                </tr>
                @endforeach
	</tbody>
</table>
@php
	}
	if(count($prob2) > 0){
@endphp
<br>
<br>
<table class="table table-striped table-hover tabla_registros" cellspacing="0" >
	<thead>
			<tr>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">{{$prob2[0]->mat_tip_ran_eta_nom}}</th>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">Problemática</th>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">Magnitud</th>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">Gravedad</th>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">Capacidad</th>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">Alternativa de Solución</th>
            <th style="text-align: center;width: 25%;background-color:#E6E6E6">Beneficio</th>
		</tr>
    </thead>   
    <tbody>    
    @php
			$indice2 = 1;
		@endphp 
			@foreach($prob2 as $rango2)
                <tr>
                    <td>Problema {{$indice2++}}</td>
                    <td>{{$rango2->problematica}}</td>
                    <td>{{$rango2->mat_ran_eta_mag}}</td>
                    <td>{{$rango2->mat_ran_eta_grav}}</td>
                    <td>{{$rango2->mat_ran_eta_cap}}</td>
                    <td>{{$rango2->mat_ran_eta_alt_sol}}</td>
                    <td>{{$rango2->mat_ran_eta_ben}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@php
	}
	if(count($prob3) > 0){
@endphp
<br>
<br>
        <table class="table table-striped table-hover tabla_registros" cellspacing="0" >
	<thead>
		<tr>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">{{$prob3[0]->mat_tip_ran_eta_nom}}</th>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">Problemática</th>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">Magnitud</th>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">Gravedad</th>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">Capacidad</th>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">Alternativa de Solución</th>
                    <th style="text-align: center;width: 25%;background-color:#E6E6E6">Beneficio</th>
		</tr>
    </thead>   
    <tbody>     
            	@php
        			$indice3 = 1;
        		@endphp
        			@foreach($prob3 as $rango3)
			<tr>
                            <td>Problema {{$indice3++}}</td>
                            <td>{{$rango3->problematica}}</td>
                            <td>{{$rango3->mat_ran_eta_mag}}</td>
                            <td>{{$rango3->mat_ran_eta_grav}}</td>
                            <td>{{$rango3->mat_ran_eta_cap}}</td>
                            <td>{{$rango3->mat_ran_eta_alt_sol}}</td>
                            <td>{{$rango3->mat_ran_eta_ben}}</td>
			</tr>
		@endforeach
	</tbody>
</table>@php
	}
@endphp
