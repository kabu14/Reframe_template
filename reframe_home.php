<?php
/*
 * Author: Reframe
 * From: http://reframemarketing.com
 * Facebook:
 * Twitter:
 * Description: Reframe home page options
 */
add_action( 'after_setup_theme', 'reframe_home_options' );
function reframe_home_options() {
	// Check whether or not the 'reframe_home' exists
	// If not, create new one.
    if ( ! get_option( 'reframe_home' ) ) {
        $options = array(
            'logo' => '',
            'home' => '',
            'radio_menu' => '',
            'color' => '',
            'search' => '',
        );
        update_option( 'reframe_home', $options );
    }     
}

add_action( 'admin_menu', 'reframe_home_add_page' );
function reframe_home_add_page() {
    $reframe_home_options_page = add_theme_page( 'Reframe Home', 'Reframe Home', 'manage_options', 'reframe_home', 'reframe_home_options_page' );
    add_action( 'admin_print_scripts-' . $reframe_home_options_page, 'reframe_home_print_scripts' );
} 
function reframe_home_options_page() {
?>
    <div class='wrap'>
        <div id='icon-tools' class='icon32'></br></div>
        <h2>Reframe Home Page Options</h2>
        <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) : ?>
        <div class='updated'><p><strong>Settings saved.</strong></p></div>
        <?php endif; ?>
        <form action='options.php' method='post'>
            <?php settings_fields( 'reframe_home' ); ?>
            <?php do_settings_sections( 'reframe_home' ); ?>
            <p class="submit">
					<input name="reframe_home[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'reframe_home'); ?>" />
					<input name="reframe_home[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'reframe_home'); ?>" />		
				</p>
        </form>
    </div>
<?php 
}

add_action( 'admin_init', 'reframe_home_add_options' );

function reframe_home_add_options() {
    register_setting( 'reframe_home', 'reframe_home', 'reframe_home_options_validate' );
    add_settings_section( 'reframe_home_section', 'Home Page', 'reframe_home_section_callback', 'reframe_home' );
	add_settings_field( 'reframe_home_preview', 'Preview', 'reframe_home_preview_callback', 'reframe_home', 'reframe_home_section' ); 
	add_settings_field( 'reframe_home_menu', 'Menu', 'reframe_home_menu_callback', 'reframe_home', 'reframe_home_section' ); 
	add_settings_field( 'reframe_home_search', 'Search', 'reframe_home_search_callback', 'reframe_home', 'reframe_home_section' );    
    add_settings_field( 'reframe_home_color', 'Header Text', 'reframe_home_color_callback', 'reframe_home', 'reframe_home_section' );
    add_settings_field( 'reframe_home_logo', 'Logo Image', 'reframe_home_logo_callback', 'reframe_home', 'reframe_home_section' );
	add_settings_field( 'reframe_home_home', 'Home Page Header', 'reframe_home_home_callback', 'reframe_home', 'reframe_home_section' );
}


