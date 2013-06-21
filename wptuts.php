<?php
/*
 * Author: Reframe
 * From: http://reframemarketing.com
 * Facebook:
 * Twitter:
 * Description: Reframe home page options
 */
add_action( 'after_setup_theme', 'inspiration_default_options' );
function inspiration_default_options() {
	// Check whether or not the 'inspiration_options' exists
	// If not, create new one.
    if ( ! get_option( 'inspiration_options' ) ) {
        $options = array(
            'logo' => '',
            'home' => '',
            'radio_menu' => '',
            'color' => '',
            'search' => '',
        );
        update_option( 'inspiration_options', $options );
    }     
}

add_action( 'admin_menu', 'inspiration_add_page' );
function inspiration_add_page() {
    $inspiration_options_page = add_theme_page( 'Reframe Home', 'Reframe Home', 'manage_options', 'inspiration', 'inspiration_options_page' );
    add_action( 'admin_print_scripts-' . $inspiration_options_page, 'inspiration_print_scripts' );
} 
function inspiration_options_page() {
?>
    <div class='wrap'>
        <div id='icon-tools' class='icon32'></br></div>
        <h2>Reframe Home Page Options</h2>
        <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) : ?>
        <div class='updated'><p><strong>Settings saved.</strong></p></div>
        <?php endif; ?>
        <form action='options.php' method='post'>
            <?php settings_fields( 'inspiration_options' ); ?>
            <?php do_settings_sections( 'inspiration' ); ?>
            <p class="submit">
					<input name="inspiration_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'inspiration'); ?>" />
					<input name="inspiration_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'inspiration'); ?>" />		
				</p>
        </form>
    </div>
<?php 
}

add_action( 'admin_init', 'inspiration_add_options' );

function inspiration_add_options() {
    register_setting( 'inspiration_options', 'inspiration_options', 'inspiration_options_validate' );
    add_settings_section( 'inspiration_section', 'Home Page', 'inspiration_section_callback', 'inspiration' );
	add_settings_field( 'inspiration_preview', 'Preview', 'inspiration_preview_callback', 'inspiration', 'inspiration_section' ); 
	add_settings_field( 'inspiration_menu', 'Menu', 'inspiration_menu_callback', 'inspiration', 'inspiration_section' ); 
	add_settings_field( 'inspiration_search', 'Search', 'inspiration_search_callback', 'inspiration', 'inspiration_section' );    
    add_settings_field( 'inspiration_color', 'Header Text', 'inspiration_color_callback', 'inspiration', 'inspiration_section' );
    add_settings_field( 'inspiration_logo', 'Logo Image', 'inspiration_logo_callback', 'inspiration', 'inspiration_section' );
	add_settings_field( 'inspiration_home', 'Home Page Header', 'inspiration_home_callback', 'inspiration', 'inspiration_section' );
}


