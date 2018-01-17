<form id="actualidarDatos" class='form-inline'>
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="exampleModalLabel">Modificar país:</h4>
		  </div>
		  <div class="modal-body">
				<div id="datos_ajax"></div>
					<div class="form-group">
						<label for="codigo" class="control-label">Fecha de Solicitud:</label>
						<input type="text" class="form-control" id="fecha" name="fecha" required maxlength="2"  readonly="readonly">
						<input type="hidden" class="form-control" id="id" name="id"><br>
						<label for="moneda" class="control-label">Monto en Bs.</label>
						<input type="text" class="form-control" id="moneda" name="moneda" required maxlength="3"  readonly="readonly"><br>
						<label for="capital" class="control-label">Monto en U.T.</label>
						<input type="text" class="form-control" id="capital" name="capital" required maxlength="3" readonly="readonly"> 
					</div>
					<div class="form-group">
						<label for="planilla" class="control-label">Numero de Planilla:</label>
						<input type="text" class="form-control" id="planilla" name="planilla" placeholder="Ultimos 8 digitos" required maxlength="8">
					</div>
					<div class="form-group">
						<label for="fechapago" class="control-label">Fecha de Pago:</label>
						<input type="text" class="form-control" id="fechapago" name="fechapago" required maxlength="8">
					</div>
					<div class="form-group">
						<label for="plaza" class="control-label">Entidad Bancaria:</label>
						<?php
						
							include_once('classbasededatos.php');
							$con = new classbasededatos();
							$con->conectar();
							$comando="select * from entidades, plazas where entidades.plaza = plazas.codigo order by codigo";
							echo '<select class="form-control" name="plaza" id="plaza" size="1">';
							$resp=$con->consulta($comando);
							while($row = $con->fetch_assoc($resp)){
								echo '<option '.$row['codigo'].' selected="selected"  value="'.$row['codigo'].'">'.$row['nombre'].' '.$row['cuenta'].' </option>'; 
							}
							echo '</select>'; 
							$con->desconectar();
						?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button>
					<button type="submit" class="btn btn-primary">Actualizar datos</button>
				</div>
			</div>
	</div>
</div>
</form>
