<form id="actualidarDatos">
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Tributo</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" class="form-control" id="id" name="id" required>

			<div class="form-group col-xs-12">
			<div id="datos_ajax"></div>
				<label for="monto" class="control-label col-xs-12">Monto BsF</label>
				<input type="number" class="form-control" id="monto" name="monto" required maxlength="10" size="10"  data-error="Ups!!!...., No es un monto valida" required autocomplete="off" >
				<div class="help-block with-errors"></div>
			</div>        
	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>