//Only uncomment the delete_image parts if you want to be able to delete images from the database as well.
function inspiration_options_validate($values) {

	$default_options = inspiration_default_options();
	$valid_input = $default_options;
	
	$inspiration_options = get_option('inspiration_options');
	
	
	$submit = ! empty($values['submit']) ? true : false;
	$reset = ! empty($values['reset']) ? true : false;
	$delete_logo = ! empty($values['delete_logo']) ? true : false;
	$delete_home = ! empty($values['delete_home']) ? true : false;
	
	if ( $submit ) {
		$valid_input['logo'] = strip_tags( stripslashes($values['logo']));
		$valid_input['def_header'] = strip_tags( stripslashes($values['def_header']));
		$valid_input['home'] = strip_tags( stripslashes($values['home']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = strip_tags( stripslashes($values['search']));
	}
	elseif ( $reset ) {
		//delete_image( $inspiration_options['logo'] );
		//delete_image( $inspiration_options['def_header'] );
		//delete_image( $inspiration_options['home'] );
		$valid_input['logo'] = $default_options['logo'];
		$valid_input['def_header'] = $default_options['def_header'];
		$valid_input['home'] = $default_options['logo'];
		$valid_input['radio_menu'] = $default_options['radio_menu'];
		$valid_input['color'] = $default_options['color'];
		$valid_input['search'] = $default_options['search'];
	}
	elseif ( $delete_logo ) {
		//delete_image( $inspiration_options['logo'] );
		$valid_input['logo'] = '';
		$valid_input['def_header'] = strip_tags( stripslashes($values['def_header']));
		$valid_input['home'] = strip_tags( stripslashes($values['home']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = strip_tags( stripslashes($values['search']));
	}
	elseif ( $delete_home ) {
		//delete_image( $inspiration_options['home'] );
		$valid_input['home'] = '';
		$valid_input['logo'] = strip_tags( stripslashes($values['logo']));
		$valid_input['def_header'] = strip_tags( stripslashes($values['def_header']));
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

function inspiration_section_callback() { /* Print nothing */ };

function inspiration_preview_callback () {
	$options = get_option( 'inspiration_options' );
	$home_options = get_option( 'reframe_options' ); 
	?>
	<?php if ( $options['logo'] != '') : ?>
			<img style='padding: 20px; max-width: 300px; max-height: 100px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
	<?php else:?>
			<p style="color: <?php echo $options['color']; ?>; padding-left: 20px;">Inspiration Centre</p>
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


function inspiration_menu_callback () {
	$options = get_option( 'inspiration_options' );
	$html = '<input type="radio" id="menu_below" name="inspiration_options[radio_menu]" value="1"' . checked( 1, $options['radio_menu'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="menu_below">Below Header Image</label>';
	
	$html .= '<input type="radio" id="menu_above" name="inspiration_options[radio_menu]" value="2"' . checked( 2, $options['radio_menu'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="menu_above">Above Header Image</label>';
	
	echo $html;	
}

function inspiration_search_callback () {
	$options = get_option( 'inspiration_options' );
	$html = '<input type="checkbox" id="inspiration-search" name="inspiration_options[search]" value="1"' . checked( 1, $options['search'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="inspiration-search">Show search bar.</label>';
	
	echo $html;	
}

function inspiration_color_callback() {
    $options = get_option( 'inspiration_options' ); 
?>
        <p>Choose a color:</p>
        <input type="text" value='<?php echo esc_url($options["color"]); ?>' class="wp-color-picker-field" data-default-color="#ffffff" name='inspiration_options[color]' />

<?php
}

function inspiration_logo_callback() {
    $options = get_option( 'inspiration_options' ); 
?>
    <span class='upload'>
    	<img style='max-width: 300px; max-height: 100px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
        <input style="display:none;" type='text' id='inspiration_logo' class='regular-text text-upload' name='inspiration_options[logo]' value='<?php echo esc_url($options["logo"]); ?>'/>
        <p>Choose an image from your media library or upload one:</p>
        <input type='button' class='button button-upload' value='Choose Image'/>
        <?php if ( '' != $options['logo'] ): ?>
			<input id="delete_logo_button" name="inspiration_options[delete_logo]" type="submit" class="button" value="<?php _e( 'Remove Image', 'inspiration' ); ?>" />
		<?php endif; ?>
        
    </span>
<?php
}

function inspiration_home_callback() {
    $options = get_option( 'inspiration_options' ); 
?>

    <span class='upload'>
    	<img style='max-width: 1000px; display: block;' src='<?php echo esc_url($options["home"]); ?>' class='preview-upload'/>
        <input style="display:none;" type='text' id='inspiration_home' class='regular-text text-upload' name='inspiration_options[home]' value='<?php echo esc_url($options["home"]); ?>'/>
        <p>Choose an image from your media library or upload one:</p>
        <input type='button' class='button button-upload' value='Choose Image'/>
        <?php if ( '' != $options['home'] ): ?>
			<input id="delete_home_button" name="inspiration_options[delete_home]" type="submit" class="button" value="<?php _e( 'Remove Image', 'inspiration' ); ?>" />
		<?php endif; ?>
        
    </span>
  
<?php
}

function inspiration_print_scripts() {
    wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_media(); // Add this to invoke the 3.5 Media Uploader in our custom page.
    wp_enqueue_script( 'inspiration-upload', get_stylesheet_directory_uri() . '/reframe-upload.js', array( 'thickbox', 'media-upload' ) );
}

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker-script', get_stylesheet_directory_uri() . '/js/script.js', array( 'wp-color-picker' ), false, true );
}

function inspiration_add_def_header() {
	$inspiration_options = get_option( 'inspiration_options' );
	$inspiration_def_header = $inspiration_options['def_header'];
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($inspiration_def_header); ?>">
<?php
}
add_action( 'wp_head', 'inspiration_add_def_header' );
?>
