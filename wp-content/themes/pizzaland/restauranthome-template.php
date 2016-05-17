<?php
/**
 * Template Name: Restaurant Home
 *
 * This is the template to apply to the Static Home page for your Restaurant.
 * It's to be used with the Food and Drink Menu and Testimonials plugins activated
 *
 * @package WordPress
 * @subpackage Pizzaland
 * @since Pizzaland 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'homespecials' );

		// End the loop.
		endwhile;
		?>
         
          <!-- Top Section Sidebar with specials -->
           
           	<?php if ( is_active_sidebar( 'homepage-section-1' )  ) : ?>
		    <article <?php post_class( 'homepage-section' ); ?>>
			
                <?php dynamic_sidebar( 'homepage-section-1' ); ?>
			
	            
	           <!-- Button to access all the menus: values from Customizer options -->
	           <div class="btn-wrapper" id="menu-btn-wrapper">
	               <a href="<?php echo esc_url( get_theme_mod( 'pizzaland_menus_button_url', home_url( "/" ) . 'our-menus/' ) ); ?>" class="action-btn">
	                   <?php echo get_theme_mod( 'pizzaland_menus_button_text', __( 'View all menus', 'pizzaland' ) ); ?> &raquo;
	               </a>
	           </div><!-- .btn-wrapper -->
	           	
            </article><!-- .post -->
            <?php endif; ?>
            
            <!-- Latest News: title and number of posts from Customizer options -->
           
            <article <?php post_class( 'homepage-section latest-posts clear' ); ?>>
                <h2 class="latest-news"><?php echo get_theme_mod( 'pizzaland_frontposts_section_title', __( 'Latest News', 'pizzaland' ) ); ?></h2>
           
                <?php
                
                $args = array( 'posts_per_page' => get_theme_mod( 'pizzaland_frontpage_numberofposts', 3 ) );
                $latest_posts = get_posts( $args );
                foreach ( $latest_posts as $post ) : setup_postdata( $post ); 
                    get_template_part( 'content', 'latestposts' );
                endforeach; 
                wp_reset_postdata();
               
               ?>
                
               
           </article><!-- .post -->
           
           <!-- Sidebar with testimonials -->
           <?php if ( is_active_sidebar( 'homepage-section-2' )  ) : ?>
            <article <?php post_class( 'homepage-section' ); ?>>
			
                <?php dynamic_sidebar( 'homepage-section-2' ); ?>
                
                <!-- Button to access the booking form: values from Customizer options -->
	           <div class="btn-wrapper" id="bottom-action-btn">
	               <a href="<?php echo esc_url( get_theme_mod( 'pizzaland_bottom_button_url', home_url( "/" ) . 'reservations/' ) ); ?>" class="action-btn">
	                   <?php echo get_theme_mod( 'pizzaland_bottom_button_text', __( 'Book your table', 'pizzaland' ) ); ?> &raquo;
	               </a>
	           </div><!-- .btn-wrapper -->

            </article><!-- .post -->
            <?php endif; ?>
            
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
