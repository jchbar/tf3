var xmlhttp;
// =false;

// if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//  xmlhttp = new XMLHttpRequest();
// }

function ajax_call_rif() 
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	var linea='ajx/rifjson.php?rif=' + document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value;
 	// alert(linea);
	xmlhttp.onreadystatechange=cambiorif;
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


function cambiorif() 
{
//	alert('a')
	if (xmlhttp.readyState==4) 
	{
	//			document.getElementById('cuota').value = xmlhttp.responseText;	// forma original para uno solo
	//			document.getElementById('interes_diferido').value = xmlhttp.responseText;

	//	alert('1');
	//	var xmlDoc=xmlhttp.responseXML.documentElement;
	//	alert('2');
	//	alert(xmlDoc);
		// var 
		xmlDoc=xmlhttp.responseXML;
		document.getElementById('resultado').innerHTML = ""; // + xmlDoc.getElementsByTagName("nombreseniat")[0].childNodes[0].nodeValue;
		document.getElementById("razon").value= xmlDoc.getElementsByTagName("nombre")[0].childNodes[0].nodeValue;
		cuantos=14;
		// if (xmlDoc.getElementsByTagName("code_result")[0].childNodes[0].nodeValue == 1)
		{
	//		alert ('1');
			document.getElementById("btntramites").style.display="block";		
			document.getElementById("botontramites").innerHTML=cuantos;
		}
		 // alert('3')
	}
	else
		document.getElementById('resultado').innerHTML = 'Buscando informaci&oacuten ' +  document.getElementById('nacionalidad').value+ document.getElementById('numero').value+document.getElementById('digito').value + "<img src=\"ajx/imagenes/animadas/cargando.gif\" />";

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
