	function load(page){
		var parametros = {"action":"ajax","page":page};
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'lostramites.php',
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

/*
			$('#dataUpdate').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var codigo = button.data('codigo') // Extraer la información de atributos de datos
		  var id = button.data('id') // Extraer la información de atributos de datos
		  var nombre = button.data('nombre') // Extraer la información de atributos de datos
		  var moneda = button.data('moneda') // Extraer la información de atributos de datos
		  var capital = button.data('capital') // Extraer la información de atributos de datos
		  var continente = button.data('continente') // Extraer la información de atributos de datos
		  
		  var modal = $(this)
		  modal.find('.modal-title').text('Modificar país: '+nombre)
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #codigo').val(codigo)
		  modal.find('.modal-body #nombre').val(nombre)
		  modal.find('.modal-body #moneda').val(moneda)
		  modal.find('.modal-body #capital').val(capital)
		  modal.find('.modal-body #continente').val(continente)
		  $('.alert').hide();//Oculto alert
		})
*/		

			$('#dataUpdate').on('show.bs.modal', function (event) {
//	alert('1')
			$(function() {
			/*
				$('input[name="birthdate"]').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true
				}, 
				function(start, end, label) {
					var years = moment().diff(start, 'years');
					alert("You are " + years + " years old.");
				});
			});
			*/

			$('input[name="fechapago"]').daterangepicker({
				"singleDatePicker": true,
				"startDate":  button.data('hoy'),  // "11/07/2016", 
				"endDate": button.data('hoy'), // "11/30/2016", 
				"minDate": button.data('fecha'), // "11/01/2016",
				"maxDate": button.data('hoy') // "11/30/2016"
			}, function(start, end, label) {
			  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
			});
			});

// alert('2')
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var fecha = button.data('fecha') // Extraer la información de atributos de datos
		  var id = button.data('id') // Extraer la información de atributos de datos
		  var nombre = button.data('nombre') // Extraer la información de atributos de datos
		  var moneda = button.data('moneda') // Extraer la información de atributos de datos
		  var capital = button.data('capital') // Extraer la información de atributos de datos
		  var planilla = button.data('planilla') // Extraer la información de atributos de datos
		  var fechapago = button.data('fechapago')
		  var plaza = button.data('plaza')
		  
		  var modal = $(this)
		  modal.find('.modal-title').text('Registrar pago: '+nombre + 'Tramite # '+id)
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #fecha').val(fecha)
		  modal.find('.modal-body #nombre').val(nombre)
		  modal.find('.modal-body #moneda').val(moneda)
		  modal.find('.modal-body #capital').val(capital)
		  modal.find('.modal-body #planilla').val(planilla)
		  modal.find('.modal-body #fechapago').val(fechapago)
		  modal.find('.modal-body #plaza').val(plaza)
		  $('.alert').hide();//Oculto alert
		})
		
		$('#dataDelete').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var id = button.data('id') // Extraer la información de atributos de datos
		  var nombre = button.data('nombre') // Extraer la información de atributos de datos
		  var modal = $(this)
		  modal.find('#id').val(id)
		  modal.find('.modal-title').text('Eliminar Tramite # '+id)
		})

		$('#dataPrint').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botón que activó el modal
		  var idp = button.data('idp') // Extraer la información de atributos de datos
		  var nombre = button.data('nombre') // Extraer la información de atributos de datos
		  var modal = $(this)
		  modal.find('.modal-title').text('Enviar al email Tramite # '+idp)
		  modal.find('#idp').val(idp)
		})



		$( "#actualidarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "reportarpago.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#datos_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#datos_ajax").html(datos);
					
					$('#datos_ajax').modal('hide');
					load(1);
				  }
			});
		  event.preventDefault();
		});
		
		$( "#guardarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "agregar.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#datos_ajax_register").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#datos_ajax_register").html(datos);
				  }
			});
		  event.preventDefault();
		});
		
		$( "#eliminarDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "eliminar.php",
					data: parametros,
					 beforeSend: function(objeto){
						$(".datos_ajax_delete").html("Mensaje: Eliminando informacion...");
					  },
					success: function(datos){
					$(".datos_ajax_delete").html(datos);
					
		//			$('#dataDelete').modal('hide');
					$('#datos_ajax_delete').modal('hide');
					load(1); 
				  }
			});
		  event.preventDefault();
		});

		$( "#imprimirDatos" ).submit(function( event ) {
		var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					//url: {"imprimirqr.php",'newwin', 'width=400,height=500,Directories=NO, Location=NO,Status=NO,Resizable=NO,Scrollbars=NO'},  // no fncina
					url: "imprimirqr.php", 
					data: parametros,
//					contentType: ('Content-type: application/pdf'),  // "json", // 
					 beforeSend: function(objeto){
						$(".datos_ajax_delete").html("Mensaje: Espere por favor... Generando QR...");
					  },
					success: function(datos){
//						console.log(parametros);
					$(".datos_ajax_delete").html(datos);
					
					$('#dataDelete').modal('hide');
					load(1);
				  }
			});
		  event.preventDefault();
		});
		