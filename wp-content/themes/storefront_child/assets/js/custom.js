var init = {
	onReady: function() {
        init.frmBtn();
	},
    wholesaleSubmit: function() {
		var Frm = jQuery('#wholesalefrm');
    	jQuery('#wholesalefrm .btn-submit').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajax.ajaxurl,
            type: Frm.attr('method'),
            data: {
            	company: jQuery('input[name="company"]').val(),
            	name: jQuery('input[name="name"]').val(),
            	phone: jQuery('input[name="phone"]').val(),
            	email: jQuery('input[name="email"]').val(),
                qty: jQuery('input[name="qty"]').val(),
            	action: 'sendWholesale'
            },
            dataType: 'html',
            beforeSubmit : function(arr, $form, options) {
	            arr.push( { "name" : "wholesaleNonce", "value" : ajax.wholesale });
	        },
            success: function(data) {
            	init.frmResponse(data);
            }
        });
        return false;
	},
    influenceSubmit: function() {
        var Frm = jQuery('#influencefrm');
        jQuery('#influencefrm .btn-submit').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajax.ajaxurl,
            type: Frm.attr('method'),
            data: {
                handle: jQuery('input[name="handle"]').val(),
                address: jQuery('input[name="address"]').val(),
                address2: jQuery('input[name="address2"]').val(),
                city: jQuery('input[name="city"]').val(),
                state: jQuery('option:selected').val(),
                zip: jQuery('input[name="zip"]').val(),
                action: 'sendInfluence'
            },
            dataType: 'html',
            beforeSubmit : function(arr, $form, options) {
                arr.push( { "name" : "influenceNonce", "value" : ajax.influence });
            },
            success: function(data) {
                init.frmResponse(data);
            }
        });
        return false;
    },
	frmResponse: function(response) {
        jQuery('form .btn-submit i').remove();
        if (response === "Success") {
        	jQuery('form .btn-submit').replaceWith('<button class="button btn-submit success"><i class="fa fa-check"></i></button>');
            jQuery("input").val("");
            setTimeout(
            	function() {
            		jQuery('form .btn-submit').replaceWith('<button class="button btn-submit">Send Message</button>');
            	}, 2500
        	);
        }
        if (response === "E") {
         	jQuery('form .btn-submit').replaceWith('<button class="button btn-submit error"><i class="fa fa-ban"></i></button>');
         	setTimeout(
            	function() {
            		jQuery('form .btn-submit').replaceWith('<button class="button btn-submit">Send Message</button>');
            	}, 2500
        	);
        }
	},
	frmBtn: function() {
		jQuery('#wholesalefrm').submit(init.wholesaleSubmit);
        jQuery('#influencefrm').submit(init.influenceSubmit);
	}
};

jQuery(document).ready(function() {
	init.onReady();
});