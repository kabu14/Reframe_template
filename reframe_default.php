<?php
/*
 * Author: Reframe
 * From: http://reframemarketing.com
 * Facebook:
 * Twitter:
 * Description: Reframe default options page
 */


add_action( 'after_setup_theme', 'Reframe_default_options' );
function reframe_default_options() {
	// Check whether or not the 'reframe_options' exists
	// If not, create new one.
    if ( ! get_option( 'reframe_options' ) ) {
        $options = array(
            'logo' => '',
            'def_header' => '',
            'radio_menu' => '',
            'color' => '',
            'search' => '',
        );
		//Used to update the options with the new values $options.
        update_option( 'reframe_options', $options );
    }     
}

add_action( 'admin_menu', 'reframe_add_page' );
function reframe_add_page() {
	// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
    $reframe_options_page = add_theme_page( 'Reframe Default', 'Reframe Default', 'manage_options', 'reframe', 'reframe_options_page' );
    add_action( 'admin_print_scripts-' . $reframe_options_page, 'reframe_print_scripts' );
} 
function reframe_options_page() {
?>
    <div class='wrap'>
        <div id='icon-tools' class='icon32'></br></div>
        <h2>Reframe Default Options</h2>
        <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) : ?>
        <div class='updated'><p><strong>Settings saved.</strong></p></div>
        <?php endif; ?>
        <form action='options.php' method='post'>
            <?php settings_fields( 'reframe_options' ); ?>
            <?php do_settings_sections( 'reframe' ); ?>
            <p class="submit">
					<input name="reframe_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'reframe'); ?>" />
					<input name="reframe_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'reframe'); ?>" />		
				</p>
        </form>
    </div>
<?php 
}

add_action( 'admin_init', 'reframe_add_options' );

function reframe_add_options() {
	//register_setting( $option_group(has to match settings_fields() above), $option_name(name of option to sanitize), $sanitize_callback );
    register_setting( 'reframe_options', 'reframe_options', 'reframe_options_validate' );
	//add_settings_section( $id, $title, $callback, $page );
    add_settings_section( 'reframe_section', 'Default', 'reframe_section_callback', 'reframe' );
	//add_settings_field( $id, $title, $callback, $page (should match the section $page), $section, $args );
	add_settings_field( 'reframe_preview', 'Preview', 'reframe_preview_callback', 'reframe', 'reframe_section' ); 
	add_settings_field( 'reframe_menu', 'Menu', 'reframe_menu_callback', 'reframe', 'reframe_section' ); 
	add_settings_field( 'reframe_search', 'Search', 'reframe_search_callback', 'reframe', 'reframe_section' );    
    add_settings_field( 'reframe_color', 'Header Text', 'reframe_color_callback', 'reframe', 'reframe_section' );
    add_settings_field( 'reframe_logo', 'Logo Image', 'reframe_logo_callback', 'reframe', 'reframe_section' );
    add_settings_field( 'reframe_def_header', 'Default Header', 'reframe_def_header_callback', 'reframe', 'reframe_section' );
}


