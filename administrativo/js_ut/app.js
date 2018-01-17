	function load(page){
		var parametros = {"action":"ajax","page":page};
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'js_ut/lasut.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='loader.gif'>");
			},
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}

		$('#dataUpdate').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var monto = button.data('monto') // Extraer la información de atributos de datos
		  var id = button.data('id') // Extraer la información de atributos de datos
		  // var nombre = button.data('nombre') // Extraer la información de atributos de datos
		  // var nivel = button.data('nivel') 
		  
		  var modal = $(this)
		  modal.find('.modal-title').text('Modificar Unidad Tributaria ')
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #monto').val(monto)
		  // modal.find('.modal-body #nivel').val(nivel)
		  $('.alert').hide();//Oculto alert
		})
		
		$('#dataDelete').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos
		  var codigo = button.data('codigo') // Extraer la información de atributos de datos
		  var nombre = button.data('nombre') // Extraer la información de atributos de datos
//		  var unidad = button.data('unidad') 
		  var modal = $(this)
		  
		  modal.find('#id').val(id)
		  modal.find('.modal-body #codigo').val(codigo)
		  modal.find('.modal-body #nombre').val(nombre)
		  modal.find('.modal-title').text('Eliminar Usuario ' +codigo + ' / '+nombre)
		})
// para agregar 
		$('#dataRegister').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
			var parametros = $(this).serialize();
			$(function() {
				$('input[name="fechainicio"]').daterangepicker({
					"singleDatePicker": true,
					"startDate":  button.data('hoy'),  // "11/07/2016", 
					"endDate": button.data('maximo'), // "11/30/2016", 
					"minDate": button.data('minimo'), // "11/01/2016",
					"maxDate": button.data('maximo') // "11/30/2016"
				}, function(start, end, label) {
//				  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
				});
			});

/*
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var codigo = button.data('codigo') // Extraer la información de atributos de datos
		  var id = button.data('id') // Extraer la información de atributos de datos
		  var nombre = button.data('nombre') // Extraer la información de atributos de datos
		  var nivel = button.data('nivel') 
		  
		  var modal = $(this)
		  modal.find('.modal-title').text('Modificar Usuario: '+nombre)
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #nombre').val(nombre)
		  modal.find('.modal-body #nivel').val(nivel)
*/
		  $('.alert').hide();//Oculto alert
		});
// fin agregar
		$( "#actualidarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "js_usuarios/modificar_ut.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#datos_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#datos_ajax").html(datos);
					console.log(datos);
					
					load(1);
				  }
			});
		  event.preventDefault();
		});
		
		$( "#guardarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "js_ut/agregar_ut.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#datos_ajax_register").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#datos_ajax_register").html(datos);
					load(1);
				  }
			});
		  event.preventDefault();
		});
		
	
		$( "#eliminarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "js_usuarios/eliminar_usuarios.php",
					data: parametros,
					 beforeSend: function(objeto){
						$(".datos_ajax_delete").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$(".datos_ajax_delete").html(datos);
					
					$('#dataDelete').modal('hide');
					load(1);
				  }
			});
		  event.preventDefault();
		});
