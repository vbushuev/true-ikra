<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Pizzaland
 * @since Pizzaland 1.0
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
		
			<div class="clear">
            <?php  
                $footer_left_col = get_theme_mod( 'pizzaland_footer_left_col', '' );
            ?>
           
                <div class="footer-credits alignleft">
                    <?php echo wp_kses_post($footer_left_col); ?>
                </div><!-- .footer-credits -->
                
                
                <?php  
                    $footer_right_col = get_theme_mod( 'pizzaland_footer_right_col', '' );
                ?>
			   
                <div class="footer-credits alignright">
                    <?php echo wp_kses_post($footer_right_col); ?>
                </div><!-- .footer-credits -->
                
			   
			</div><!-- .clear -->
			
			<?php
				//Footer widgets: add Google Maps or any other widget in footer area
				if ( is_active_sidebar( 'footer-widgets' )  ) : 
			?>
			
			<div class="footer-widget-wrapper">
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
			</div>
			
			<?php endif; ?>
			
			<div class="footer-credits credits-link">
               
                <?php 
                    $footer_credits_link = get_theme_mod( 'pizzaland_footer_link' ); 
                    if( '' != $footer_credits_link ):
                    echo wp_kses_post($footer_credits_link);
                    else:
                ?>
               
                <p>Designed and coded by Maria Antonietta Perna from 
                    <a href="<?php echo esc_url( __( 'https://wpthememakeover.com/', 'pizzaland' ) ); ?>"><?php printf( __( ' %s', 'pizzaland' ), 'WPThemeMakeover' ); ?></a></p>
                    
                <?php endif; ?>
                    
			</div><!-- .footer-credits -->
			
		</div><!-- .site-info -->
		
		
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
