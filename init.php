<?php 
/*
Plugin Name: Recooty - Modern Applicant Tracking System for Growing Companies
Plugin URI: https://recooty.com/
Description: WordPress plugin to integrate services of Recooty with your WordPress site.
Version: 1.0.4
Author: 
Author URI: https://recooty.com/
Text Domain: recooty
*/

define("RECOOTY_FILE", __FILE__);

require_once "admin/init.php";

class Recooty_Main {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array($this , "front_scripts") );
		add_action( 'admin_enqueue_scripts', array($this , "backend_scripts") );
		add_shortcode("recooty" , array($this , "shortcode"));
	}
	
	function front_scripts() {
	    wp_enqueue_style( 'recooty-css', plugins_url( "/css/style.css", __FILE__ ) );
		wp_enqueue_script( 'recooty-js', plugins_url( "/js/script.js", __FILE__ ) , array(), '1.0.0', true);
	}


	function backend_scripts() {
	    wp_enqueue_style( 'recooty-admin-css', plugins_url( "/css/admin.css", __FILE__ ) );
		//wp_enqueue_script( 'recooty-js', plugins_url( "/js/script.js", __FILE__ ) , array(), '1.0.0', true);
	}

	function shortcode() {
		$html = "";
		if($recooty_key = get_option("recooty_key")) {
			ob_start();
			?>
				<!-- Recooty Widget START-->
				<iframe id="iframe-container-1" width="100%" frameborder="0" scrolling="no" src="https://widget.recooty.com/openings.php?key=<?php echo $recooty_key; ?>"></iframe>
				<script>	
				window.addEventListener('message', function(e) {
					var data = e.data.split('-'),
						scroll_height = data[0],
						iframe_id = data[1];
					if(iframe_id == 'iframe1')
						document.getElementById('iframe-container-1').style.height = scroll_height + 'px'; } , false);
				</script>
				<!-- Recooty Widget END-->

			<?php 
			$html = ob_get_clean();
			return $html;
		}
	}
}

new Recooty_Main();



add_filter( 'plugin_action_links', 'recooty_add_custom_setting_link', 10, 5 );
function recooty_add_custom_setting_link( $actions, $plugin_file ) 
{
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	
	if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="admin.php?page=recooty">' . __('Settings', 'General') . '</a>');
		
    		$actions = array_merge($settings, $actions);
			
		}
		
		return $actions;
}