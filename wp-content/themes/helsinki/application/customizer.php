<?php
/**
 * Feature Name: Customizer Stuff for Helsinki
 * Version:	  1.0
 * Author:	   MarketPress.com
 * Author URI:   http://marketpress.com/
 */

/**
 * Register the marketpress specific customizer options. In our
 * case it is a simple color picker to set a specific
 * key color.
 *
 * @param object $wp_customize
 * @return void
 */
function helsinki_register_customizer_sections( $wp_customize ) {

	// add section for the color switch to set the key colors
	$enabled_key_color = apply_filters( 'helsinki_register_customizer_sections_key_color', TRUE );
	if ( $enabled_key_color ) {
		$wp_customize->add_section( 'colors' , array(
			'title'	   => __( 'Colors', 'helsinki' ),
			'priority'=> 5,
		) );
		$wp_customize->add_setting( 'key_color', array(
			'default'           => apply_filters( 'helsinki_customizer_default_key_color', '#0084cc' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'helsinki_sanitize_color'
		) );
		$wp_customize->add_setting( 'footer_link_color', array(
			'default'           => apply_filters( 'helsinki_customizer_default_footer_link_color', '#d36037' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'helsinki_sanitize_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'key_color', array(
			'label'	      => __( 'Key Color', 'helsinki' ),
			'description' => __( 'The key color is the main color of the website. Usually it is the color of the links, hovers and backgrounds.', 'helsinki' ),
			'section'     => 'colors',
			'settings'    => 'key_color',
		) ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_link_color', array(
			'label'	      => __( 'Footer Link Color', 'helsinki' ),
			'description' => __( 'This color is for the links in the footer area of the website.', 'helsinki' ),
			'section'     => 'colors',
			'settings'    => 'footer_link_color',
		) ) );
	}

	// add section for the custom logo
	$enabled_logo = apply_filters( 'helsinki_register_customizer_sections_logo', TRUE );
	if ( $enabled_logo ) {
		$wp_customize->add_section( 'helsinki_logo_section', array (
			'title'	      => __( 'Logo', 'helsinki' ),
			'priority'    => 6,
			'description' => __( 'Upload a logo which usually replaces the default site name and description in the header', 'helsinki' )
		) );
		$wp_customize->add_setting( 'helsinki_logo', array (
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize,
				'helsinki_logo',
				array (
					'label'	=> __( 'Logo', 'helsinki' ),
					'section'  => 'helsinki_logo_section',
					'settings' => 'helsinki_logo'
				)
			)
		);
	}

	// adding a new section to the customizer
	$enabled_social_icons = apply_filters( 'helsinki_register_customizer_sections_social_icons', TRUE );
	if ( $enabled_social_icons ) {
		$wp_customize->add_section(
			'social_icons_section',
			array (
				'title'	      => __( 'Social Media Icons', 'helsinki' ),
				'description' => __( 'In this Section you can enter your Social-Media-Channels to show them in your Theme. To do so, add the URL to your profiles in the inputs below.', 'helsinki' ),
				'priority'	  => 7,
			)
		);
		$settings = helsinki_get_social_medias();
		if ( ! is_array( $settings ) || count( $settings ) < 1 )
			return;

		foreach ( $settings as $id => $setting ) {

			$option_key = 'social_icons_section' . '[' . $id . ']';
			// adding a new setting to the database
			$wp_customize->add_setting( $id, array (
				'default'		   => '',
				'sanitize_callback' => 'esc_url_raw'
			) );
			$control_args = array (
				'label'	=> $setting[ 'label' ],
				'section'  => 'social_icons_section',
				'settings' => $id
			);
			$control = new WP_Customize_Control(
				$wp_customize,
				$option_key,
				$control_args
			);
			$wp_customize->add_control( $control );
		}
	}
}

/**
 * Saves the customized CSS if there is setted
 * a color in the customizer
 * 
 * @param	object the WordPress Customize Manager
 * @return	void
 */
