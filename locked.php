<?
// include_once('head.html');
/*
<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap-session-timeout - Logged Out</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
*/

session_start();
date_default_timezone_set('America/Caracas'); 
unset($_SESSION['rif']);
// include_once('index.php');
?>
</head>

<body>
    <div class="container">
        <h1>Cierre de Sesion por Inactividad</h1>
        <hr>
 <?php
/*
 //      <p>Podemos redirigirlo a la URL previa</p>

        <input onclick="backClick()" class="btn btn-primary" type="button" value="Regresar">

*/
?>
    </div>
 <?php
/*
    <script>
    function backClick() {
        window.history.back()
    }
    </script>
*/
?>
</body>

</html>
