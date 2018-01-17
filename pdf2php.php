<?php
/*
$imagick = new Imagick();
$imagick->readImage('reportesprestamos/2013-05-03amortizacion.pdf');
$imagick->writeImage('reportesprestamos/salida.jpg');
*/
/*
exec("imagen/ImageMagick-i686-pc-cygwin/ImageMagick-6.8.8/bin/convert reportesprestamos/2013-05-03amortizacion.pdf reportesprestamos/salida.jpg");
*/


/*
header("Content-type: image/png");
$cadena = 'txt de prueba';// $_GET['texto'];
$im     = imagecreatefrompng("imagen/boton1.png");
$naranja = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($cadena)) / 2;
imagestring($im, 3, $px, 9, $cadena, $naranja);
imagepng($im);
imagedestroy($im);

<?PHP
*/
  $image = @imagecreatetruecolor(200, 200) or die("Cannot Initialize new GD image stream");
  // set background and allocate drawing colours
  //$background = imagecolorallocate($image, 0x66, 0x99, 0x66);
  $background = imagecolorallocate($image, 0xff, 0xff, 0xff);
  imagefill($image, 0, 0, $background);
  $linecolor = imagecolorallocate($image, 0x84, 0x84, 0x84);
  // $textcolor1 = imagecolorallocate($image, 0x00, 0x00, 0x00);
  // $textcolor2 = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
  // draw random lines on canvas
  for($i=0; $i < 6; $i++) {
    imagesetthickness($image, rand(1,3));
    imageline($image, 0, rand(0,200), 200, rand(0,200) , $linecolor);
  }
  session_start();
  // add random digits to canvas using random black/white colour
/*
  $digit = '';
  for($x = 15; $x <= 95; $x += 20) {
    $textcolor = (rand() % 2) ? $textcolor1 : $textcolor2;
    $digit .= ($num = rand(0, 9));
    imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
  }
  // record digits in session variable
  $_SESSION['digit'] = $digit;
*/

  // display image and clean up
  header('Content-type: image/png');
  imagepng($image);
  imagedestroy($image);
?>

