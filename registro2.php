script src="ajx/ajxrif.js" type="text/javascript"></script>
<head>
<script src="buscarrif.js" type="text/javascript"></script>
</head>
<?php
echo "<form action='tributos.php' name='form1' id='form1' method='post'>";// onsubmit='return validar0(form1)'>"; // hidden-xs div class="col-xs-12 col-sm-8 col-md-6"> --> ;



		echo 'Nacionalidad';
			if ($_POST['nacionalidad'])
				{
					echo '<input class="form-control" type="hidden" name="nacionalidad" id="nacionalidad" value="'.$_POST['nacionalidad'].'">';
					echo $_POST['nacionalidad'];
				}
				else {
					$comando="select * from configuracion where nombreparametro = 'nacionalidad' order by valorparametro" ;
					$res=mysql_query($comando);
					echo '<select class="form-control" name="nacionalidad" id="nacionalidad" size="1">';
					while ($fila = mysql_fetch_assoc($res)) {
						echo '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
					}
					echo '<option selected value="V">V</option>'; 
					echo '<option value="J">J</option>'; 
					echo '</select>'; 
				}
			echo '</div>';
			echo '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" >';
				echo 'Cedula';
				if ($_POST['numero'])
				{
					echo '<input type="hidden" name="numero" id="numero" value="'.$_POST['numero'].'">';
					echo $_POST['numero'];
				}
				else 
					echo '<input class="form-control" align="right" name="numero" type="text" id="numero" size="9" maxlength="9" value ="093773884" title="se necesita el numero de cedula" required>'; // onchange="validarsinumero(this.value);"  
			echo '</div>';
			echo '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" >';
				echo 'Digito';
				if ($_POST['digito'])
				{
					echo '<input type="hidden" name="digito" id="digito" value="'.$_POST['digito'].'">';
					echo $_POST['digito'];
				}
				else {
				// echo '<select class="form-control" name="digito" id="digito" size="1">'; // onblur="ajax_call_rif()">';
				echo '<select class="form-control" name="digito" id="digito" size="1" onblur="ajax_call_rif()">';
				echo '<option value="0" selected >0</option>'; 
				for ($elfactor=1; $elfactor < 10; $elfactor++)
					echo '<option value='.$elfactor.'>'.$elfactor.'</option>'; 
				echo '</select>'; 
				}
			echo '</div>';

			echo '<div id="resultado"> </div>';

			echo '<div class="col-xs-12 col-sm-2 col-md-4 col-lg-4" >';
				echo 'Nombre/Raz&oacute;n Social';
				if ($_POST['razon'])
				{
					echo '<input type="hidden" name="razon" id="razon" value="'.$_POST['razon'].'">';
					echo $_POST['razon'];
				}
				else {
					echo '<input class="form-control" align="right" name="nombre" type="text" id="nombre" size="100" maxlength="100" value ="" readonly="readonly" title="se necesita un nombre">'; // required onfocus="refrescar_select();">'; onchange="validarnom_ape(this.value);" 
				}	
			echo '</div>';

	echo '<input align="right" name="rif" type="text" id="rif" size="11" maxlength="11" value ="J400102464" title="Se necesita el numero de cedula/ RIF" required onblur="ajax_call_rif_normal()">';
	// echo '<input align="right" name="nombre" type="text" id="nombre" size="50" maxlength="100" value ="" title="Se necesita la razon social" required >';

			echo '</form>';
?>
