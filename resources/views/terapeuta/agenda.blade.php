@extends('layouts.main')

@section('contenido')
	<section class=" p-1 cabecera">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-12">
					<h2><span class="oi oi-calendar"></span> Agenda</h2>
				</div>
			</div>
		</div>
	</section>
	
	<section class="p-3">
		<div class="container">
			<div class="card p-4">
				<div class="container theme-showcase">
					<input type="hidden" id="caso" name="caso" value="{{ @$caso }}">
					<input type="hidden" id="url_agenda" value="{{ route('agendas.generar') }}">
					<input type="hidden" id="url_agenda_grupal" value="{{ route('agendas.grupal') }}">
					@if(session('perfil')!='4' && !$caso)
						<div class="row">
							<div class="col-3">
								<div class="form-group">
									<select class="form-control " name="terapeuta" id="terapeuta">
										<option value="" selected>Seleccione Facilitador</option>
										@foreach( $terapeutas as $terapeuta)
											<option value="{{$terapeuta->id}}" >{{$terapeuta->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					@endif
					<h5>Aquí se pueden ver las sesiones programadas y los casos involucrados.</h5>
					<div id="agenda" class="" ></div>
				</div>
			</div>
		</div>
	</section>
	
	<hr>
@stop

@section('script')
	<link rel='stylesheet' href='/fullcalendar/fullcalendar.css' />
	<script src='/fullcalendar/fullcalendar.js'></script>
	<script src='/fullcalendar/locale-all.js'></script>
	<script>
		$(function() {
			$('#agenda').fullCalendar({
				defaultView: 'month',
				showNonCurrentDates: false,
				defaultTimedEventDuration: '01:00:00',
				locale: 'es',
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listWeek'
				},
				themeSystem : 'bootstrap4',
				bootstrapFontAwesome: {
					close: 'fa-times',
					prev: 'fa-chevron-left',
					next: 'fa-chevron-right',
					prevYear: 'fa-angle-double-left',
					nextYear: 'fa-angle-double-right'
				},
				eventSources: [
					// your event source
					{
						url: $('#url_agenda').val(),
						type: 'get',
						data: function () { // a function that returns an object
							return {
								caso: $('#caso').val(),
								terapeuta: $('#terapeuta').val(),
								comuna: 'something'
							};
						},
						error: function() {
							//alert('there was an error while fetching events!');
							console.log('ocurrio un error')
						},
						eventColor: '#378006',
					},
					{
						url: $('#url_agenda_grupal').val(),
						type: 'get',
						data: function () { // a function that returns an object
							return {
								caso: $('#caso').val(),
								terapeuta: $('#terapeuta').val(),
								comuna: 'something'
							};
						},
						error: function() {
							//alert('there was an error while fetching events!');
							console.log('ocurrio un error')
						},
						
						eventColor: '#378006',
					}
					// any other sources...
				],
				eventRender: function(eventObj, $element) {
					$element.popover({
						html:true,
						title: eventObj.title,
						content: eventObj.description,
						trigger: 'hover',
						placement: 'top',
						container: 'body',
						template: "<div class='popover agenda-tam' role='tooltip'><div class='arrow'></div><h3 class='popover-header'></h3><div class='popover-body'></div></div>"
					});
				},
				dayClick: function(date, jsEvent, view, resourceObj) {
					$('#agenda').fullCalendar( 'gotoDate', date);
					$('#agenda').fullCalendar('changeView', 'agendaDay');
				}

				// put your options and callbacks here
			})
			
			$("#terapeuta").on('change', function () {
				//console.log('hola')
				$('#agenda').fullCalendar('rerenderEvents');
				$('#agenda').fullCalendar('refetchEvents');
			});
			
		});
	</script>


@stop