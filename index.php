<?php 
/*
Plugin Name: Bark: Twig Components for WordPress
Description: Twig template language adaptation for WordPress 4.0 theming.
Author: Brent Jett
Version: 0.1
*/

require_once 'includes/Twig/Autoloader.php';
Twig_Autoloader::register();

// Twig_Template Subclass
require_once 'includes/Twig_Additions/BRJ_Twig_Extension.class.php';

// Setup twig environment
add_action('init', function() {
	
	$comp_dir = 'components';
	$directories = array();
	$directories[] = get_stylesheet_directory() . '/';
	$directories[] = get_stylesheet_directory() . "/$comp_dir/";
	$components = glob(get_stylesheet_directory() . "/$comp_dir/*/");
	$directories = array_merge($directories, $components);
	$directories = apply_filters('twig_template_directories', $directories);

	$loader = new Twig_Loader_Filesystem($directories);
	$twig = new Twig_Environment($loader, array(
	    'cache' => get_stylesheet_directory() . '/template_cache/',
	    'debug' => false
	));
	
	// Register extension class
	$twig = new Twig_Environment($loader);
	$twig->addExtension(new BRJ_Twig_Extension($comp_dir));
	$GLOBALS['twig'] = $twig;
});

// Filter the template process - If it's a twig template, render it with twig and return false.
add_filter('template_include', function($template) {
	global $twig;

	// IF DECLARED AS TWIG TEMPLATE Take over the templating process
	if (is_twig_template($template)) {
		$file = basename($template);
		$template = $twig->loadTemplate($file);
		$vars = array();
		$template->display($vars);
	
		// Don't return the $template path
		return false;
	} else {
		return $template;
	}
});

function is_twig_template($path) {
	$string = file_get_contents($path);

	// check for {# enable_twig #} comment
	/*
	if (strpos($string, 'enable_twig') ) {
		return true;
	}*/

	/* disable_twig */

	// check for {% open tag
	if (strpos($string, "{%") ) {
		return true;
	}
	return false;
}
?>