//Only uncomment the delete_image parts if you want to be able to delete images from the database as well.
function reframe_options_validate($values) {

	$default_options = reframe_default_options();
	$valid_input = $default_options;
	
	$reframe_options = get_option('reframe_options');
	
	
	$submit = ! empty($values['submit']) ? true : false;
	$reset = ! empty($values['reset']) ? true : false;
	$delete_logo = ! empty($values['delete_logo']) ? true : false;
	$delete_def_head = ! empty($values['delete_def_header']) ? true : false;
	
	if ( $submit ) {
		$valid_input['logo'] = strip_tags( stripslashes($values['logo']));
		$valid_input['def_header'] = strip_tags( stripslashes($values['def_header']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = strip_tags( stripslashes($values['search']));
	}
	elseif ( $reset ) {
		//delete_image( $reframe_options['logo'] );
		//delete_image( $reframe_options['def_header'] );
		//delete_image( $reframe_options['home'] );
		$valid_input['logo'] = $default_options['logo'];
		$valid_input['def_header'] = $default_options['def_header'];
		$valid_input['radio_menu'] = $default_options['radio_menu'];
		$valid_input['color'] = $default_options['color'];
		$valid_input['search'] = $default_options['search'];
	}
	elseif ( $delete_logo ) {
		//delete_image( $reframe_options['logo'] );
		$valid_input['logo'] = '';
		$valid_input['def_header'] = strip_tags( stripslashes($values['def_header']));
		$valid_input['radio_menu'] = $values['radio_menu'];
		$valid_input['color']  = sanitize_text_field($values['color']);
		$valid_input['search'] = strip_tags( stripslashes($values['search']));
	}
	elseif ( $delete_def_head ) {
		//delete_image( $reframe_options['def_header'] );
		$valid_input['def_header'] = '';
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
/*
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
*/
function reframe_section_callback() { /* Print nothing */ };

function reframe_preview_callback () {
	$options = get_option( 'reframe_options' ); 
	?>
	<?php if ( $options['logo'] != '') : ?>
			<img style='padding: 20px; max-width: 300px; max-height: 100px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
	<?php else:?>
			<p style="color: <?php echo $options['color']; ?>; padding-left: 20px;"><?php bloginfo( 'name' ) ?></p>
	<?php endif; ?>		
	<!--Show the menu bar depending on if the user selected above or below the header image. 1 is menu below the banner.-->
	<?php if ($options['radio_menu'] == 1) : ?>
		<img style='width: 1000px; display: block;' src='<?php echo esc_url($options["def_header"]); ?>' class='preview-upload'/>

		<div style="height: 40px; background: black; width: 1000px;">
			<p style="line-height: 40px; padding-left: 72px; margin: 0; color: white;">Home</p>
		</div>
	<?php else: ?>		
		<div style="height: 40px; background: black; width: 1000px;">
			<p style="line-height: 40px; padding-left: 72px; margin: 0; color: white;">Home</p>					
		</div>
				
		<img style='width: 1000px; display: block;' src='<?php echo esc_url($options["def_header"]); ?>' class='preview-upload'/>
	<?php endif; ?>
		
	<?php	
}


function reframe_menu_callback () {
	$options = get_option( 'reframe_options' );
	$html = '<input type="radio" id="menu_below" name="reframe_options[radio_menu]" value="1"' . checked( 1, $options['radio_menu'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="menu_below">Below Header Image</label>';
	
	$html .= '<input type="radio" id="menu_above" name="reframe_options[radio_menu]" value="2"' . checked( 2, $options['radio_menu'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="menu_above">Above Header Image</label>';
	
	echo $html;	
}

function reframe_search_callback () {
	$options = get_option( 'reframe_options' );
	$html = '<input type="checkbox" id="reframe-search" name="reframe_options[search]" value="1"' . checked( 1, $options['search'], false ) . '/>';
	$html .= '<label style="padding: 0 10px 0;" for="reframe-search">Show search bar.</label>';
	
	echo $html;	
}

function reframe_color_callback() {
    $options = get_option( 'reframe_options' ); 
?>
        <p>Choose a color:</p>
        <input type="text" value='<?php echo esc_url($options["color"]); ?>' class="wp-color-picker-field" data-default-color="#ffffff" name='reframe_options[color]' />

<?php
}

function reframe_logo_callback() {
    $options = get_option( 'reframe_options' ); 
?>
    <span class='upload'>
    	<img style='max-width: 300px; max-height: 100px; display: block;' src='<?php echo esc_url($options["logo"]); ?>' class='preview-upload'/>
        <input style="display:none;" type='text' id='reframe_logo' class='regular-text text-upload' name='reframe_options[logo]' value='<?php echo esc_url($options["logo"]); ?>'/>
        <p>Choose an image from your media library or upload one:</p>
        <input type='button' class='button button-upload' value='Choose Image'/>
        <?php if ( '' != $options['logo'] ): ?>
			<input id="delete_logo_button" name="reframe_options[delete_logo]" type="submit" class="button" value="<?php _e( 'Remove Image', 'reframe' ); ?>" />
		<?php endif; ?>
        
    </span>
<?php
}

function reframe_def_header_callback() {
    $options = get_option( 'reframe_options' ); 
?>

    <span class='upload'>
    	<img style='max-width: 1000px; display: block;' src='<?php echo esc_url($options["def_header"]); ?>' class='preview-upload'/>
        <input style="display:none;" type='text' id='reframe_def_header' class='regular-text text-upload' name='reframe_options[def_header]' value='<?php echo esc_url($options["def_header"]); ?>'/>
        <p>Choose an image from your media library or upload one:</p>
        <input type='button' class='button button-upload' value='Choose Image'/>
        <?php if ( '' != $options['def_header'] ): ?>
			<input id="delete_logo_button" name="reframe_options[delete_def_header]" type="submit" class="button" value="<?php _e( 'Remove Image', 'reframe' ); ?>" />
		<?php endif; ?>
        
    </span>
  
<?php
}


function reframe_print_scripts() {
    wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_media(); // Add this to invoke the 3.5 Media Uploader in our custom page.
    wp_enqueue_script( 'reframe-upload', get_stylesheet_directory_uri() . '/reframe-upload.js', array( 'thickbox', 'media-upload' ) );
}


/* Favicon can be added here. Code needs to be changed. Look at nettuts 
function reframe_add_def_header() {
	$reframe_options = get_option( 'reframe_options' );
	$reframe_def_header = $reframe_options['def_header'];
?>
	<link rel="icon" type="image/png" href="<?php echo esc_url($reframe_def_header); ?>">
<?php
}
add_action( 'wp_head', 'reframe_add_def_header' );
*/
?>
