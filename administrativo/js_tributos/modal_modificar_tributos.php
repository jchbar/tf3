<form id="actualidarDatos">
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Tributo</h4>
      </div>
      <div class="modal-body">
			<div id="datos_ajax"></div>
			<div class="form-group form-inline col-xs-12">
				<label for="codigo" class="control-label">Nro de Art&iacute;culo:</label>
				<input type="text" class="form-control" id="codigo" name="codigo" required maxlength="10">
				<input type="hidden" class="form-control" id="id" name="id" required maxlength="10">
			</div>
			<div class="form-group col-xs-12">
				<label for="nombre" class="control-label col-xs-12">Descripci&oacute;n:</label>
				<input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100" maxlength="50">
			</div>
			<div class="form-group form-inline col-xs-12">
				<div class="form-group">
					<label for="unidad" class="control-label">Cnt U.T.:</label>
					<input type="number" step="0.01" class="form-control" id="unidad" name="unidad" required maxlength="5" size="5">
				</div>
				<div class="form-group">
					<label for="fraccion" class="control-label">Valor Fracci&oacute;n:</label>
					<input type="number" step="0.01" class="form-control" id="fraccion" name="fraccion" required maxlength="5" size="5">
				</div>
			</div>
			<div class="form-group form-inline col-xs-12">
				<div class="form-group checkbox">
					<label class="checkbox-inline">
						<input type="checkbox" class="form-control" id="valor" name="valor" value="1">Valor Fijo
					</label>
				</div>
				<div class="form-group">
					<label for="funcionalidad" class="control-label">Forma de Ejecuci&oacute;n</label>
					<?php
							$con = new classbasededatos();
							$con->conectar();
							$comando="select * from configuracion where nombreparametro = 'Funcionalidad' order by valorparametro" ;
							$res=$con->consulta($comando);
							echo '<select class="form-control" name="funcionalidad" id="funcionalidad" size="1">';
							while ($fila = $con->fetch_assoc($res)) {
								echo '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
							}
							echo '</select>'; 
							$con->desconectar();
					?>
				</div>
			</div>
			<div class="form-group col-xs-12">
				<label for="medida" class="control-label">Unidad de Medida:</label>
				<input type="text" class="form-control" id="medida" name="medida" required maxlength="20" maxlength="20">
			</div>

			<div class="form-group form-inline col-xs-12">
				<label for="cntminimo" class="control-label">Cnt. M&iacute;nima U.T.:</label>
				<input type="number" class="form-control" id="cntminimo" name="cntminimo" required maxlength="2" size="5">

				<label for="cntmaxima" class="control-label">Cnt. M&aacute;xima U.T.:</label>
				<input type="number" class="form-control" id="cntmaxima" name="cntmaxima" required maxlength="2"  size="5">
			</div>
			
			<div class="form-group form-inline col-xs-12">
				<label for="porcentaje" class="control-label">Monto del Porcentaje (Si aplica):</label>
				<input type="number" class="form-control" id="porcentaje" name="porcentaje" step="0.01" required maxlength="2" size="2">
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