@extends('layouts.main')
	<form enctype="multipart/form-data" id="adj_cons" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="cas_id" id="cas_id" value="273">

		 <input type="file" name="doc_cons" id="doc_cons">
		 <input type="submit" value="Enviar">
		
	</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>

	 $( document ).ready(function() {

	 // 	$("#archivo").change(function() {

  //   	 alert("alerta");	
  //   	// this.form.submit();
		
		// });	

		// $('#adj_paf').on('submit', function(e) {

		 $("#doc_cons").change(function(e) {
	
		  alert("okoko");

		  // evito que propague el submit
		  e.preventDefault();
		  
		  // agrego la data del form a formData
		  var form = document.getElementById('adj_cons');
		  var formData = new FormData(form);
		  formData.append('_token', $('input[name=_token]').val());

		  $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		  });

		  $.ajax({
		      type:'POST',
		      url: "{{ route('enviararhcons') }}",
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(data){
		          toastr.error('Validation true!', 'se pudo Añadir los datos<br>', {timeOut: 5000});
		      },
		      error: function(jqXHR, text, error){
		          toastr.error('Validation error!', 'No se pudo Añadir los datos<br>' + error, {timeOut: 5000});
		      }
		  });

		});

	});

	</script>

