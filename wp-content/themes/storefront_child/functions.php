<?php

// Hide admin bar
add_filter('show_admin_bar', '__return_false');

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    $parent_style = 'storefront-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/771a83773c.js', array('jquery'), null, true);
	wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/js/custom-min.js', array('jquery'), null, true);
    wp_localize_script( 'custom', 'ajax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'wholesale' => wp_create_nonce('wholesale'),
        'influence' => wp_create_nonce('influence')
    ));
}
// Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'product_listing_count', 20 );
function product_listing_count( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 32;
  return $cols;
}
// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}
// Add woocommerce theme support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
// Remove additional information product tab
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
// Add share buttons to product pages
add_action( 'woocommerce_share', 'after_add_to_cart_button' );
function after_add_to_cart_button($post) { 

	if(has_post_thumbnail()) {
		$postImage = get_the_post_thumbnail_url();
	} else { 
		$postImage = get_bloginfo('template_directory').'/assets/images/default_facebook.jpg'; 
	};

	?>

    <div class="social-share">
		<a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="facebook">
		    <i class="fa fa-facebook"></i>
		</a>
		<a class="twitter" target="_blank" href="http://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php echo strip_tags(get_the_title()); ?> - &amp;via=live_smokebreak">
		    <i class="fa fa-twitter"></i>
		</a>
		<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo $postImage; ?>&amp;description=<?php echo strip_tags(get_the_excerpt()); ?>" class="pinterest" count-layout="horizontal">
		    <i class="fa fa-pinterest"></i>
		</a>
	</div>

<?php }

// Remove billing phone (and set email field class to wide)
add_filter( 'woocommerce_billing_fields', 'remove_billing_phone_field', 20, 1 );
function remove_billing_phone_field($fields) {
    $fields ['billing_phone']['required'] = false; // To be sure "NOT required"

    $fields['billing_email']['class'] = array('form-row-wide'); // Make the field wide

    unset( $fields ['billing_phone'] ); // Remove billing phone field
    return $fields;
}

// Remove shipping phone (optional)
add_filter( 'woocommerce_shipping_fields', 'remove_shipping_phone_field', 20, 1 );
function remove_shipping_phone_field($fields) {
    $fields ['shipping_phone']['required'] = false; // To be sure "NOT required"

    unset( $fields ['shipping_phone'] ); // Remove shipping phone field
    return $fields;
}

// Add analytic script to checkout
function smokebreak_checkout_analytics( $order_id ) {
	$order = new WC_Order( $order_id );
	$currency = $order->get_order_currency();
	$total = $order->get_total();
	$date = $order->order_date;
	?>
	<!-- Event snippet for OG Kushion Purchase conversion page -->
	<script>
	  gtag('event', 'conversion', {
	      'send_to': 'AW-1040152560/mEU6COyDn6EBEPDv_e8D',
	      'transaction_id': <?php echo $order_id; ?>,
	      'value': <?php echo $total; ?>,
	      'currency': 'USD'
	  });
	</script>
	<?php	
}
add_action( 'woocommerce_thankyou', 'smokebreak_checkout_analytics' );

