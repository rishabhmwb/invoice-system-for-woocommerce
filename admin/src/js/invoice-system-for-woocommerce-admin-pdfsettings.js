(function( $ ) {
    'use strict';
    $(document).ready(function(){
        $('#isfw_invoice_renew_date').datepicker({
            showOn: "button",
            buttonImage: isfw_general_settings.calender_image,
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            minDate: '0y',
            maxDate: '+1y',
        });
        $('#isfw_invoice_color').minicolors({
            animationSpeed: 50,
            animationEasing:'swing',
            changeDelay: 0,
            control:'hue',
            format:'hex',
            showSpeed: 100,
            hideSpeed: 100,
            inline:false,



        });
        // if ( $('.mwb-isfw-logo-image').attr('src') ) {
        //     $('#isfw-logo-upload_image').text(isfw_general_settings.remove_image);
        // }
        $('#mwb-isfw-logo-remove-image').click(function(){
            $('.mwb-isfw-logo-image').attr('src', '');
            $('.wp_attachment_id').val('');
            $('.mwb-isfw-logo-image').hide();
            $(this).hide();
        });
        $('#isfw-logo-upload_image').click(function() {
            if (this.window === undefined) {
                this.window = wp.media({
                    title: isfw_general_settings.insert_image,
                    library: {type: 'image'},
                    multiple: false,
                    button: {text: isfw_general_settings.insert_image}
                });
                var self = this;
                this.window.on('select', function() {
                    var response = self.window.state().get('selection').first().toJSON();
                    $('.wp_attachment_id').val(response.id);
                    $('.mwb-isfw-logo-image').attr('src', response.sizes.thumbnail.url);
                    $('.mwb-isfw-logo-image').show();
                    $('#mwb-isfw-logo-remove-image').show();
                });
            }
            this.window.open();
            return false;
        });
        $('#isfw_invoice_template1').change(function(){
			if ( $(this).is(":checked") ) {
                $(this).css('background-color','#dadaee');
                $('#isfw_invoice_template2').css('background-color','');
                $('#isfw_invoice_template2').prop('checked',false);
			} else {
				$(this).css('background-color','');
			}
		});
        $('#isfw_invoice_template2').click(function(){
            if ( $(this).is(":checked") ) {
                $(this).css('background-color','#dadaee');
                $('#isfw_invoice_template1').css('background-color','');
                $('#isfw_invoice_template1').prop('checked',false);
			} else {
				$(this).css('background-color','');
			}
        });
        $('#isfw_invoice_general_setting_save').click(function(){
            var template;
            if ( $('#isfw_invoice_template1').is(":checked") ) {
                template = 'one';
            } else {
                template = 'two';
            }
            var company_name       = ( $('#isfw_company_name').val() ).trim();
            var company_city       = ( $('#isfw_company_city').val() ).trim();
            var company_state      = ( $('#isfw_company_state').val() ).trim();
            var company_pin        = ( $('#isfw_company_pin').val() ).trim();
            var company_phone      = ( $('#isfw_company_phone').val() ).trim();
            var company_email      = ( $('#isfw_company_email').val() ).trim();
            var company_address    = ( $('#isfw_company_address').val() ).trim();
            var prefix             = ( $('#isfw_invoice_number_prefix').val() ).trim();
            var suffix             = ( $('#isfw_invoice_number_suffix').val() ).trim();
            var digit              = ( $('#isfw_invoice_number_digit').val() ).trim();
            var logo               = $('.mwb-isfw-logo-image').attr('src');
            var date               = $('#isfw_invoice_renew_date').val();
            var disclaimer         = ( $('#isfw_invoice_disclaimer').val() ).trim();
            var color              = $('#isfw_invoice_color').val();
            var order_status       = $( '#isfw_send_invoice_for' ).val();
            var is_add_logo        = $('#isfw_is_add_logo_invoice').is(":checked");
            var isfw_enable_plugin = $('.mdc-switch__native-control').is(":checked");
            function mwb_parsedate( date ) {
                var d = date.split(/\D/);
                var current_year = new Date().getFullYear();
                if ( d[0].toString().length == 2 && d[1].toString().length == 2 && d[2].toString().length == 4 ) {
                    return ( d[2] == current_year || d[2] == current_year + 1 ) ? true : false;
                } else {
                    return false;
                }
            }
            function window_scroll() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                $('.notice').remove();
            }
            var preg_prefix     = /^[a-zA-Z0-9_.-]*$/;
            if ( digit > 10 ) {
                window_scroll();
                $('header').append( isfw_general_settings.digit_limit );
            }
            else if ( ! mwb_parsedate( date )) {
                window_scroll();
                $('header').append( isfw_general_settings.invalid_date );
            }
            else if ( ! prefix.match(preg_prefix) || ! suffix.match(preg_prefix) ) {
                window_scroll();
                $('header').append( isfw_general_settings.suffix_limit );
            } else {
                var curr_obj = this;
                $(curr_obj).html( "<img src="+isfw_general_settings.btn_load+" width='30' height='30'>" );
                var setting_fields = {
                    'prefix'             : prefix,
                    'suffix'             : suffix,
                    'digit'              : digit,
                    'logo'               : logo,
                    'date'               : date,
                    'disclaimer'         : disclaimer,
                    'color'              : color,
                    'order_status'       : order_status,
                    'company_name'       : company_name,
                    'company_city'       : company_city,
                    'company_state'      : company_state,
                    'company_phone'      : company_phone,
                    'company_pin'        : company_pin,
                    'company_email'      : company_email,
                    'company_address'    : company_address,
                    'template'           : template,
                    'is_add_logo'        : ( is_add_logo ) ? 'yes' : 'no',
                    'isfw_enable_plugin' : ( isfw_enable_plugin ) ? 'on' : 'off'
                };
                $.ajax({
                    url: isfw_general_settings.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'isfw_save_general_pdf_settings',
                        nonce: isfw_general_settings.isfw_setting_page_nonce,
                        settings_data : setting_fields,
                        isfw_enable_plugin : ( isfw_enable_plugin ) ? 'on' : 'off'
                    },
                    success: function( msg ) {
                        $(curr_obj).text(isfw_general_settings.btn_success);
                        window_scroll();
                        $('header').append(msg);
                    }, error : function() {
                        $(curr_obj).text(isfw_general_settings.btn_resubmit);
                        alert(isfw_general_settings.saving_error);
                    }
                });
            }
        });
    });
})( jQuery );