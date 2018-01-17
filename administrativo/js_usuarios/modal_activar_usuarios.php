<form id="ActivarDesactivar" role="form">
<div class="modal fade" id="dataActiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Tributo</h4>
      </div>
      <div class="modal-body">
		<h2 class="text-center text-muted">Est&aacute; seguro?</h2>
		<p class="lead text-muted text-center" style="display: block;margin:10px">Procede al cambio de estatus de este registro. Deseas continuar?</p>
		<input type="hidden" id="id" name="id">
		<input type="hidden" id="status" name="status">
			<div id="datos_ajax"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Cambiar estatus</button>
      </div>
    </div>
  </div>
</div>
</form>