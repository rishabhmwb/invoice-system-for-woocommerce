(function( $ ) {
    'use strict';
    $(document).ready(function(){
        $('#isfw-logo-upload_image').click(function() {
            if (this.window === undefined) {
				this.window = wp.media({
					title: 'Insert Image',
					library: {type: 'image'},
					multiple: false,
					button: {text: 'Insert Image'}
				});
				var self = this;
				this.window.on('select', function() {
					var response = self.window.state().get('selection').first().toJSON();
					$('.wp_attachment_id').val(response.id);
					$('.mwb-isfw-logo-image').attr('src', response.sizes.thumbnail.url);
                    $('.mwb-isfw-logo-image').show();
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
            var company_name    = ( $('#isfw_company_name').val() ).trim();
            var company_city    = ( $('#isfw_company_city').val() ).trim();
            var company_state   = ( $('#isfw_company_state').val() ).trim();
            var company_pin     = ( $('#isfw_company_pin').val() ).trim();
            var company_phone   = ( $('#isfw_company_phone').val() ).trim();
            var company_email   = ( $('#isfw_company_email').val() ).trim();
            var company_address = ( $('#isfw_company_address').val() ).trim();
            var prefix          = ( $('#isfw_invoice_number_prefix').val() ).trim();
            var suffix          = ( $('#isfw_invoice_number_suffix').val() ).trim();
            var digit           = ( $('#isfw_invoice_number_digit').val() ).trim();
            var logo            = $('.mwb-isfw-logo-image').attr('src');
            var date            = $('#isfw_invoice_renew_date').val();
            var disclaimer      = ( $('#isfw_invoice_disclaimer').val() ).trim();
            var color           = $('#isfw_invoice_color').val();
            var order_status    = $( '#isfw_send_invoice_for' ).val();
            var preg_prefix     = /^[a-zA-Z0-9_.-]*$/;
            if ( digit > 10 ) {
                alert( 'Please enter the digitin the digit field less then 10' );
            }
            if ( ! prefix.match(preg_prefix) || ! suffix.match(preg_prefix) ) {
                alert( 'Please Enter Characters, Numbers and "-" only in prfix and suffix field' );
            } else {
                var curr_obj = this;
                $(curr_obj).text( 'saving...' );
                var setting_fields = {
                    'prefix'          : prefix,
                    'suffix'          : suffix,
                    'digit'           : digit,
                    'logo'            : logo,
                    'date'            : date,
                    'disclaimer'      : disclaimer,
                    'color'           : color,
                    'order_status'    : order_status,
                    'company_name'    : company_name,
                    'company_city'    : company_city,
                    'company_state'   : company_state,
                    'company_phone'   : company_phone,
                    'company_pin'     : company_pin,
                    'company_email'   : company_email,
                    'company_address' : company_address,
                    'template'        : template
                };
                $.ajax({
                    url: isfw_general_settings.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'isfw_save_general_pdf_settings',
                        nonce: isfw_general_settings.isfw_setting_page_nonce,
                        settings_data : setting_fields
                    },
                    success: function( msg ) {
                        $(curr_obj).text('saved');
                    }, error : function() {
                        $(curr_obj).text('resubmit');
                        alert('there might be some error in saving the settings please try again');
                    }
                });
            }
        });
    });
})( jQuery );