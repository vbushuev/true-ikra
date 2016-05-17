<?php
/**
  * Set up Pizzaland textdomain.
  *
  * Declare textdomain for this child theme.
  * Translations can be added to the /languages/ directory.
  */
function pizzaland_setup() {
    load_child_theme_textdomain( 'pizzaland', get_stylesheet_directory() . '/languages' );
    
    /*
	 * This theme styles the visual editor to resemble the theme style
	 */
	add_editor_style( array( 'css/editor-style.css', pizzaland_fonts_url() ) );
}
add_action( 'after_setup_theme', 'pizzaland_setup' );

/**
 * Recommend plugins
 *
 * @since Pizzaland 1.0
 */
require_once get_stylesheet_directory() . '/inc/class-tgm-plugin-activation.php';

function pizzaland_recommend_plugins() {
 
    $plugins = array( 
        array( 
            'name'  =>  'Food and Drink Menu',
            'slug'  =>  'food-and-drink-menu',
            'required'  =>  false,
        ),
        array( 
            'name'  =>  'Restaurant Reservations',
            'slug'  =>  'restaurant-reservations',
            'required'  =>  false,
        ),
        array( 
            'name'  =>  'Testimonials Widget',
            'slug'  =>  'testimonials-widget',
            'required'  =>  false,
        ),
        array( 
            'name'  =>  'Team Members',
            'slug'  =>  'team-members',
            'required'  =>  false,
        ),
    );
    
    //Add internationalization
    $theme_text_domain = 'pizzaland';
    
    $config = array( 
        'id'    =>  'pizzaland-tgmpa',
        'capability'    =>  'edit_theme_options',
        'has_notices'   =>  true,
        'dismissable'   =>  true,
        'is_automatic'  =>  false,
    );
 
    tgmpa( $plugins, $config );
 
}
add_action( 'tgmpa_register', 'pizzaland_recommend_plugins' );


/* Function to add custom fonts */

function pizzaland_fonts_url() {
    $fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not
	 * translate into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'pizzaland' );

	/* Translators: If there are characters in your language that are not
	 * supported by Playfair Display, translate this to 'off'. Do not
	 * translate into your own language.
	 */
	$playfair_display = _x( 'on', 'Playfair Display font: on or off', 'pizzaland' );

	if ( 'off' !== $lato || 'off' !== $playfair_display ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:400,300,300italic,700,400italic,700italic';

		if ( 'off' !== $playfair_display )
			$font_families[] = 'Playfair+Display:400,700,400italic,700italic';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
* Disable fonts from Twenty Fifteen
*/
function pizzaland_disable_twentyfifteen_fonts(){
    wp_dequeue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'pizzaland_disable_twentyfifteen_fonts', 11 );

/**
 * Enqueue Pizzaland Styles, Parent Theme Styles, Other Styles and Scripts
 * @return void
 */

function pizzaland_enqueue_styles_scripts() {

    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'pizzaland-fonts', pizzaland_fonts_url(), array(), null );
    
    // Add parent theme styles
    wp_enqueue_style( 'twentyfifteen-style', get_template_directory_uri() . '/style.css' );
    
    //Add Colorbox stylesheet
    wp_enqueue_style( 'colorbox', get_stylesheet_directory_uri() . '/colorbox/colorbox.css',  array(), '1.6.1', false );
    
    //Add child theme styles
    wp_enqueue_style( 'pizzaland-style', get_stylesheet_directory_uri() . '/style.css',  array( 'twentyfifteen-style' ), false );
    
    //Add Colorbox jQuery plugin file
    wp_enqueue_script( 'colorbox', get_stylesheet_directory_uri() . '/colorbox/jquery.colorbox-min.js', array( 'jquery' ), '', true );

    //Make the Colorbox text translation-ready
    wp_localize_script( 'colorbox', 'pizzaland_script_vars', array(
            'previous'  =>  __( 'previous', 'pizzaland' ),
            'next'      =>  __( 'next', 'pizzaland' ),
            'close'     =>  __( 'close', 'pizzaland' ),
            'xhrError'  =>  __( 'This content failed to load.', 'pizzaland' ),
            'imgError'  =>  __( 'This image failed to load.', 'pizzaland' )
        ) 
    );
    
    //Add theme's JS file
    wp_enqueue_script( 'pizzaland-script', get_stylesheet_directory_uri() . '/js/pizzaland-scripts.js', array( 'colorbox' ), '', true );
   
}
add_action( 'wp_enqueue_scripts', 'pizzaland_enqueue_styles_scripts' );


/**
 * Register widget areas in restaurant static home page template.
 *
 * @since Pizzaland 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */

// check if food and drink menu plugin is active by looking for its class name
//If it is, add Menu widget area for the Restaurant Home page template
if ( class_exists( 'fdmFoodAndDrinkMenu' ) ) {
    
    function pizzaland_restaurant_init() {
        register_sidebar( array(
            'name'          => __( 'Homepage Specials Section', 'pizzaland' ),
            'id'            => 'homepage-section-1',
            'description'   => __( 'Add Menu widget here to appear in your static homepage.', 'pizzaland' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s clear home-menu">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
        
    }
    add_action( 'widgets_init', 'pizzaland_restaurant_init' );
} 

// check if Testimonials plugin is active by looking for its function name
//If it is, add Testimonials widget area for the Restaurant Home page template
if ( function_exists( 'testimonialswidget_init' ) ) {
    
    function pizzaland_testimonials_init() {
        
        register_sidebar( array(
            'name'          => __( 'Homepage Testimonials Section', 'pizzaland' ),
            'id'            => 'homepage-section-2',
            'description'   => __( 'Add Testimonials widget here to appear in your static homepage.', 'pizzaland' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s clear testimonials">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
        
    }
    add_action( 'widgets_init', 'pizzaland_testimonials_init' );
}

/**
 * Register footer widget area.
 *
 * @since Pizzaland 1.0.7
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function pizzaland_footer_widgets_init() {
        
		register_sidebar( array(
            'name'          => __( 'Footer Widgets', 'pizzaland' ),
            'id'            => 'footer-widgets',
            'description'   => __( 'Add widgets like Google Maps to your footer area.', 'pizzaland' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s clear testimonials">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
        
    }
    add_action( 'widgets_init', 'pizzaland_footer_widgets_init' );

/**
 * Implement the Custom Header feature.
 *
 * @since Pizzaland 1.0
 */
require get_stylesheet_directory() . '/inc/custom-header.php';

/**
 * Implement Customizer options.
 *
 * @since Pizzaland 1.0
 */
require get_stylesheet_directory() . '/inc/customizer.php';
