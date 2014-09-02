<?php 
/*
Summary class for all the extensions I've added.
*/
class BRJ_Twig_Extension extends Twig_Extension {

	public function __construct($comp_dir) {
		$this->component_directory = $comp_dir;
	}

	public function getName() {
		return 'brj_extensions';
	}
	
	public function getGlobals() {
		global $wp_query, $post;
		return array(
			'wp_query' => $wp_query,
			'posts' => $wp_query->posts,
			'post' => $post,
			'stylesheet_directory' => get_stylesheet_directory(),
			'theme_path' => '/wp-content/theme/twig-tester/'
		);
	}
	
	public function getFunctions() {
		return array(
			new Twig_SimpleFunction('wp_head', 'wp_head'),
			new Twig_SimpleFunction('wp_footer', 'wp_footer'),

			new Twig_SimpleFunction('body_class', 'body_class'),
			new Twig_SimpleFunction('post_class', 'post_class'),

			new Twig_SimpleFunction('do_action', 'do_action'),

			new Twig_SimpleFunction('option', 'get_option'),
			new Twig_SimpleFunction('field', 'get_field'),

			new Twig_SimpleFunction('sidebar', function($sidebar) {
				dynamic_sidebar($sidebar);
				// still working on twig_sidebar()
			})
		);
	}
	
	public function getTokenParsers() {
		require_once 'BRJ_EnqueueTokenParser.class.php';
		return array(
			new BRJ_EnqueueTokenParser('enqueue'),
			new BRJ_EnqueueTokenParser('register'),
			new BRJ_EnqueueTokenParser('style'),
			new BRJ_EnqueueTokenParser('script')
		);
	}
}
?>