function helsinki_save_custom_css_file( WP_Customize_Manager $wp_customize ) {
	global $wp_filesystem;

	// Initialize the WP filesystem, no more using 'file-put-contents' function
	if ( empty( $wp_filesystem ) ) {
	    require_once ( ABSPATH . '/wp-admin/includes/file.php' );
	    WP_Filesystem();
	}

	$color = get_theme_mod( 'key_color' );
	if ( empty( $color ) )
		$color = apply_filters( 'helsinki_customizer_default_key_color', '#0084cc' );
	$footer_link_color = get_theme_mod( 'footer_link_color' );
	if ( empty( $footer_link_color ) )
		$footer_link_color = apply_filters( 'helsinki_customizer_default_footer_link_color', '#d36037' );

	$color_rgb = helsinki_hex_to_rgb( $color );
	$color_rgb = $color_rgb[ 0 ] . ', ' . $color_rgb[ 1 ] . ', ' . $color_rgb[ 2 ];

	// set the output file folders
		// get directory
	$upload_dir = wp_upload_dir();
	$upload_basedir = $upload_dir[ 'basedir' ];
	$customize_file_dir = $upload_basedir . '/helsinki/';
	if ( ! is_dir( $customize_file_dir ) )
		mkdir( $customize_file_dir );

	$output_file = $customize_file_dir . 'customize.css';
	if ( ! file_exists( $output_file ) )
		touch( $output_file );

	$output_file_min = $customize_file_dir . 'customize.min.css';
	if ( ! file_exists( $output_file_min ) )
		touch( $output_file_min );

	// Load the CSS via filter
	$css = apply_filters( 'helsinki_customized_css_file', '', $color, $color_rgb, $footer_link_color );
	// writing stuff to output
	$wp_filesystem->put_contents( $output_file, $css );

	// minify css
	// Remove comments
	$css_min = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
	// Remove space after colons
	$css_min = str_replace( ': ', ':', $css_min );
	// Remove whitespace
	$css_min = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '	', '	' ), '', $css_min );
	// remove ' {'
	$css_min = str_replace( ' {', '{', $css_min );
	// remove ;}
	$css_min = str_replace( ';}', '}', $css_min );
	// remove ', '
	$css_min = str_replace( ', ', ',', $css_min );
	// remove '( '
	$css_min = str_replace( '( ', '(', $css_min );
	// remove ' )'
	$css_min = str_replace( ' )', ')', $css_min );

	// writing stuff to output
	$wp_filesystem->put_contents( $output_file_min, $css_min );
}

/**
 * Gets the CSS file generated by the customizer
 * 
 * @return	string the url to the css file 
 */
function helsinki_get_custom_css_file_url() {

	// get directory
	$upload_dir = wp_upload_dir();
	$upload_basedir = $upload_dir[ 'baseurl' ];
	$customize_file_dir = $upload_basedir . '/helsinki/';
	if ( ! is_dir( $customize_file_dir ) )
		mkdir( $customize_file_dir );

	// get suffix
	$suffix  = helsinki_get_script_suffix();

	// get file
	$file = $customize_file_dir . 'customize' . $suffix . '.css';
	return $file;
}

/**
 * Prints the customized CSS if there is setted
 * a color in the customizer
 * 
 * @wp-hook	helsinki_customized_css_file
 * @return	string the css
 */
function helsinki_customized_css_file( $output, $color, $color_rgb, $footer_link_color ) {

	ob_start();
	?>
/**
 * Feature Name: Customizer-Styles
 * Version:      1.0
 * Author:       MarketPress.com
 * Author URI:   http://marketpress.com
 */

a,
body main#primary article .comments a:hover,
body main#primary article .comments a:focus,
body main#primary article .comments a:hover {
	color: <?php echo $color; ?>;
}

#headline nav ul li:hover a,
#headline nav ul li:focus a,
#headline nav ul li a.active,
#headline nav ul li.current-menu-item a,
#headline .menu ul li:hover a,
#headline .menu ul li:focus a,
#headline .menu ul li a.active,
#headline .menu ul li.current-menu-item a,
body main#primary article .comments a .count,
.pagination ul li .current,
.pagination ul li a:hover,
.pagination ul li a:focus,
.pagination ul li a.active,
.toggle-mobile-menu:hover,
.toggle-mobile-menu:focus,
.toggle-mobile-menu.active,
#headline .sub-menu,
#headline li:hover .sub-menu,
#headline li .sub-menu,
#headline nav ul li.current_page_parent a,
#headline nav ul li.current_page_ancestor a,
#headline .menu ul li.current_page_parent a,
#headline .menu ul li.current_page_ancestor a {
	background: <?php echo $color; ?>;
}

body .copyline a,
body footer#footer a {
	color: <?php echo $footer_link_color; ?>;
}
	<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}

/**
 * Sanitizes the color
 * 
 * @return	boolean
 */
function helsinki_sanitize_color( $color ) {

	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return NULL;
}
