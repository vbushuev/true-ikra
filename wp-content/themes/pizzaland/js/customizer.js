(function($) {
    
    //Live preview for color schemes
    wp.customize( 'pizzaland_colorschemes_setting', function( value ) {
        //get stylesheet URL from wp_localize_script in customizer.php
        var colorSchemeUrl = pizzaland_preview_vars.schemesPathUrl;
        
		value.bind( function( to ) {
            if('' != to) {
                $( 'head' ).append( 
            
                    '<link rel="stylesheet" id="pizzaland-colorscheme-css" href="' + colorSchemeUrl + to + '.css" media="screen">'
            
                );  
            } else {
                return;
            } 
			
		} );
	});
    
    //Live preview for left column footer text setting
    wp.customize( 'pizzaland_footer_left_col', function( value ) {
		value.bind( function( to ) {
			$( '.footer-credits.alignleft' ).html( to );
		} );
	});

    
    //Live preview for right column footer text setting
    wp.customize( 'pizzaland_footer_right_col', function( value ) {
        value.bind( function( to ) {
            $( '.footer-credits.alignright' ).html( to );
        } );
    } );
    
    //Live preview for credits link at the bottom of footer area
    wp.customize( 'pizzaland_footer_link', function( value ) {
        value.bind( function( to ) {
            if('' != to) {
                $( '.credits-link' ).html( to );  
            } else {
                var footerText = '<p>Designed and coded by Maria Antonietta Perna from <a href="https://wpthememakeover.com/">WPThemeMakeover</a></p>';
                $( '.credits-link' ).html( footerText );
            }
            
        } );
    } );
    
    /**
    * Panel for Restaurant Front Page options: this panel shows up only if the Food and Menu
    * and Testimonials Widget plugin have been activated, we're on the Home page, 
    * and we're using the Restaurant Homepage template
    */
    
    //Add preview for the Menus button text 
    wp.customize( 'pizzaland_menus_button_text', function( value ) {
        value.bind( function( to ) {
            $( '#menu-btn-wrapper .action-btn' ).text( to );
        } );
    } );
    
    //Change Menus button link URL without full page refresh 
    wp.customize( 'pizzaland_menus_button_url', function( value ) {
        value.bind( function( to ) {
            var validUrlPattern = new RegExp('^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$');
            if('' != to){
                if(validUrlPattern.test(to)){
                    $( '#menu-btn-wrapper .action-btn' ).attr( 'href', to );
                } else {
                    return;
                }
            }
            
        } );
    } );
    
    //Add preview for the Action button text at the bottom of Home page 
    wp.customize( 'pizzaland_bottom_button_text', function( value ) {
        value.bind( function( to ) {
            $( '#bottom-action-btn .action-btn' ).text( to );
        } );
    } );
    
    //Change Action button link URL at the bottom of Home page without full page refresh 
    wp.customize( 'pizzaland_bottom_button_url', function( value ) {
        value.bind( function( to ) {
            var validUrlPattern = new RegExp('^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$');
            if('' != to){
                if(validUrlPattern.test(to)){
                    $( '#bottom-action-btn .action-btn' ).attr( 'href', to );
                } else {
                    return;
                }
            }
            
        } );
    } );
    
    //Add live preview to title in Latest News Home page section 
    wp.customize( 'pizzaland_frontposts_section_title', function( value ) {
        value.bind( function( to ) {
            $( '.latest-news' ).text( to );
        } );
    } );
    
    
})(jQuery);