<?php
/** Step 2 (from text above). */
add_action( 'admin_menu', 'jds_ga_menu' );

/** Step 1. */
function jds_ga_menu() {
	add_menu_page( 'Analytics', 'Google Analytics', 'administrator', 'jds_ga_home', 'jds_ga_dashboard_widget_function' );
}

/** Step 3. */
function jds_ga_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}
?>

