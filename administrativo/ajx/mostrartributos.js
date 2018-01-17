var xmlhttp;
// =false;

// if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//  xmlhttp = new XMLHttpRequest();
// }

function ajax_call_tributo() {
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
	  return;
	  }
//	var selIndex = document.getElementById('lascuotas').options[document.getElementById('lascuotas').selectedIndex].value;
//	var selIndex = document.getElementById("lascuotas").options[document.getElementById("lascuotas").selectedIndex].value; 
	var selIndex = document.getElementById('tributo').value;
//	comboValue = document.getElementById('lascuotas').options[selIndex].value;
	var linea='ajx/mostrartributos.php?articulo=' + document.getElementById('tributo').value;
//	alert(linea);
						
						// +  document.getElementById('monpre_sdp').value;
						// document.getElementById('lascuotas');
 	// alert(linea);
	xmlhttp.onreadystatechange=cambio;
	xmlhttp.open("GET", linea, true);
//----------
/*
//setup the headers
    try {
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("Accept", "text/xml, application/xml, text/plain");
    } catch ( ex ) {
        window.alert('error' + ex.toString());
    }

*/
//----------
	xmlhttp.send(null)
//	return false;
}


function cambio() {
if (xmlhttp.readyState==4) {
	xmlDoc=xmlhttp.responseXML;
	// desactivo todo lo necesario
	document.getElementById("porcentajeaplicado").disabled=true;
	document.getElementById("utminimo").disabled=true;
	document.getElementById("utmaximo").disabled=true;
	document.getElementById("mostrablerango").style.display="none";
	document.getElementById("mostrablecantidad").style.display="none";
	// fin desactivo todo lo necesario
	document.getElementById("ut").value= xmlDoc.getElementsByTagName("ut")[0].childNodes[0].nodeValue;
// alert('a')
	// document.getElementById("descripcionmedida").value=xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
	document.getElementById('descripcionmedida').innerHTML = xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
	document.getElementById('descripcionmedidac').innerHTML = xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
	document.getElementById("porcentajeaplicado").value= xmlDoc.getElementsByTagName("porcentajeaplicado")[0].childNodes[0].nodeValue;
 // alert('b')
	document.getElementById("utminimo").value= xmlDoc.getElementsByTagName("utminimo")[0].childNodes[0].nodeValue;
	document.getElementById("utmaximo").value=xmlDoc.getElementsByTagName("utmaximo")[0].childNodes[0].nodeValue;
 // alert('c')
	document.getElementById("valorfraccion").value=xmlDoc.getElementsByTagName("valorfraccion")[0].childNodes[0].nodeValue;
	document.getElementById("valorfijo").value=xmlDoc.getElementsByTagName("valorfijo")[0].childNodes[0].nodeValue;
//	 alert('d')
document.getElementById("funcionalidad").value=xmlDoc.getElementsByTagName("funcionalidad")[0].childNodes[0].nodeValue;
	document.getElementById("subtotal").value=xmlDoc.getElementsByTagName("subtotal")[0].childNodes[0].nodeValue;
//	 alert('1')
	document.getElementById("valorut").value=xmlDoc.getElementsByTagName("valorut")[0].childNodes[0].nodeValue;
	document.getElementById("valorfraccion").value=xmlDoc.getElementsByTagName("valorfraccion")[0].childNodes[0].nodeValue;
//	 alert('2')

	document.getElementById("requerido").value =0;
	document.getElementById("requerido").disabled=true;
	document.getElementById("requeridas").disabled=true;
	if (document.getElementById("funcionalidad").value == 2)
	{
		document.getElementById("requerido").disabled=false;
		document.getElementById("medidasvariables").value=xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
//		document.getElementById("medidasfijas").value=xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
		document.getElementById("mostrablecantidad").style.display="block";
	}
	else 
		// document.getElementById("requerido").disabled=true;
	if (document.getElementById("funcionalidad").value == 3)
	{
		document.getElementById("requeridas").disabled=false;
		document.getElementById("mostrablerango").style.display="block";
		document.getElementById("medidasfijas").value=xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
		
		var selectActual=null;
//		alert('a')
		selectActual=document.getElementById("requeridas");
		//alert('b')
		selectActual.length=0;
		//alert('c')
			
		var nuevaOpcion=document.createElement("option"); // nuevaOpcion.value=0; nuevaOpcion.innerHTML="Selecciona Opci&oacute;n...";
		//alert('d')
		var contar=-1;
		for (var valor=document.getElementById("utminimo").value;(valor<=document.getElementById("utmaximo").value);valor++)
		{
			contar++;
			nuevaOpcion=document.createElement("option"); nuevaOpcion.value=valor; nuevaOpcion.innerHTML=valor;
			selectActual.appendChild(nuevaOpcion);
		}
		selectActual.disabled=false; 
	}
	else 
	{
//		document.getElementById("requerido").disabled=true;
//		document.getElementById("requerido").value =0;
	}
	if ((document.getElementById("funcionalidad").value == 4) || (document.getElementById("funcionalidad").value == 5))
	{
		document.getElementById("requerido").disabled=false;
		document.getElementById("medidasvariables").value=xmlDoc.getElementsByTagName("descripcionmedida")[0].childNodes[0].nodeValue;
		document.getElementById("mostrablecantidad").style.display="block";
//		document.getElementById("requerido").value = xmlDoc.getElementsByTagName("utminimo")[0].childNodes[0].nodeValue;
	}
	else 
	{
//		document.getElementById("requerido").disabled=true;
//		document.getElementById("requerido").value =0
	}
	
//	{
//		alert('visible');
//		document.getElementById("porapl").show();
//	}
 //   else document.getElementById("porapl").hide();


/*
	elsexo=xmlDoc.getElementsByTagName("sexo")[0].childNodes[0].nodeValue;
	if (elsexo == "") elsexo = "Masculino";
	document.getElementById(elsexo).value=xmlDoc.getElementsByTagName("sexo")[0].childNodes[0].nodeValue;
	document.getElementById(elsexo).checked=true;
//	alert(document.getElementById(xmlDoc.getElementsByTagName("sexo")[0].childNodes[0].nodeValue).checked);
	document.getElementById("sector").value= xmlDoc.getElementsByTagName("sector")[0].childNodes[0].nodeValue;
//	document.getElementById("sexo").value=xmlDoc.getElementsByTagName("sexo")[0].childNodes[0].nodeValue;

	eltipo=xmlDoc.getElementsByTagName("tipo_preferencial")[0].childNodes[0].nodeValue;
	document.getElementById(eltipo).value=eltipo; // xmlDoc.getElementsByTagName(eltipo)[0].childNodes[0].nodeValue;
	document.getElementById(eltipo).checked=true;
// 	alert(xmlDoc.getElementsByTagName("obtencion_local")[0].childNodes[0].nodeValue);
// 	alert("llegue"+xmlDoc.getElementsByTagName("ciudad")[0].childNodes[0].nodeValue);
	document.getElementById("ciudad").value= xmlDoc.getElementsByTagName("ciudad")[0].childNodes[0].nodeValue;
	document.getElementById("municipio").value= xmlDoc.getElementsByTagName("municipio")[0].childNodes[0].nodeValue;
//	document.getElementById("parroquia").setAttribute("parroquia",xmlDoc.getElementsByTagName("parroquia")[0].childNodes[0].nodeValue);
	document.getElementById("parroquia").value= xmlDoc.getElementsByTagName("parroquia")[0].childNodes[0].nodeValue;
// 	alert(xmlDoc.getElementsByTagName("ciudad")[0].childNodes[0].nodeValue);
	document.getElementById("tarifa").value=xmlDoc.getElementsByTagName("identificador_tarifa")[0].childNodes[0].nodeValue;

//	alert(xmlDoc.getElementsByTagName("codigo_institucion_estudiante")[0].childNodes[0].nodeValue);
	if ((eltipo=="ESTUDIANTE") || (xmlDoc.getElementsByTagName("codigo_institucion_estudiante")[0].childNodes[0].nodeValue==""))
	{
		document.getElementById("inputString").value= xmlDoc.getElementsByTagName("codigo_institucion_estudiante")[0].childNodes[0].nodeValue;
		document.getElementById("nivel").value=xmlDoc.getElementsByTagName("nivel_estudios_estudiante")[0].childNodes[0].nodeValue;
	}
	if (xmlDoc.getElementsByTagName("obtencion_local")[0].childNodes[0].nodeValue==1)
	{
//		alert("activo");
		document.getElementById("ingresar").value="Modificar";
		document.getElementById("eliminar").disabled=false;

	}

//	document.getElementById("apellido").value=xmlDoc.getElementsByTagName("apellido")[0].childNodes[0].nodeValue;
*/
	}
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
//	  alert('a');
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
//	  alert('b');
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

////////////////////////
