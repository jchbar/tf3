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
		$estatus_pendiente=1;
		$consulta="select count(idregistro) as numrows from campos ";
		// echo $consulta;
		$count_query   = $con->consulta($consulta);
		// if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$numrows=$con->fetch_assoc($count_query);
		$numrows=$numrows['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = 'tramites.php';
		//consulta principal para recuperar los datos
		$paginas="select * FROM campos order by articulo LIMIT $offset,$per_page ";
		$query = $con->consulta($paginas);
		// echo $paginas;
	
		
		if ($numrows>0){
			?>
		<table class="table table-bordered">
			  <thead>
				<tr>
				  <th>Articulo</th>
				  <th>Concepto</th>
				  <th>U.T.</th>
				  <th>Fracci&oacute;n</th>
				  <!-- <th>U.T.</th>
				  <th>Planilla</th>
				  <th>Banco</th>
				  <th>Pago</th>
				  <!-- <th>Observaci&oacute;n</th> -->
				  <th></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while($row = $con->fetch_assoc($query)){
				?>
				<tr>
					<td><?php echo $row['articulo'];?></td>
					<td><?php echo substr($row['concepto'],0,40);?></td>
					<td><?php echo number_format($row['cantidadut'],2,'.',',');?></td>
					<td><?php echo number_format($row['valorfraccion'],2,'.',',');?></td>
					<?php 
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
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<?php echo $row['idregistro']?>" data-codigo="<?php echo $row['articulo']?>" data-nombre="<?php echo $row['concepto']?>" data-unidad="<?php echo $row['cantidadut']?>" data-fraccion="<?php echo $row['valorfraccion']?>" data-valor="<?php echo $row['valorfijo']?>" data-funcionalidad="<?php echo $row['funcionalidad']?>" data-medida="<?php echo $row['descripcionmedida']?>" data-cntminimo="<?php echo $row['utminimo']?>" data-cntmaxima="<?php echo $row['utmaximo']?>" data-porcentaje="<?php echo $row['porcentajeaplicado']?>"><i class='glyphicon glyphicon-edit'></i> Modificar</button>
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $row['idregistro']?>" data-codigo="<?php echo $row['articulo']?>" data-nombre="<?php echo $row['concepto']?>" ><i class='glyphicon glyphicon-trash'></i> Eliminar</button>
					</td>
						<?php 
/*
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
