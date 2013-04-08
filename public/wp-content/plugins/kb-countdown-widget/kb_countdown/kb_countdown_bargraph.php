<?php
/* 
* DYNAMIC BARGRAPH developed by ADAM BROWN (http://adambrown.info) for the KB Countdown Widget (http://adambrown.info/b/widgets/kb-countdown/). 
* You can use this for other purposes if you must, but give credit where credit is due.  Leave this notice intact, please.
*/



// check all input vars
if ( is_numeric( $_GET['done'] ) ){
	if ($_GET['done'] > 100){
		$_GET['done'] = 100;
	}elseif ($_GET['done'] < 0){
		$_GET['done'] = 0;
	}
}else{
	$_GET['done'] = 0;
}

if ( is_numeric( $_GET['width'] ) ){
	if ($_GET['width'] > 1000){
		$_GET['width'] = 1000;
	}elseif ($_GET['width'] < 10){
		$_GET['width'] = 10;
	}
}else{
	$_GET['width'] = 100;
}

if ( is_numeric( $_GET['height'] ) ){
	if ($_GET['height'] > 1000){
		$_GET['height'] = 1000;
	}elseif ($_GET['height'] < 0){
		$_GET['height'] = 0;
	}
}else{
	$_GET['height'] = 10;
}

$maxborder_w = ( $_GET['width'] / 2 ) - 10;	// must have at least ten pixels inside the border of width (well, not "must", but I'm requiring it)
$maxborder_h = ( $_GET['height'] / 2 ) - 1;	// must have at least one pixels of height
$maxborder = ($maxborder_w < $maxborder_h) ? $maxborder_w : $maxborder_h;	// use the smaller one
if ( !is_numeric( $_GET['border'] ) ){
	$_GET['border'] = 1;
}
if ($_GET['border'] > $maxborder){
	$_GET['border'] = $maxborder;
}
if ($_GET['border'] < 0){	// don't use elseif; need to check that maxborder >= 0.
	$_GET['border'] = 0;
}

// (if they specified color vars, check those later)


// process dimensions and such
$borderx1 = 0;
$bordery1 = 0;
$borderx2 = $_GET['width'] - 1;		// remember that if you have 100 pixels, then you're working with pixels 0 through 99
$bordery2 = $_GET['height'] - 1;	// ditto
$backgroundx1 = $borderx1 + $_GET['border'];	// move right the number of pixels reserved for the border
$backgroundy1 = $bordery1 + $_GET['border'];
$backgroundx2 = $borderx2 - $_GET['border'];
$backgroundy2 = $bordery2 - $_GET['border'];
$barx1 = $backgroundx1;	// the bar has to completely cover the background at first
$bary1 = $backgroundy1;
$barx2 = round( ( ($backgroundx2 - $backgroundx1) * $_GET['done'] / 100) + $backgroundx1 );	// length of the bar is a percent of the background's width. need to add backgroundx1 back in so it starts from the right spot
$bary2 = $backgroundy2;





// create image
$image = imagecreatetruecolor($_GET['width'], $_GET['height']); // image dimensions 
	// note to self: 103 leaves 1 pixel on each side (# 0 and # 102) and 101 pixels in the middle. (e.g.)




// allocate some solors
#$white    = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
$gray    = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);
$darkgray = imagecolorallocate($image, 0x80, 0x80, 0x80);
$navy    = imagecolorallocate($image, 0x00, 0x00, 0xFE);

// default colors
$barcolor = $navy;
$bordercolor = $darkgray;
$bgcolor = $gray;


// if they specified color vars, check those now
if ( $_GET['bar'] ){	// bargraph color, e.g. ?bar=240,126,99 where each is part of the hex ff78bc style of color, converted to integer
	$bar_c = explode("," , $_GET['bar']);
	if (3 == count($bar_c)){
		$bar_c[0] = $bar_c[0] < 0 ? 0 : $bar_c[0];
		$bar_c[0] = $bar_c[0] > 255 ? 255 : $bar_c[0];
		$bar_c[1] = $bar_c[1] < 0 ? 0 : $bar_c[1];
		$bar_c[1] = $bar_c[1] > 255 ? 255 : $bar_c[1];
		$bar_c[2] = $bar_c[2] < 0 ? 0 : $bar_c[2];
		$bar_c[2] = $bar_c[2] > 255 ? 255 : $bar_c[2];
		$barcolor = imagecolorallocate($image, $bar_c[0], $bar_c[1], $bar_c[2]);
	}
}
if ( $_GET['border_c'] ){	// border color
	$border_c = explode("," , $_GET['border_c']);
	if (3 == count($border_c)){
		$border_c[0] = $border_c[0] < 0 ? 0 : $border_c[0];
		$border_c[0] = $border_c[0] > 255 ? 255 : $border_c[0];
		$border_c[1] = $border_c[1] < 0 ? 0 : $border_c[1];
		$border_c[1] = $border_c[1] > 255 ? 255 : $border_c[1];
		$border_c[2] = $border_c[2] < 0 ? 0 : $border_c[2];
		$border_c[2] = $border_c[2] > 255 ? 255 : $border_c[2];
		$bordercolor = imagecolorallocate($image, $border_c[0], $border_c[1], $border_c[2]);
	}
}
if ( $_GET['bg'] ){	// background color
	$bg_c = explode("," , $_GET['bg']);
	if (3 == count($bg_c)){
		$bg_c[0] = $bg_c[0] < 0 ? 0 : $bg_c[0];
		$bg_c[0] = $bg_c[0] > 255 ? 255 : $bg_c[0];
		$bg_c[1] = $bg_c[1] < 0 ? 0 : $bg_c[1];
		$bg_c[1] = $bg_c[1] > 255 ? 255 : $bg_c[1];
		$bg_c[2] = $bg_c[2] < 0 ? 0 : $bg_c[2];
		$bg_c[2] = $bg_c[2] > 255 ? 255 : $bg_c[2];
		$bgcolor = imagecolorallocate($image, $bg_c[0], $bg_c[1], $bg_c[2]);
	}
}



// draw the sucker
imagefilledrectangle($image, $borderx1, $bordery1, $borderx2, $bordery2, $bordercolor);
imagefilledrectangle($image, $backgroundx1, $backgroundy1, $backgroundx2, $backgroundy2, $bgcolor);
if ($_GET['done'] > 0 )	// otherwise you'll have a 1 pixel line drawn from $barx1 to $barx2 even if done=0
	imagefilledrectangle($image, $barx1, $bary1, $barx2, $bary2, $barcolor);


// flush image
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>