<form id="actualidarDatos">
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Tributo</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" class="form-control" id="id" name="id" required maxlength="10">

			<div class="form-group col-xs-12">
			<div id="datos_ajax"></div>
				<label for="nombre" class="control-label col-xs-12">Nombre del Usuario</label>
				<input type="text" class="form-control" id="nombre" name="nombre" required readonly="readonly" maxlength="100" size="50" data-error="Ups!!!...., No es nombre valido" autocomplete="off">
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group form-inline col-xs-12">
				<label for="option control-label" class="control-label">Indique permisos a establecer</label><br>
				<?php
//					echo "$valor = ">unidad<?php echo ";"; 
					$con = new classbasededatos();
					$con->conectar();
					$comando = "select * from notificacion, configuracion where codigousuario = '".$_SESSION['usuario_sistema']."' and (notificacion=configuracion.idregistro) order by valorparametro";
					$res=$con->consulta($comando);
					if ($con->num_rows($res) < 1)
					{
						$comando="select * from configuracion where nombreparametro = 'Notificables' order by valorparametro" ;
						$res=$con->consulta($comando);
						$registros = 0;
						while ($fila = $con->fetch_assoc($res)) {
							echo  '<input class="checkbox"  type="checkbox" id="cancelar'.$registros.'" name="cancelar'.$registros.'" value="'.$fila["idregistro"] .'">'. $fila['valorparametro'].'<br>'; // '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
							$registros++;
						}
					}
					else
					{
						$registros = 0;
						while ($fila = $con->fetch_assoc($res)) {
							echo  '<input class="checkbox" type="checkbox" id="cancelar'.$registros.'" name="cancelar'.$registros.'" value="'.$fila["idregistro"] .'" '.($fila["activo"]==1?'checked':'').'>'. $fila['valorparametro'].'<br>'; // '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
							$registros++;
						}
					}						
					echo '<input type="hidden" class="form-control" id="registros" name="registros" value="'.$registros.'">';
					$con->desconectar();
				?>
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