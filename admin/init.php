<?php 

function recooty_register_my_custom_menu_page(){
	$icon = plugins_url( "img/icon.png" , RECOOTY_FILE);
    add_menu_page( 
        __( 'Recooty', 'recooty' ),
        __( 'Recooty' , 'recooty'),
        'manage_options',
        'recooty',
        'recooty_menu_page',
        $icon
    ); 
}
add_action( 'admin_menu', 'recooty_register_my_custom_menu_page' );
 
/**
 * Display a custom menu page
 */
function recooty_menu_page(){
	recooty_save_maybe();
	?>
	<div class="recooty_container">
		<h1><?php _e("Recooty" , "recooty"); ?></h1>
		<hr>

		<div class="recooty_form">
			<form method="post">
				<label>
					Enter Recooty's Key: <input type="text" name="recooty_key" width="50" required="" value="<?php echo esc_attr(get_option('recooty_key'));  ?>">

				</label>
				<br>
				<br>
				<small>You can find your Recooty key from <a href="https://dash.recooty.com/settings/job-widget" target="_blank">here.</a></small>
				<br>
				<br>
				<input type="submit" name="recooty_submit" class="button button-primary" value="Save">
			</form>
		</div>
		<br>
		<hr>
		<div class="recooty_instruction">
			<h3>Instructions</h3>
				<p>
					1. Create a new career page if you don't already have one. 
				</p>
				<p>
					2. Use this Shortcode: <code>[recooty]</code> on your careers page.   				
				</p>
			
			<br><br>
			<?php 
				$url = "https://recooty.com";
				echo sprintf( 
					    __( 'If you need any help, <a href=%s target=_blank>click here</a> to contact us.', 'recooty' ), 
					    esc_url( $url ) 
					);
			?>
		</div>
	</div>
	<?php
}


function recooty_save_maybe() {

	if(isset($_POST["recooty_key"])) {

		$recooty_key = $_POST["recooty_key"];		
		
		if(!empty($recooty_key)) {
			update_option("recooty_key" , $recooty_key);
		}

	}

}


function recooty_admin_notice() {
	if(get_option("recooty_key")) return; 
	$url = site_url()."/wp-admin/admin.php?page=recooty";
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( sprintf('Please enter Recooty API key on the <a href="%s">settings page</a> to make Recooty work.' , $url), 'recooty' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'recooty_admin_notice' );



