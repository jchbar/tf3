<form id="imprimirDatos"  class='form-inline'>
	<div class="modal fade" id="dataPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">Modificar país:</h4>
				</div>
		<!--       <h2 class="text-center">Asegurese de habilitar ventanas emergentes....</h2> -->
				<div class="modal-body">
						<div id="datos_ajax"></div>
						<h2 class="text-center text-muted">Estas seguro?</h2>
						<p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción realizara la impresion de su Timbre Fiscal. Desea continuar?</p>
						<div class="form-group">
							<input type="hidden" class="form-control" id="idp" name="idp"><br>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-lg btn-primary">Enviar Email</button>
				</div>
			</div>			
		</div>
	</div>
</form>