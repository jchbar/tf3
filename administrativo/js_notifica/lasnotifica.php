<?php
session_start();
/*-----------------------
Autor: Obed Alvarado
http://www.obedalvarado.pw
Fecha: 12-06-2015
Version de PHP: 5.6.3
----------------------------*/

	# conectare la base de datos
	include_once('../classbasededatos.php');
	$con= new classbasededatos();
	$con->conectar();
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include '../pagination.php'; //incluir el archivo de paginación
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		// $count_query   = mysqli_query($con,"SELECT count(*) AS numrows FROM countries ");
		$losusuarios = "SELECT * FROM configuracion where nombreparametro = 'NivelUsuario' and valorparametro != 'Operador'";
		$resultado = $con->consulta($losusuarios);
		$elegidos = '(status = 1) and ';
		while($row = $con->fetch_assoc($resultado)){
			$elegidos.= "(nivel = '".$row['valorparametro']."') or ";
		}
		$tamano = strlen($elegidos)-4;
		$elegidos= substr($elegidos,0,$tamano);
		
		$estatus_pendiente=1;
		$consulta="select count(codigousuario) as numrows from ingreso_usuario where (".$elegidos.")";
		// echo $consulta;
		$count_query   = $con->consulta($consulta);
		// if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$numrows=$con->fetch_assoc($count_query);
		$numrows=$numrows['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = 'notificar.php';
		//consulta principal para recuperar los datos
		$paginas="select * FROM ingreso_usuario where (".$elegidos.") order by nombre LIMIT $offset,$per_page ";
		$query = $con->consulta($paginas);
		// echo $paginas;
	
		
		if ($numrows>0){
			?>
		<table class="table table-bordered">
			  <thead>
				<tr>
				<th colspan="3">
				</th>
				<th align="center" colspan="4">Notificaciones de....
				</th>
				</tr>
				<tr>
				  <th>Nombre</th>
				  <th>email</th>
				  <th>Nivel</th>
				  <!-- <th>U.T.</th>
				  <th>Planilla</th>
				  <th>Banco</th>
				  <th>Pago</th>
				  <!-- <th>Observaci&oacute;n</th> -->
				  <?php
					$comando="select * from configuracion where nombreparametro = 'Notificables' order by valorparametro" ;
					$res=$con->consulta($comando);
					while ($fila = $con->fetch_assoc($res)) {
						echo '<th>'.$fila['valorparametro'].'</td>';
					}
				  ?>
				  <th></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while($row = $con->fetch_assoc($query)){
				?>
				<tr>
					<td><?php echo substr($row['nombre'],0,40);?></td>
					<td><?php echo $row['email'];?></td>
					<?php /*
					<td>
					echo '<button type="button" class="btn btn-'.($row['status']==1?'success':'warning').'"><i class=\'glyphicon glyphicon-user\'></i> </button>';

					$row['status'];?></td> */?>
					<td><?php echo $row['nivel'];?></td>
					<?php 
						$comando = "select * from notificacion, configuracion where codigousuario = '".$row['id']."' and (notificacion=configuracion.idregistro) order by valorparametro";
						$res=$con->consulta($comando);
						$registros = 0;
						while ($fila = $con->fetch_assoc($res)) {
							echo  '<td><input class="checkbox" align="center" disabled="true"  type="checkbox" id="cancelar'.$registros.'" name="cancelar'.$registros.'" value="'.$fila["idregistro"] .'" '.($fila["activo"]==1?'checked':'').'></td>'; // '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
							$registros++;
						}

					/*
					switch ($row['statustimbre'])
					{
						case 0:
							echo 'No Pagado';
							break;
						case 1:
							echo 'Esperando Aprobacion';
							break;
						case 2:
							echo 'Aprobado';
							break;
						case 3:
							echo 'Impreso';
							break;
					}
					*/
					?>
					<td>
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<?php echo $row['codigousuario']?>" data-nombre="<?php echo $row['nombre']?>" data-nivel="<?php echo $row['nivel']?>"><i class='glyphicon glyphicon-edit'></i> Modificar</button>
					</td>
						<?php 
/*
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $row['codigousuario']?>" data-codigo="<?php echo $row['articulo']?>" data-nombre="<?php echo $row['concepto']?>" ><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
							if ($row['statustimbre'] == 0)
							{
								echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="'.$row['idregistro'].'" data-fecha="'.$row['fechas'].'" data-nombre="'.$fila2['concepto'].'" data-moneda="'.$row['montobs'].'" data-capital="'.$row['montout'].'" data-planilla="'.$row['nroplanilla'].'" data-fechapago="'.$row['fechapago'].'" data-plaza="'.$row['plaza'].'" data-hoy="'.$row['hoy'].'"><i class=\'glyphicon glyphicon-edit\'></i> Reportar Pago</button>';
								// <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $row['idregistro']>"  ><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
								echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDelete" data-id="'.$row['idregistro'].'" ><i class=\'glyphicon glyphicon-trash\'></i> Eliminar</button>';
							}
							else if ($row['statustimbre'] == 1)
								echo ''; // ' no mostrar nada';
							else if (($row['statustimbre'] == 2) or ($row['statustimbre'] == 3))
							{
								// https://sourceforge.net/projects/phpqrcode/files/
								// echo ' mostrar boton de imprimir'; // glyphicon glyphicon-envelope
								if ($row['vecesimpreso']==0)
									// echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataPrint" data-id="'.$row['idregistro'].'" ><i class=\'glyphicon glyphicon-print\'></i> Imprimir Timbre Fiscal</button>';
								echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataPrint" data-id="'.$row['idregistro'].'" ><i class=\'glyphicon glyphicon-envelope\'></i> Enviar Timbre Fiscal al email</button>';
								else
									if ($row['vecesimpreso']<4)
										echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#dataPrint" data-id="'.$row['idregistro'].'" ><i class=\'glyphicon glyphicon-envelope\'></i> ReEnviar Timbre Fiscal al email <span class="badge"><div id="botontramites" name="botontramites">'.$row['vecesimpreso'].'</div></span></button>';
									else if ($row['vecesimpreso']==4)
										echo '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#dataPrint" data-id="'.$row['idregistro'].'" ><i class=\'glyphicon glyphicon-envelope\'></i> Reenviar Timbre Fiscal<span class="badge"><div id="botontramites" name="botontramites">'.$row['vecesimpreso'].'</div></span></button>';
							}
//							else if ($row['statustimbre'] == 3)
//								echo ' mosrtrar reimprimir';
*/
						?>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>

	<form action="opciones.php" method="POST">
		<div class="col-md-6">
		<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>
		</div>
	</form>

		<div class="table-pagination pull-right">
			<?php echo paginate($reload, $page, $total_pages, $adjacents);?>
		</div>
		
			<?php
			
		} else {
			?>
			<div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
            </div>
			<?php
		}
	}
?>
