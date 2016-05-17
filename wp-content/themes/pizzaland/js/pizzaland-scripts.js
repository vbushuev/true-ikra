(function($) {
    
    // Inside of this function, $() will work as an alias for jQuery()
    // and other libraries also using $ will not be accessible under this shortcut
    
    //Add tilting animation to the site description element on page load
    $('.site-branding .site-description').removeClass('tilt').addClass('tilt');
    
    //Add lightbox functionality to the WP gallery when images are 
    //linked to an image file
    
    //Settings for lightbox
    var cboxSettings = {
      rel: 'cboxElement',
        width: '95%',
        height: 'auto',
        maxWidth: '660',
        maxHeight: 'auto',
        title: function() {
            return $(this).find('img').attr('alt');
        }
    }
    
    $('.gallery a[href$=".jpg"], .gallery a[href$=".jpeg"], .gallery a[href$=".png"], .gallery a[href$=".gif"]').colorbox(cboxSettings);
    
    //Keep lightbox responsive on screen resize
    $(window).resize(function() {
       $.colorbox.resize({
           width: window.innerWidth > parseInt(cboxSettings.maxWidth) ? cboxSettings.maxWidth : cboxSettings.width
       }); 
    });
    
    
    //Make strings translation-ready using wp_localize_script in functions.php
    $.extend($.colorbox.settings, {
        current: '',
        previous: pizzaland_script_vars.previous,
        next: pizzaland_script_vars.next,
        close: pizzaland_script_vars.close,
        xhrError: pizzaland_script_vars.xhrError,
        imgError: pizzaland_script_vars.imgError
    });
})(jQuery);