<?php
/*
Plugin Name: WP Widget Toggle
Plugin URI: https://github.com/nciske/WPWidgetToggle
Description: WP Widget Toggler
Author: Nick Ciske (ThoughtRefinery)
Version: 0.2
Author URI: http://thoughtrefinery.com/
*/

if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

add_action('wp_enqueue_scripts','wp_widget_toggle');

function wp_widget_toggle(){
	wp_enqueue_script( 'wp_widget_toggle', plugins_url('/js/wp-widget-toggle.js', __FILE__), array('jquery'), true );

	wp_localize_script( 'wp_widget_toggle', 'wpwt_data', get_option( 'wpwt_options', array() ) );

}

function wpwt_register_settings() {

	//add_option( 'wpwt_selectors', '.widget'); // all widgets by default
	//add_option( 'wpwt_start_open', '0'); // start closed by default

	register_setting( 'wpwt_options', 'wpwt_options', 'wpwt_validate' ); 

}
add_action( 'admin_init', 'wpwt_register_settings' );

function wpwt_register_options_page() {
	add_options_page('Widget Toggle', 'Widget Toggle', 'manage_options', 'wpwt-options', 'wpwt_options_page');
}
add_action('admin_menu', 'wpwt_register_options_page');

function wpwt_options_page() {
	?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Widget Toggle Options</h2>
	<form method="post" action="options.php"> 
		<?php settings_fields( 'wpwt_options' ); ?>
		
		<?php $options = get_option('wpwt_options'); ?>
		
<table class="form-table">
	<tr valign="top">
		<th scope="row">Initial View</th>
		<td><input type="checkbox" id="wpwt_options_start_open" name="wpwt_options[start_open]" value="1" <?php checked( $options['start_open'], 1 ); ?> /><label for="wpwt_options[start_open]">Keep widgets open when loaded</label></td>
		<td><i><small>Widgets are collapsed by default, check this to keep them open.</small></i></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpwt_options[selectors]">jQuery Selector(s)</label></th>
		<td><textarea rows="4" cols="40" id="wpwt_options_selectors" name="wpwt_options[selectors]" /><?php echo esc_textarea( $options['selectors'] ); ?></textarea></td>
		<td><small>Enter selectors here (one per line) to collapse only certain widgets or sidebars.<br><code>.widget</code> (the default if this is blank) will target all widgets on the page.</small></td>
	</tr>
</table>
			
		<?php submit_button(); ?>
	</form>
</div>
<?php
}

function wpwt_validate( $input ) {
    // Our first value is either 0 or 1
    $input['start_open'] = ( $input['start_open'] == 1 ? 1 : 0 );
    
    // Say our second option must be safe text with no HTML tags
    $input['selectors'] =  wp_filter_nohtml_kses($input['selectors']);
    
    return $input;
}