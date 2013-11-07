<?php
    header("Content-type: text/css; charset: UTF-8");
?>

<?php 
/* Short and sweet */
define('WP_USE_THEMES', false);
require('../../../../wp-blog-header.php');
?>

<?php

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b, .9);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

$color1 = get_option('color1');
$color2 = get_option('color2');
$color3 = get_option('color3');
$color4 = get_option('color4');
$color5 = get_option('color5');

?>


.color1:hover, .color1 a:hover, li.color1 {
	color: <?php echo $color1 ?> !important;
}

.color2:hover, .color2 a:hover, li.color2 {
	color: <?php echo $color2 ?> !important;
}

.color3:hover, .color3 a:hover, li.color3 {
	color: <?php echo $color3 ?> !important;
}

.color4:hover, .color4 a:hover, li.color4 {
	color: <?php echo $color4 ?> !important;
}

.color5:hover, .color5 a:hover, li.color5 {
	color: <?php echo $color5 ?> !important;
}

.color1 .post_block_content {
	background: rgba(<?php echo hex2rgb($color1);?>);
}

.color2 .post_block_content {
	background: rgba(<?php echo hex2rgb($color2);?>);
}

.color3 .post_block_content {
	background: rgba(<?php echo hex2rgb($color3);?>);
}

.color4 .post_block_content {
	background: rgba(<?php echo hex2rgb($color4);?>);
}

.color5 .post_block_content {
	background: rgba(<?php echo hex2rgb($color5);?>);
}
