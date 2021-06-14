(function( $ ) {
    'use strict';
    $(document).ready(function(){
        if ( $("#isfw_download_zip_pdf_hidden_button").length > 0 ) {
            var cur_url = document.location.href;
            cur_url = cur_url.split('write_downloads');
            $('a#isfw_download_zip_pdf')[0].click();
            window.history.pushState( '', document.title, cur_url[0] );
            $('#isfw_download_zip_pdf_hidden_button').html('');
        }
    });
})( jQuery );