//Only uncomment the delete_image parts if you want to be able to delete images from the database as well.
function reframe_home_options_validate($values) {

	$default_options = reframe_home_options();
	$valid_input = $default_options;
	
	$reframe_home = get_option('reframe_home');
	
	
	$submit = ! empty($values['submit']) ? true : false;
	$reset = ! empty($values['reset']) ? true : false;
	$delete_logo = ! empty($values['delete_logo']) ? true : false;
	$delete_home = ! empty($values['delete_home']) ? true : false;
	
	if ( $submit ) {
		$valid_input['logo'] = strip_tags( stripslashes($values['logo']));

		$valid_input['home'] = strip_tags( stripslashes($values['home']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = isset($values['search']) ? strip_tags( stripslashes($values['search'])) : false;
	}
	elseif ( $reset ) {
		//delete_image( $reframe_home['logo'] );
		//delete_image( $reframe_home['def_header'] );
		//delete_image( $reframe_home['home'] );
		$valid_input['logo'] = $default_options['logo'];
		$valid_input['home'] = $default_options['logo'];
		$valid_input['radio_menu'] = $default_options['radio_menu'];
		$valid_input['color'] = $default_options['color'];
		$valid_input['search'] = $default_options['search'];
	}
	elseif ( $delete_logo ) {
		//delete_image( $reframe_home['logo'] );
		$valid_input['logo'] = '';
		$valid_input['home'] = strip_tags( stripslashes($values['home']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = strip_tags( stripslashes($values['search']));
	}
	elseif ( $delete_home ) {
		//delete_image( $reframe_home['home'] );
		$valid_input['home'] = '';
		$valid_input['logo'] = strip_tags( stripslashes($values['logo']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = strip_tags( stripslashes($values['search']));
	}
	else {
		
	}
	
	return $valid_input;
}

//This function is to delete the image from the database. Since we're not deleteing images from the library this function is not being used.  
function delete_image( $image_url ) {
	global $wpdb;
	
	// We need to get the image's meta ID..
	$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";  
	$results = $wpdb -> get_results($query);

	// And delete them (if more than one attachment is in the Library
	foreach ( $results as $row ) {
		wp_delete_attachment( $row -> ID );
	}	
}

function reframe_home_section_callback() { /* Print nothing */ };

function reframe_home_preview_callback () {
	$options = get_option( 'reframe_home' );
	$home_options = get_option( 'reframe_options' ); 
	?>
	<?php if ( $options['logo'] != '') : ?>
			<img style='padding: 20px; max-width: 300px; max-height: 100px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
	<?php else:?>
			<p style="color: <?php echo $options['color']; ?>; padding-left: 20px;"><?php bloginfo( 'name' ) ?></p>
	<?php endif; ?>		
	<!--Show the menu bar depending on if the user selected above or below the header image. 1 is menu below the banner.-->
	<?php if ($options['radio_menu'] == 1) : ?>
		<?php if ( $options['home'] != '') : ?>
				<img style='width: 1000px; display: block;' src='<?php echo esc_url($options["home"]); ?>' class='preview-upload'/>
		<?php else: ?>			
				<img style='width: 1000px; display: block;' src='<?php echo esc_url($home_options["def_header"]); ?>' class='preview-upload'/>
		<?php endif; ?>	
				<div style="height: 40px; background: black; width: 1000px;">
					<p style="line-height: 40px; padding-left: 72px; margin: 0; color: white;">Home</p>
				</div>
	<?php else: ?>	
				
				<div style="height: 40px; background: black; width: 1000px;">
					<p style="line-height: 40px; padding-left: 72px; margin: 0; color: white;">Home</p>					
				</div>
				<?php if ( $options['home'] != '') : ?>
				<img style='width: 1000px; display: block;' src='<?php echo esc_url($options["home"]); ?>' class='preview-upload'/>
		<?php else: ?>			
				<img style='width: 1000px; display: block;' src='<?php echo esc_url($home_options["def_header"]); ?>' class='preview-upload'/>
		<?php endif; ?>	
	<?php endif; ?>
		
	<?php	
}


function reframe_home_menu_callback () {
	$options = get_option( 'reframe_home' );
	$html = '<input type="radio" id="menu_below" name="reframe_home[radio_menu]" value="1"' . checked( 1, $options['radio_menu'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="menu_below">Below Header Image</label>';
	
	$html .= '<input type="radio" id="menu_above" name="reframe_home[radio_menu]" value="2"' . checked( 2, $options['radio_menu'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="menu_above">Above Header Image</label>';
	
	echo $html;	
}

function reframe_home_search_callback () {
	$options = get_option( 'reframe_home' );
	$html = '<input type="checkbox" id="reframe_home-search" name="reframe_home[search]" value="1"' . checked( 1, $options['search'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="reframe_home-search">Show search bar.</label>';
	
	echo $html;	
}

function reframe_home_color_callback() {
    $options = get_option( 'reframe_home' ); 
?>
        <p>Choose a color:</p>
        <input type="text" value='<?php echo esc_url($options["color"]); ?>' class="wp-color-picker-field" data-default-color="#ffffff" name='reframe_home[color]' />

<?php
}

function reframe_home_logo_callback() {
    $options = get_option( 'reframe_home' ); 
?>
    <span class='upload'>
    	<img style='max-width: 300px; max-height: 100px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
        <input style="display:none;" type='text' id='reframe_home_logo' class='regular-text text-upload' name='reframe_home[logo]' value='<?php echo esc_url($options["logo"]); ?>'/>
        <p>Choose an image from your media library or upload one:</p>
        <input type='button' class='button button-upload' value='Choose Image'/>
        <?php if ( '' != $options['logo'] ): ?>
			<input id="delete_logo_button" name="reframe_home[delete_logo]" type="submit" class="button" value="<?php _e( 'Remove Image', 'reframe_home' ); ?>" />
		<?php endif; ?>
        
    </span>
<?php
}

function reframe_home_home_callback() {
    $options = get_option( 'reframe_home' ); 
?>

    <span class='upload'>
    	<img style='max-width: 1000px; display: block;' src='<?php echo esc_url($options["home"]); ?>' class='preview-upload'/>
        <input style="display:none;" type='text' id='reframe_home_home' class='regular-text text-upload' name='reframe_home[home]' value='<?php echo esc_url($options["home"]); ?>'/>
        <p>Choose an image from your media library or upload one:</p>
        <input type='button' class='button button-upload' value='Choose Image'/>
        <?php if ( '' != $options['home'] ): ?>
			<input id="delete_home_button" name="reframe_home[delete_home]" type="submit" class="button" value="<?php _e( 'Remove Image', 'reframe_home' ); ?>" />
		<?php endif; ?>
        
    </span>
  
<?php
}

function reframe_home_print_scripts() {
    wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_media(); // Add this to invoke the 3.5 Media Uploader in our custom page.
    wp_enqueue_script( 'reframe_home-upload', get_stylesheet_directory_uri() . '/reframe-upload.js', array( 'thickbox', 'media-upload' ) );
}

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker-script', get_stylesheet_directory_uri() . '/js/script.js', array( 'wp-color-picker' ), false, true );
}

/* Favicon can be added here. Code needs to be changed. Look at nettuts 
function reframe_home_add_def_header() {
	$reframe_home = get_option( 'reframe_home' );
	$reframe_home_def_header = $reframe_home['def_header'];
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($reframe_home_def_header); ?>">
<?php
}
add_action( 'wp_head', 'reframe_home_add_def_header' );
*/
?>
