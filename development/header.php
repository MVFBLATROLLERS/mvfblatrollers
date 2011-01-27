<?php
$green_bg =  "http://img718.imageshack.us/img718/9062/greengradient.jpg";
$greyg_bg =  "http://img441.imageshack.us/img441/3664/greygradient.jpg"; // too slow
$greys_bg  = "http://img192.imageshack.us/img192/1545/greystripes.jpg"; // image too small
$lightbulb = "";//"http://img580.imageshack.us/img580/5871/lightbulb.png"; // below bg
$maroon =    "http://www.obs.navajo.org/Portals/13/Images/NNrn/black_maroon_gradient_4_NNRN_2.jpg";
$ice    =    "http://psd.tutsplus.com/tutorials/7_Ice/1.jpg";
$grey2  =    "http://www.darklined.com/assets/uploads/v1.jpg";
$black  =    "http://www.cathrynhunt.com/images/black_gradient.png";
$blue = "http://www.1stwebdesigner.com/wp-content/themes/hybrid-news/images/bgr.jpg";
$blueg = "http://aditijain.degree7.com/aditijain/images/fading_backgrounds/fading_background_19.png";
$bg = $blueg;
$theme = "cupertino";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?> </title>
        <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/<? echo $theme; ?>/jquery-ui.css" rel="stylesheet" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
		<script language="javascript" type="text/javascript" src="js/jquery.flow.1.2.min.js"></script>  
		<script type="text/javascript">  
		  $(document).ready(function(){  
			  $("#myController").jFlow({  
				  slides: "#slides",  // the div where all your sliding divs are nested in  
				  controller: ".jFlowControl", // must be class, use . sign  
				  slideWrapper : "#jFlowSlide", // must be id, use # sign  
				  selectedWrapper: "jFlowSelected",  // just pure text, no sign  
				  width: "610px",  // this is the width for the content-slider  
				 height: "235px",  // this is the height for the content-slider  
				 duration: 400,  // time in miliseconds to transition one slide  
				 prev: ".jFlowPrev", // must be class, use . sign  
				 next: ".jFlowNext" // must be class, use . sign  
			   });  
			});  
		</script>  
		<script>
			$(function() {
				var $el, leftPos, newWidth,
					$mainNav = $("#example-one");

				$mainNav.append("<li id='magic-line'></li>");
				var $magicLine = $("#magic-line");

				$magicLine
					.width($(".current_page_item").width())
					.css("left", $(".current_page_item a").position().left)
					.data("origLeft", $magicLine.position().left)
					.data("origWidth", $magicLine.width());

				$("#example-one li a").hover(function() {
					$el = $(this);
					leftPos = $el.position().left;
					newWidth = $el.parent().width();
					$magicLine.stop().animate({
						left: leftPos,
						width: newWidth
					});
				}, function() {
					$magicLine.stop().animate({
						left: $magicLine.data("origLeft"),
						width: $magicLine.data("origWidth")
					});
				});
			});
			$( '#linkbutton').button();
		</script>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		</head>
    <body>
    <img src="<? echo $bg; ?>" id="bg" />
	<center>
		<div class="nav-wrap">
			<ul class="group" id="example-one">
			<li class="current_page_item link_home"><a href="index.php" style="color: #C00000;">HOME</a></li>
			<li><a href="#">ABOUT</a></li>
			<li><a href="#">ART</a></li>
			<li><a href="#">CLIENTS</a></li>
			<li><a href="#">STAFFING</a></li>
			<li><a href="#">CONTACT US</a></li>
		 </ul>
		</div>
			<div id=content width=900px>
				<h1><span style="font-size: 3em;font-family: Bitstream Charter;"><i>hsJobs: High School Job Board</i></span></h1>
		<table border=0 width=100% cellpadding=5px>
			<td cellpadding='5px'>
				<div id="maincontent" style="">
