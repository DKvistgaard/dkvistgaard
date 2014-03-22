<!DOCTYPE html> 
<html lang="da"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui">
    
	<link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="http://brick.a.ssl.fastly.net/Roboto:250,500/Open+Sans:600/Alegreya+Sans:250i">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/css/main.css" />
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<!-- This script makes the HTML5 tags readable for IE -->
	<!--[if lt IE 9]> <script src="<?php bloginfo('template_directory'); ?>/js/html5shiv.js"></script> <![endif]-->
	
    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>

    <header class="main-head">
        <h1>
            <?php
            if (is_home()) {
                bloginfo('name');
            } else {
                the_title();
            }
            ?>
        </h1>
    </header>