add_action('wp_ajax_sendWholesale', 'wholesaleSubmit');
add_action('wp_ajax_nopriv_sendWholesale', 'wholesaleSubmit');
function wholesaleSubmit() {
    global $post;

	check_ajax_referer( $_POST['wholesaleNonce'], 'wholesale' );

    $success = false;

    $company = isset( $_POST['company'] ) ? $_POST['company'] : "";
    $name = isset( $_POST['name'] ) ? $_POST['name'] : "";
    $phone = isset( $_POST['phone'] ) ? $_POST['phone'] : "";
    $emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);
    $service = isset( $_POST['service'] ) ? $_POST['service'] : "";
    $qty = isset( $_POST['qty'] ) ? $_POST['qty'] : "";

    $email = esc_attr(get_option('admin_email'));
    $to = $emailaddress;

    if ( $company && $name && $phone && $emailaddress && $service && $qty ) {

        $subject = "Smoke Break Wholesale Inquiry";

        $headers = 'From:' . $email . "\r\n";
        $headers .= 'Reply-To:' . $to . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $headers .= "charset: ISO-8859-1\r\n";
        $headers .= "X-Mailer: PHP/".phpversion()."\r\n";

        $formcontent = '<html><body><center>';
            $formcontent .= '<table rules="all" style="border: 1px solid #cccccc; width: 600px;" cellpadding="10">';
            $formcontent .= "<tr><td><strong>Name:</strong></td><td>".$company."</td></tr>";
            $formcontent .= "<tr><td><strong>Email:</strong></td><td>".$name."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$phone."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$emailaddress."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$service."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$qty."</td></tr>";
        $formcontent .= '</table></center></body></html>';

        $success = mail( $email, $subject, $formcontent, $headers );

    }

    // Return an appropriate response to the browser
    if ( defined( 'DOING_AJAX' ) ) {
        echo $success ? "Success" : "E";
    }

    die();

}

add_action('wp_ajax_sendInfluence', 'influenceSubmit');
add_action('wp_ajax_nopriv_sendInfluence', 'influenceSubmit');
function influenceSubmit() {
    global $post;

	check_ajax_referer( $_POST['influenceNonce'], 'influence' );

    $success = false;

    $company = isset( $_POST['company'] ) ? $_POST['company'] : "";
    $name = isset( $_POST['name'] ) ? $_POST['name'] : "";
    $phone = isset( $_POST['phone'] ) ? $_POST['phone'] : "";
    $emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);
    $service = isset( $_POST['service'] ) ? $_POST['service'] : "";
    $qty = isset( $_POST['qty'] ) ? $_POST['qty'] : "";

    $email = esc_attr(get_option('admin_email'));
    $to = $emailaddress;

    if ( $company && $name && $phone && $emailaddress && $service && $qty ) {

        $subject = "Smoke Break Wholesale Inquiry";

        $headers = 'From:' . $email . "\r\n";
        $headers .= 'Reply-To:' . $to . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $headers .= "charset: ISO-8859-1\r\n";
        $headers .= "X-Mailer: PHP/".phpversion()."\r\n";

        $formcontent = '<html><body><center>';
            $formcontent .= '<table rules="all" style="border: 1px solid #cccccc; width: 600px;" cellpadding="10">';
            $formcontent .= "<tr><td><strong>Name:</strong></td><td>".$company."</td></tr>";
            $formcontent .= "<tr><td><strong>Email:</strong></td><td>".$name."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$phone."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$emailaddress."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$service."</td></tr>";
            $formcontent .= "<tr><td><strong>Message:</strong></td><td>".$qty."</td></tr>";
        $formcontent .= '</table></center></body></html>';

        $success = mail( $email, $subject, $formcontent, $headers );

    }

    // Return an appropriate response to the browser
    if ( defined( 'DOING_AJAX' ) ) {
        echo $success ? "Success" : "E";
    }

    die();

}

// function giv_mailchimp_curl_connect($url, $request_type, $api_key, $data = array()) {
//     if( $request_type == 'GET' ) {
//         $url .= '?' . http_build_query($data);
//     }
 
//     $mch = curl_init();
//     $headers = array(
//         'Content-Type: application/json',
//         'Authorization: Basic '.base64_encode( 'user:'. $api_key )
//     );
//     curl_setopt($mch, CURLOPT_URL, $url );
//     curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
//     //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
//     curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
//     curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
//     curl_setopt($mch, CURLOPT_TIMEOUT, 10);
//     curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection
 
//     if( $request_type != 'GET' ) {
//         curl_setopt($mch, CURLOPT_POST, true);
//         curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
//     }

//     return curl_exec($mch);
// }

?>