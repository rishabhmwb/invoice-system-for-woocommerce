(function( $ ) {
    'use strict';
    $(document).ready(function(){
        // date picker.
        $('#isfw_invoice_renew_date').datepicker({
            showOn: "button",
            buttonImage: isfw_general_settings.calender_image,
            buttonImageOnly: true,
            changeMonth: true,
            dateFormat: 'dd-mm',
        });
        // color picker.
        $('.isfw_color_picker').wpColorPicker();
         // remove company logo.
         $('#isfw_invoice_company_logo_image_remove').click(function(e){
            e.preventDefault();
            $('.isfw_invoice_company_logo_image').attr('src', '');
            $('.isfw_invoice_company_logo_image').hide();
            $('#sub_isfw_upload_invoice_company_logo').val('');
            $(this).hide();
        });
        // insert company logo.
        $('#isfw_upload_invoice_company_logo').click(function(e) {
            e.preventDefault();
            if (this.window === undefined) {
                this.window = wp.media({
                    title    : isfw_general_settings.insert_image,
                    library  : {type: 'image'},
                    multiple : false,
                    button   : {text:isfw_general_settings.insert_image}
                });
                var self = this;
                this.window.on('select', function() {
                    var response = self.window.state().get('selection').first().toJSON();
                    $('.isfw_invoice_company_logo_image').attr('src', response.url);
                    $('.isfw_invoice_company_logo_image').show();
                    $('#isfw_invoice_company_logo_image_remove').show();
                    $('#sub_isfw_upload_invoice_company_logo').val( response.url );
                });
            }
            this.window.open();
            return false;
        });
        $('#isfw_invoice_number_renew_month').on('change',function(){
            var val = $(this).val();
            if ( 'never' != val ) {
                var target_html = $('#isfw_invoice_number_renew_date');
                var cur_value = target_html.val();
                target_html.html('');
                var k = new Date().getFullYear();
                var d = new Date(k, val, 0);
                var dates = d.getDate();
                for ( var i = 1; i <= dates; i++ ) {
                    if ( i == cur_value ) {
                        target_html.append($("<option></option>").attr({"value" : i, 'selected' : 'selected' }).text(i)); 
                    } else {
                        target_html.append($("<option></option>").attr("value", i).text(i)); 
                    }
                }
            } else {
                $('#isfw_invoice_number_renew_date').html('');
            }
            // 
        });
    });
})( jQuery );