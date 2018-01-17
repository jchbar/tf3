<form data-toggle="validator" role="form" id="guardarDatos" name="guardarDatos" method="POST">
<!-- <form id="guardarDatos"> -->
<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Ingresar Unidad Tributaria</h4>
      </div>
      <div class="modal-body">
			<div id="datos_ajax_register"></div>
			<div class="form-group col-xs-12">
				<label for="fechainicio" class="control-label col-xs-12">Fecha de Inicio</label>
				<input type="text" class="form-control" id="fechainicio" name="fechainicio" required data-error="Ups!!!...., No es una fecha valida" autocomplete="off">
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-xs-12">
				<label for="monto" class="control-label col-xs-12">Monto BsF</label>
				<input type="number" class="form-control" id="monto" name="monto" required maxlength="10" size="10"  data-error="Ups!!!...., No es un monto valida" required autocomplete="off" >
				<div class="help-block with-errors"></div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
      </div>
    </div>
  </div>
</div>
</form>