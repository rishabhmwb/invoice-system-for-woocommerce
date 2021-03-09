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
        $('#isfw_invoice_general_setting_save').click(function(){
            var curr_obj = this;
            var cur_text = $(curr_obj).text();
            $(curr_obj).text( 'saving...' );
            var prefix       = $('#isfw_invoice_number_prefix').val();
            var suffix       = $('#isfw_invoice_number_suffix').val();
            var digit        = $('#isfw_invoice_number_digit').val();
            var logo         = $('.mwb-isfw-logo-image').attr('src');
            var date         = $('#isfw_invoice_renew_date').val();
            var disclaimer   = $('#isfw_invoice_disclaimer').val();
            var color        = $('#isfw_invoice_color').val();
            var order_status = $( '#isfw_send_invoice_for' ).val();
            var setting_fields = {
                'prefix'       : prefix,
                'suffix'       : suffix,
                'digit'        : digit,
                'logo'         : logo,
                'date'         : date,
                'disclaimer'   : disclaimer,
                'color'        : color,
                'order_status' : order_status

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
                    alert('error');
                }
            });
        });
    });
})( jQuery );