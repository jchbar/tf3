<script src="ajx/revisarmail.js" type="text/javascript"></script>
<form data-toggle="validator" role="form" id="guardarDatos" name="guardarDatos" method="POST">
<!-- <form id="guardarDatos"> -->
<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Ingresar Usuario</h4>
      </div>
      <div class="modal-body">
			<div id="datos_ajax_register"></div>
			<div class="form-group col-xs-12">
				<label for="nombre" class="control-label col-xs-12">Nombre del Usuario</label>
				<input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100" size="50" data-error="Ups!!!...., No es nombre valido" autocomplete="off">
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-xs-12">
				<label for="mail" class="control-label col-xs-12">Correo Electronico</label>
				<input type="email" class="form-control" id="mail" name="mail" required maxlength="100" size="50"  data-error="Ups!!!...., No es una direccion valida" required autocomplete="off" onblur="ajx_rev_mail()">
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group form-inline col-xs-12">
				<label for="nivel" class="control-label">Nivel</label>
				<?php
					$con = new classbasededatos();
					$con->conectar();
					$comando="select * from configuracion where nombreparametro = 'NivelUsuario' order by valorparametro" ;
					$res=$con->consulta($comando);
					echo '<select class="form-control" name="nivel" id="nivel" size="1">';
					while ($fila = $con->fetch_assoc($res)) {
						echo '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
					}
					echo '</select>'; 
					$con->desconectar();
				?>
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