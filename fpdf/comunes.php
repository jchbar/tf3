<?

    /*  
  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
	Autores: Pedro Obreg�n Mej�as
			 Rub�n D. Mancera Mor�n
	Versi�n: 1.0
	Fecha Liberaci�n del c�digo: 13/07/2004
	Galop�n para gnuLinEx 2004 -- Extremadura		 
	
	*/
class PDF extends FPDF
{
//Cabecera de p�gina
function Header()
{
/*
   $consulta = "Select * from sgcaf100";
   $resultado = mysql_query($consulta); // , $conexion);
   $lafila=mysql_fetch_assoc($resultado); 
   $filas=mysql_num_rows($resultado);

    //Logo
    $this->Image('fpdf/logo/logo.jpg',10,0,20);

 	$this->SetY(5);
 	$this->SetX(30);
	$this->SetFont('Arial','B',11);
//	$this->MultiCell(180,4,trim($lafila["nombr_empr"]),0,'LC');//
	$this->Cell(180,4,trim($lafila["nombr1_empr"]),0,0,'C');//
 	$this->SetY(10);
 	$this->SetX(30);
	$this->Cell(180,4,trim($lafila["nombr2_empr"]),0,0,'C');//
 	$this->SetY(20);
 	$this->SetX(0);
	$this->SetFont('Arial','B',14);
	$this->Cell(180,0,trim($lafila["alias_empr"]),0,0,C);//
*/
/*
 	$this->SetY(25);
 	$this->SetX(0);
	$this->MultiCell(0,0,"Planilla de Pre-Inscripci�n",0,C,0);//
//     $this->Cell(0,10,$lafila["nombr_empr"] . " -- " .  $lafila["direc_empr"] . " -- " . $lafila["telefono"],0,0,'C');	
*/
	$this->Ln();   
    $this->Ln(10);	
}

//Pie de p�gina
function Footer()
{

/*
//   include ("../conectar.php"); 
   $consulta = "Select * from sgcaf100";
   $resultado = mysql_query($consulta); // , $conexion);
   $lafila=mysql_fetch_assoc($resultado); 

   $filas=mysql_num_rows($resultado);
   if ($filas<>0)
     {   

    //Posici�n: a 1,5 cm del final
    $this->SetY(-21);
    //Arial italic 8
    $this->SetFont('Arial','',7);
*/
/*
    //N�mero de p�gina
	$numero=$lafila["codprovincia"];
	$consulta2="select * from provincias where codprovincia=$numero";
	$resultado2=mysql_query($consulta2,$conexion);
	$lafila2=mysql_fetch_array($resultado2);
	$provincia=$lafila2["denprovincia"];
*/	
/*
    $this->Cell(0,10,$lafila["direc_empr"] . " -- " . $lafila["telefono"],0,0,'C');	
	
	//Posici�n: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //N�mero de p�gina
//    $this->Cell(0,10,"C.I.F.:  " . $lafila["cif"] . "  Tlfno: " . $lafila["telefono"]. "  FAX: " . $lafila["fax"]. "  M�vil: " . $lafila["movil"],0,0,'C');	

	$this->SetY(-15);
//    $this->Cell(0,10,"Web.:  " . $lafila["web"] . "  E-mail: " . $lafila["email"],0,0,'C');		
    $this->Cell(0,10,'http://www.heros.com.ve -- E-Mail: juan.hernandez@heros.com.ve',0,0,'C');	

    //Posici�n: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //N�mero de p�gina
    $this->Cell(0,10,'-- '.$this->PageNo().' --',0,0,'C');
	}
	else
	{
    //Posici�n: a 1,5 cm del final
    $this->SetY(-21);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //N�mero de p�gina
    $this->Cell(0,10,'http://www.heros.com.ve -- E-Mail: juan.hernandez@heros.com.ve',0,0,'C');	
	
	//Posici�n: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //N�mero de p�gina
//     $this->Cell(0,10,'Proyecto Galop�n Extremadura',0,0,'C');	
	

    //Posici�n: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //N�mero de p�gina
    $this->Cell(0,10,'-- '.$this->PageNo().' --',0,0,'C');	
	}
*/
}


}
?>