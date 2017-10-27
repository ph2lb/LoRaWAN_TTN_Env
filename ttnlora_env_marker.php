<?php
    $color = isset($_GET['c']) ? $_GET['c'] : "1A88AB";
    $text = isset($_GET['t']) ? $_GET['t'] : "-99";

    $fillcolor = explode(",",hex2rgb($color));

    $IMG = imagecreate( 30, 30 );
    $background = imagecolorallocate($IMG, 255,255,255);
    $text_color = imagecolorallocate($IMG, 0,0,0); 
    $dot_color = imagecolorallocate($IMG, $fillcolor[0],$fillcolor[1],$fillcolor[2]);

    imagecolortransparent ( $IMG, $background );
    imagefilledellipse( $IMG, 15, 15, 30, 30, $dot_color );
    imageellipse( $IMG, 15, 15, 29, 29, $text_color );
    $text_x = 8;
    $text_y = 8;
    if (strlen($text) == 1)
       $text_x += 4;
    if (strlen($text) == 3)
       $text_x -= 3;
    imagestring( $IMG, 3, $text_x, $text_y, $text,  $text_color );
    header( "Content-type: image/png" );
    imagepng($IMG);
    imagecolordeallocate($IMG, $line_color );
    imagecolordeallocate($IMG, $text_color );
    imagecolordeallocate($IMG, $background );
    imagedestroy($IMG); 
    exit;   

function hex2rgb($hex) {
    // Copied
   $hex = str_replace("#", "", $hex);

   switch (strlen($hex)) {
    case 1:
        $hex = $hex.$hex;
    case 2:
          $r = hexdec($hex);
          $g = hexdec($hex);
          $b = hexdec($hex);
        break;

    case 3:
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        break;

    default:
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
        break;
   }

   $rgb = array($r, $g, $b);
   return implode(",", $rgb); 
}
?>
