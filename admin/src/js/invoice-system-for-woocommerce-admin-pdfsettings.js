(function( $ ) {
    'use strict';
    $(document).ready(function(){
        $('#isfw_invoice_general_setting_save').click(function(){
            var prefix     = $('#isfw_invoice_number_prefix').val();
            var suffix     = $('#isfw_invoice_number_suffix').val();
            var digit      = $('#isfw_invoice_number_digit').val();
            var logo       = $('#isfw_invoice_logo')[0].files[0];
            var date       = $('#isfw_invoice_renew_date').val();
            var disclaimer = $('#isfw_invoice_disclaimer').val();
            var color      = $('#isfw_invoice_color').val();
            console.log(logo);
            // alert( prefix + suffix + digit + logo + date + disclaimer + color );
        });
    });
})( jQuery );