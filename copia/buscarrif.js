var xmlhttp;
// =false;

// if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//  xmlhttp = new XMLHttpRequest();
// }

function ajax_call_rif() {
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
	  return;
	  }
//	var selIndex = document.getElementById('lascuotas').options[document.getElementById('lascuotas').selectedIndex].value;
//	var selIndex = document.getElementById("lascuotas").options[document.getElementById("lascuotas").selectedIndex].value; 
//	var selIndex = document.getElementById('rif').value;
//	comboValue = document.getElementById('lascuotas').options[selIndex].value;
// alert('voy');
// alert('producto '+document.getElementById('inputString').value);
// alert('institu '+document.getElementById('institucion').value);

	// var linea_rif='buscarrif.php?rif=' + document.getElementById('rif').value; // +'&idempresa=' + document.getElementById('idempresa').value;
//	 alert('1');
	 var numero=document.getElementById('nacionalidad').value+document.getElementById('numero').value; // +document.getElementById('digito').value;
	var linea_rif='buscarrif.php?rif='+numero;
// 	 alert('sin normal'+linea_rif);
	xmlhttp.onreadystatechange=cambio_rif;
	xmlhttp.open("GET", linea_rif, true);
//	alert('sali5');
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

function ajax_call_rif_normal() {
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
		  alert ("Browser does not support HTTP Request");
	  return;
	  }
//	var selIndex = document.getElementById('lascuotas').options[document.getElementById('lascuotas').selectedIndex].value;
//	var selIndex = document.getElementById("lascuotas").options[document.getElementById("lascuotas").selectedIndex].value; 
//	var selIndex = document.getElementById('rif').value;
//	comboValue = document.getElementById('lascuotas').options[selIndex].value;
// alert('voy');
// alert('producto '+document.getElementById('inputString').value);
// alert('institu '+document.getElementById('institucion').value);

	var linea_rif='buscarrif.php?rif=' + document.getElementById('rif').value; // +'&idempresa=' + document.getElementById('idempresa').value;
	 alert('normal 1');
	 var numero=document.getElementById('numero').value;
 //var linea_rif='revisarrif.php?rif=' + document.getElementById('nacionalidad').value+numero+document.getElementById('digito').value;
 	 alert('con normal'+linea_rif);
	xmlhttp.onreadystatechange=cambio_rif;
	xmlhttp.open("GET", linea_rif, true);
//	alert('sali5');
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


function cambio_rif() {
if (xmlhttp.readyState==4) {
//			document.getElementById('cuota').value = xmlhttp.responseText;	// forma original para uno solo
//			document.getElementById('interes_diferido').value = xmlhttp.responseText;

//	alert('1');
//	var xmlDoc=xmlhttp.responseXML.documentElement;
//	alert('2');
//	alert(xmlDoc);
	// var 
	xmlDoc=xmlhttp.responseXML;
//	alert(xmlhttp.responseXML.getElementsByTagName('cuota')[0].childNodes[0].nodeValue);
//	peticion.responseXML.getElementsByTagName("codigo" )[0];
//	document.getElementById("cuota").value= xmlDoc.getElementsByTagName("cuota")[0].childNodes[0].nodeValue;
//	document.getElementById('resultado').innerHTML = '';
	document.getElementById("nombre").value= xmlDoc.getElementsByTagName("nombre")[0].childNodes[0].nodeValue;
//	document.getElementById("obtenidolocal").value= '0';
	document.getElementById("obtenidolocal").value= xmlDoc.getElementsByTagName("obtenidolocal")[0].childNodes[0].nodeValue;
	if (xmlDoc.getElementsByTagName("obtenidolocal")[0].childNodes[0].nodeValue == 1)
	{
		alert('RIF Ya se encuentra registrado!!!');
//		document.getElementById("email").value= xmlDoc.getElementsByTagName("email")[0].childNodes[0].nodeValue;
	}
	else document.getElementById("emailcontrol").value= 'jj@jj.com';

/*
	document.getElementById("direccion1").value= xmlDoc.getElementsByTagName("direccion1")[0].childNodes[0].nodeValue;
	document.getElementById("direccion2").value= xmlDoc.getElementsByTagName("direccion2")[0].childNodes[0].nodeValue;
	document.getElementById("telefono").value= xmlDoc.getElementsByTagName("telefono")[0].childNodes[0].nodeValue;
	document.getElementById("email").value= xmlDoc.getElementsByTagName("email")[0].childNodes[0].nodeValue;
	document.getElementById("contribuyente").value=xmlDoc.getElementsByTagName("contribuyenteiva")[0].childNodes[0].nodeValue;
	document.getElementById("agente").value=xmlDoc.getElementsByTagName("agentederetencion")[0].childNodes[0].nodeValue;
	document.getElementById("tasa").value=xmlDoc.getElementsByTagName("tasa")[0].childNodes[0].nodeValue;
	document.getElementById("obtenidolocal").value=xmlDoc.getElementsByTagName("obtenidolocal")[0].childNodes[0].nodeValue;
	document.getElementById("categoria").value=xmlDoc.getElementsByTagName("tipocliente")[0].childNodes[0].nodeValue;
	document.getElementById("institucion").value=xmlDoc.getElementsByTagName("institucion")[0].childNodes[0].nodeValue;
	if (xmlDoc.getElementsByTagName("obtenidolocal")[0].childNodes[0].nodeValue==1)
	{
		document.getElementById("ingresar").value="Continuar";
//		document.getElementById("eliminar").disabled=false;

	}
*/
	}
	if (xmlhttp.readyState<4)
		document.getElementById("nombre").value= 'Buscando...';
	// document.getElementById('resultado').innerHTML = 'Buscando informaci&oacuten ' +  document.getElementById('nacionalidad').value+ document.getElementById('numero').value + "<img src=\"ajx/imagenes/animadas/cargando.gif\" />";

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

