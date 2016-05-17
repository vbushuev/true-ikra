<?php
 /**
* Customize Header image settings
*/
function pizzaland_header_image( $args ) {
    $args = array(
        'width'     =>  180, 
        'height'    =>  204,
        'background-color'  =>  'transparent',
        'wp-head-callback'  =>  'pizzaland_header_style',
    );
    return $args;
}
add_filter( 'twentyfifteen_custom_header_args', 'pizzaland_header_image' );

/**
* Style the header image on the basis of the Customizer choices 
*/
function pizzaland_header_style() {
    //get header image
    $header_image = get_header_image();
    
    // If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && display_header_text() ) {
        return;
	}
    
    // If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="pizzaland-header-css">
    <?php
        // No Custom Header image and Header Text is hidden: short header.
        if ( empty( $header_image ) && ! display_header_text() ) :
	?>
        /* Styles here */
        .site-branding {
            background-image: none;
            padding-top: 14px;
			padding-bottom: 14px;
        }
        
        .site-title,
        .site-description {
            display: none;
        }
        
        .site-header {
			padding-top: 64px;
			padding-bottom: 14px;
		}

		.site-branding {
			min-height: 42px;
		}

		@media screen and (min-width: 55em) {
			
			.site-branding {
				padding-top: 14px;
			    padding-bottom: 14px;
			}
		}
        
		@media screen and (min-width: 59.6875em) {
			.site-header {
				padding-top: 0;
				padding-bottom: 0;
			}
            
			.site-branding {
				min-height: 0;
                padding-top: 0;
				padding-bottom: 0;
                margin-bottom: 0;
			}
		}
    <?php
		endif;

		// If a Custom Header image has been added and the header text hidden: show image and hide text
		if ( ! empty( $header_image ) && ! display_header_text() ) :
	?>
        /* Styles here */
        
        .site-branding {
            background: url(<?php header_image(); ?>) 0 0 no-repeat;
            color: #fff;
            height: 204px;
            padding-bottom: 0;
            
            -webkit-background-size: 180px, 204px;
			-moz-background-size:    180px, 204px;
			-o-background-size:      180px, 204px;
			background-size:         180px, 204px;
        }
        
        .site-title,
        .site-description {
            display: none;
        }
        
        @media screen and (min-width: 38.75em) {
        
            .site-header{
                height: 304px;
            }
        }
        
    <?php
		endif;

		// If both the text and the Custom Header image are selected to be shown, show both
		if ( display_header_text() && ! empty( $header_image ) ) :
	?>
        /* Styles here */
        .site-branding {
            background: url(<?php header_image(); ?>) 0 0 no-repeat;
            color: #fff;
            height: 204px;
            padding-bottom: 0;
            
            -webkit-background-size: 180px, 204px;
			-moz-background-size:    180px, 204px;
			-o-background-size:      180px, 204px;
			background-size:         180px, 204px;
        }
        
        .site-title,
        .site-description {
            display: block;
        }
        
        .site-branding {
            padding-bottom: 4em;
            margin-bottom: 6em;
        }
        
        /**
         * Mobile Large 620px
         */

        @media screen and (min-width: 38.75em) {
           .site-branding {
                margin-bottom: 0;
            } 
        }
        
        /**
         * Desktop Small 955px
         */

        @media screen and (min-width: 59.6875em) {
            .site-branding {
                margin-bottom: 8em;
            }
        }
        
    <?php endif; ?>
	</style>
	<?php

}