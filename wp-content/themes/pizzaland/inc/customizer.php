<?php
function pizzaland_customize_register( $wp_customize ) {
    /*
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}
    
    //Remove the Colors section from the Customizer preview
    $wp_customize->remove_section( 'colors' );
    
    //Add JS live preview to Background Image
    $wp_customize->get_setting( 'background_image' )->transport = 'postMessage';
    
    //Add section to customizer for color schemes
    $wp_customize->add_section(
        // $id
        'pizzaland_color_schemes',
        // $args
        array(
            'title'			=> __( 'Color Schemes', 'pizzaland' ),
            'description'	=> __( 'Color schemes for your theme', 'pizzaland' ),
            'priority'      => 70,
			'capability' => 'edit_theme_options',
        )
	);
    
    //Add setting for color schemes 
	$wp_customize->add_setting( 'pizzaland_colorschemes_setting' , array(
		'default'     => 'green-red',
		'type' => 'theme_mod',
        'transport' => 'postMessage',
		'sanitize_callback'    => 'pizzaland_sanitize_select',
		'capability' => 'edit_theme_options',
	) );
    
    //Add select control for color schemes
    $wp_customize->add_control(
		// $id
		'pizzaland_color_scheme',
		// $args
		array(
			'settings'		=> 'pizzaland_colorschemes_setting',
			'section'		=> 'pizzaland_color_schemes',
			'type'			=> 'select',
			'label'			=> __( 'Pick a color scheme', 'pizzaland' ),
			'choices'		=> array(
				'green-red' => __( 'Green Red (default)', 'pizzaland' ),
				'blue-gray-amber' => __( 'Blue Gray Amber', 'pizzaland' ),
				'indigo-lime' => __( 'Indigo Lime', 'pizzaland' ),
                'pink-amber' => __( 'Pink Amber', 'pizzaland' ),
			)
		)
	);
    
    //Add section to customizer for footer area
    $wp_customize->add_section(
        // $id
        'pizzaland_footer',
        // $args
        array(
            'title'			=> __( 'Footer Options', 'pizzaland' ),
            'description'	=> __( 'Customize footer area', 'pizzaland' ),
            'priority'      => 80,
			'capability' => 'edit_theme_options',
        )
	);
    
    //Add setting to change left column text in footer 
	$wp_customize->add_setting( 'pizzaland_footer_left_col' , array(
		'default'     => '',
		'type' => 'theme_mod',
        'transport' =>  'postMessage',
		'sanitize_callback'    => 'pizzaland_sanitize_html',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to change left column text in footer
	$wp_customize->add_control('pizzaland_leftcol_footertext_control', array(
		'label' => __( 'Add the text for the left column of your footer', 'pizzaland' ),
		'section' => 'pizzaland_footer',
		'settings' => 'pizzaland_footer_left_col',
		'type' => 'textarea',
	) );
    
    //Add setting to change right column text in footer 
	$wp_customize->add_setting( 'pizzaland_footer_right_col' , array(
		'default'     => '',
		'type' => 'theme_mod',
        'transport' =>  'postMessage',
		'sanitize_callback'    => 'pizzaland_sanitize_html',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to change right column text in footer 
	$wp_customize->add_control('pizzaland_rightcol_footertext_control', array(
		'label' => __( 'Add the text for the right column of your footer', 'pizzaland' ),
		'section' => 'pizzaland_footer',
		'settings' => 'pizzaland_footer_right_col',
		'type' => 'textarea',
	) );
    
    //Add setting to change text in footer credit link at the very bottom 
	$wp_customize->add_setting( 'pizzaland_footer_link' , array(
		'default'     => '',
		'type' => 'theme_mod',
        'transport' =>  'postMessage',
		'sanitize_callback'    => 'pizzaland_sanitize_html',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to hide credit link in footer
	$wp_customize->add_control('pizzaland_footer_link_control', array(
		'label' => __( 'Add your own credits in the footer', 'pizzaland' ),
		'section' => 'pizzaland_footer',
		'settings' => 'pizzaland_footer_link',
		'type' => 'text',
	) );
    
    /**
    * Add Panel for Restaurant Front Page: this panel shows up only if the Food and Drink Menu 
    * and the Testimonials Widget plugins have been activated, we're on the Home page, 
    * and we're using the Restaurant Homepage template
    */
    $wp_customize->add_panel(
		// $id
		'pizzaland_frontpage_panel',
		// $args
		array(
			'priority' 			=> 160,
			'capability' 		=> 'edit_theme_options',
			'title' 			=> __( 'Front Page Customization', 'pizzaland' ),
			'description' 		=> __( 'Customization options for the Restaurant Home Page', 'pizzaland' ),
            'active_callback' => 'pizzaland_show_frontpage_panel',
			'capability' => 'edit_theme_options',
		)
	);
    
    //Add section to customizer for call to action button below the menus selection
    $wp_customize->add_section(
        // $id
        'pizzaland_menu_button_section',
        // $args
        array(
            'title'			=> __( 'Menus Button', 'pizzaland' ),
            'description'	=> __( 'Customize the call to action button below the menus selection', 'pizzaland' ),
            'priority'      => 10,
            'panel'         => 'pizzaland_frontpage_panel',
			'capability' => 'edit_theme_options',
        )
	);
    
    
    //Add setting to add text to the call to action button below the menu selection
	$wp_customize->add_setting( 'pizzaland_menus_button_text' , array(
		'default'     => __( 'View all Menus', 'pizzaland' ),
		'type'    => 'theme_mod',
        'panel'   => 'pizzaland_frontpage_panel',
        'section' => 'pizzaland_menu_button_section',
        'transport' =>  'postMessage',
		'sanitize_callback'   => 'pizzaland_sanitize_text',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to add text to the call to action button below the menu selection 
	$wp_customize->add_control('pizzaland_menus_button_text_control', array(
		'label' => __( 'Add your text for the call to action button below the menu selection', 'pizzaland' ),
		'section' => 'pizzaland_menu_button_section',
		'settings' => 'pizzaland_menus_button_text',
		'type' => 'text',
	) );
    
    //Add setting to add URL to the call to action button below the menu selection
	$wp_customize->add_setting( 'pizzaland_menus_button_url' , array(
		'default'     => esc_url( home_url( '/' ) ) . 'our-menus/',
		'type'    => 'theme_mod',
        'panel'   => 'pizzaland_frontpage_panel',
        'section' => 'pizzaland_menu_button_section',
        'transport' =>  'postMessage',
		'sanitize_callback'   => 'pizzaland_sanitize_url',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to add URL to the call to action button below the menu selection 
	$wp_customize->add_control('pizzaland_menus_button_url_control', array(
		'label' => __( 'Add a URL to the call to action button below the menu selection', 'pizzaland' ),
		'section' => 'pizzaland_menu_button_section',
		'settings' => 'pizzaland_menus_button_url',
		'type' => 'url',
	) );
    
    //Add section to customizer for call to action button below the Testimonials carousel
    $wp_customize->add_section(
        // $id
        'pizzaland_bottom_button_section',
        // $args
        array(
            'title'			=> __( 'Bottom Call to Action Button', 'pizzaland' ),
            'description'	=> __( 'Customize the call to action button below the Testimonials carousel', 'pizzaland' ),
            'priority'      => 20,
            'panel'         => 'pizzaland_frontpage_panel',
			'capability' => 'edit_theme_options',
        )
	);
    
    //Add setting to add text to the call to action button below the Testimonials carousel
	$wp_customize->add_setting( 'pizzaland_bottom_button_text' , array(
		'default'     => __( 'Book your Table', 'pizzaland' ),
		'type'    => 'theme_mod',
        'panel'   => 'pizzaland_frontpage_panel',
        'section' => 'pizzaland_bottom_button_section',
        'transport' =>  'postMessage',
		'sanitize_callback'   => 'pizzaland_sanitize_text',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to add text to the call to action button below the Testimonials carousel
	$wp_customize->add_control('pizzaland_bottom_button_text_control', array(
		'label' => __( 'Add your text for the call to action button below the Testimonials carousel', 'pizzaland' ),
		'section' => 'pizzaland_bottom_button_section',
		'settings' => 'pizzaland_bottom_button_text',
		'type' => 'text',
	) );
    
    //Add setting to add URL to the call to action button below the Testimonials carousel
	$wp_customize->add_setting( 'pizzaland_bottom_button_url' , array(
		'default'     => esc_url( home_url( '/' ) ) . 'reservations/',
		'type'    => 'theme_mod',
        'panel'   => 'pizzaland_frontpage_panel',
        'section' => 'pizzaland_bottom_button_section',
        'transport' =>  'postMessage',
		'sanitize_callback'   => 'pizzaland_sanitize_url',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to add URL to the call to action button below the menu selection 
	$wp_customize->add_control('pizzaland_bottom_button_url_control', array(
		'label' => __( 'Add a URL to the call to action button below the Testimonials carousel', 'pizzaland' ),
		'section' => 'pizzaland_bottom_button_section',
		'settings' => 'pizzaland_bottom_button_url',
		'type' => 'url',
	) );
    
    //Add section to customize title in latest posts homepage panel 
    $wp_customize->add_section(
        // $id
        'pizzaland_latest_news_section',
        // $args
        array(
            'title'			=> __( 'Latest News Section', 'pizzaland' ),
            'description'	=> __( 'Customize the title in the Latest News front page section', 'pizzaland' ),
            'priority'      => 30,
            'panel'         => 'pizzaland_frontpage_panel',
			'capability' => 'edit_theme_options',
        )
	);
    
    //Add setting to modify title text in Latest News front page section
	$wp_customize->add_setting( 'pizzaland_frontposts_section_title' , array(
		'default'     => __( 'Latest News', 'pizzaland' ),
		'type'    => 'theme_mod',
        'panel'   => 'pizzaland_frontpage_panel',
        'section' => 'pizzaland_latest_news_section',
        'transport' =>  'postMessage',
		'sanitize_callback'   => 'pizzaland_sanitize_text',
		'capability' => 'edit_theme_options',
	) );
    
    //Control to modify title text in Latest News front page section
	$wp_customize->add_control('pizzaland_frontposts_section_title_control', array(
		'label' => __( 'Add your text to the title in the Latest News section of your front page', 'pizzaland' ),
		'section' => 'pizzaland_latest_news_section',
		'settings' => 'pizzaland_frontposts_section_title',
		'type' => 'text',
	) );
    
    //Add setting to manage number of latest posts in Latest News front page section
	$wp_customize->add_setting( 'pizzaland_frontpage_numberofposts' , array(
		'default'     => 3,
		'type'    => 'theme_mod',
        'panel'   => 'pizzaland_frontpage_panel',
        'section' => 'pizzaland_latest_news_section',
		'sanitize_callback'   => 'pizzaland_sanitize_number_absint',
		'capability' => 'edit_theme_options',
	) );
    
    //Add control to manage number of latest posts in Latest News front page section
	$wp_customize->add_control('pizzaland_frontpage_numberofposts_control', array(
		'label' => __( 'Choose between 2 and 6 latest posts to display in the Latest News section of your front page?', 'pizzaland' ),
		'section' => 'pizzaland_latest_news_section',
		'settings' => 'pizzaland_frontpage_numberofposts',
		'type' => 'number',
        'input_attrs' => array(
	        'min' => 2,
	        'max' => 6,
	        'step' => 1,
	    ),
	) );
    
}
add_action( 'customize_register', 'pizzaland_customize_register', 11 );

//Sanitization
function pizzaland_sanitize_select( $input ) {
	
	if ( ! in_array( $input, array( 'green-red' ,'blue-gray-amber', 'indigo-lime', 'pink-amber' ) ) )
        $input = 'default';
 
    return $input;
}

function pizzaland_sanitize_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function pizzaland_sanitize_text( $nohtml ) {
    return wp_filter_nohtml_kses( $nohtml );
}

function pizzaland_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

function pizzaland_sanitize_number_absint( $number, $setting ){
    // Ensure $number is an absolute integer (whole number, zero or greater).
    $number = absint( $number );
    
    // If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

//Active callback function for front-page
function pizzaland_show_frontpage_panel() {
    if( is_front_page() && is_page_template( 'restauranthome-template.php' ) && class_exists( 'fdmFoodAndDrinkMenu' ) && function_exists( 'testimonialswidget_init' ) ) {
        return true;
    } else {
        return false;
    }
}

function pizzaland_custom_styles(){
    //Set the color scheme
    $selected_color_scheme = esc_html( get_theme_mod( 'pizzaland_colorschemes_setting' ) );
    
    //Add the link for the color scheme stylesheet only if it's not the default style
    if ( $selected_color_scheme != 'green-red' ){
        
        ?>
        <link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_directory_uri() );?>/css/<?php echo $selected_color_scheme; ?>.css" media="screen">
        
        <?php
	}
    
}
add_action( 'wp_head', 'pizzaland_custom_styles');

//Live preview script
function pizzaland_preview_js() {
    wp_enqueue_script( 'pizzaland_js_preview', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview', 'jquery' ), '', true );
    
    //Make the stylesheet URL available to the JS preview
    wp_localize_script( 'pizzaland_js_preview', 'pizzaland_preview_vars', array(
            'schemesPathUrl'  =>  get_stylesheet_directory_uri() . '/css/',
        ) 
    );
}
add_action( 'customize_preview_init', 'pizzaland_preview_js' );