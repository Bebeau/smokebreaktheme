var init = {
	onReady: function() {
        init.frmBtn();
	},
    wholesaleSubmit: function() {
		var Frm = jQuery('#wholesalefrm');
    	jQuery('#wholesalefrm button').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajax.ajaxurl,
            type: Frm.attr('method'),
            data: {
            	company: jQuery('input[name="company"]').val(),
            	client: jQuery('input[name="client"]').val(),
            	phone: jQuery('input[name="phone"]').val(),
            	emailaddress: jQuery('input[name="emailaddress"]').val(),
                service: jQuery('option:selected').val(),
                qty: jQuery('input[name="qty"]').val(),
            	action: 'sendWholesale'
            },
            dataType: 'html',
            success: function(data) {
            	init.frmResponse(data);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
        return false;
	},
    influenceSubmit: function() {
        var Frm = jQuery('#influencefrm');
        jQuery('#influencefrm button').html('<i class="fa fa-spinner fa-spin"></i>');
        jQuery.ajax({
            url: ajax.ajaxurl,
            type: Frm.attr('method'),
            data: {
                handle: jQuery('input[name="handle"]').val(),
                emailaddress: jQuery('input[name="emailaddress"]').val(),
                address: jQuery('input[name="address"]').val(),
                address2: jQuery('input[name="address2"]').val(),
                city: jQuery('input[name="city"]').val(),
                state: jQuery('option:selected').val(),
                zip: jQuery('input[name="zip"]').val(),
                action: 'sendInfluence'
            },
            dataType: 'html',
            success: function(data) {
                init.frmResponse(data);
            }
        });
        return false;
    },
	frmResponse: function(response) {
        jQuery('form button i').remove();
        if (response === "Success") {
        	jQuery('form button').replaceWith('<button class="success"><i class="fa fa-check"></i></button>');
            jQuery("input").val("");
            setTimeout(
            	function() {
            		jQuery('form button').replaceWith('<button>Submit</button>');
            	}, 2500
        	);
        }
        if (response === "E") {
         	jQuery('form button').replaceWith('<button class="error"><i class="fa fa-ban"></i></button>');
         	setTimeout(
            	function() {
            		jQuery('form button').replaceWith('<button>Submit</button>');
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