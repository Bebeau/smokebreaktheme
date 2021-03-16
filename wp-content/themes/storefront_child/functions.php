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
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
}

// Add woocommerce theme support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

// Replace single product template with custom layout
// add_filter( 'template_include', 'custom_product_template', 10 );
// function custom_product_template( $template ) {
//     $productID = wc_get_product()->get_id();
//     if ( is_product() && $productID === 444 ) {
//         $template = get_stylesheet_directory() . '/single-ogkushpillow.php';
//     }
//     return $template;
// }

// Helper function to load a WooCommerce template or template part file from the
// active theme or a plugin folder.
function my_load_wc_template_file( $template_name ) {
    // Check theme folder first - e.g. wp-content/themes/my-theme/woocommerce.
    $productID = wc_get_product()->get_id();
    $template_name = 'single-'.$productID.'.php';
    $file = get_stylesheet_directory() . '/woocommerce/templates/' . $template_name;
    if ( @file_exists( $file ) ) {
        return $file;
    }
}
add_filter( 'woocommerce_template_loader_files', function( $templates, $template_name ){
    // Capture/cache the $template_name which is a file name like single-product.php
    wp_cache_set( 'my_wc_main_template', $template_name ); // cache the template name
    return $templates;
}, 10, 2 );
add_filter( 'template_include', function( $template ){
    if ( $template_name = wp_cache_get( 'my_wc_main_template' ) ) {
        wp_cache_delete( 'my_wc_main_template' ); // delete the cache
        if ( $file = my_load_wc_template_file( $template_name ) ) {
            return $file;
        }
    }
    return $template;
}, 11 );

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


// HEAD Script (Initializing)
add_action( 'wp_head', 'fbpixels_head_script' );
function fbpixels_head_script() {
    ?>
    <!-- bing -->
    <script>
        (function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"26060070"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");
    </script>
    <!-- Global site tag (gtag.js) - Google Ads: 1040152560 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-1040152560"></script>
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KZ2CVCH');
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-1040152560');
    </script>
    <!-- facebook -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    </script>
    <!-- tiktok -->
    <script>
      (function() {
        var ta = document.createElement('script'); ta.type = 'text/javascript'; ta.async = true;
        ta.src = 'https://analytics.tiktok.com/i18n/pixel/sdk.js?sdkid=BTB4S2B0ONP9VR5G7KO0';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ta, s);
      })();
    </script>
    <?php
}

// Function that gets the Ajax data
add_action( 'wp_ajax_product_added_to_cart', 'wc_product_added_to_cart' );
add_action( 'wp_ajax_nopriv_product_added_to_cart', 'wc_product_added_to_cart' );
function wc_product_added_to_cart() {
    if ( isset($_POST['pid']) ){
        // Get an instance of the WCW_Product Object
        $product = wc_get_product( $_POST['pid'] );

        // Return the product price including taxes
        echo number_format( wc_get_price_including_tax( $product ), 2 );

        // OR =>the product price EXCLUDING taxes
        // echo number_format( wc_get_price_excluding_tax( $product ), 2 );
    }
    die(); // Alway at the end (to avoid server error 500)
}
// FB PiXELS Footer script Events
add_action( 'wp_footer', 'fbpixels_add_to_cart_script' );
function fbpixels_add_to_cart_script(){
    // HERE set your init reference
    $init_id = '316382706407707';

    // HERE set the product currency code
    $currency = 'USD';

    ## 0. Common script -  On ALL Pages
    ?>
    <script>
        fbq('init', <?php echo $init_id; ?>);
        fbq('track', 'PageView');
    <?php

    ## 1. On Checkout page
    if ( ! is_wc_endpoint_url( 'order-received' ) && is_checkout() ) {
        ?>
        fbq('track', 'InitiateCheckout');
        <?php

    ## 2. On Order received (thankyou)
    } elseif ( is_wc_endpoint_url( 'order-received' ) ) {
        global $wp;
        // Get the Order ID from Query vars
        $order_id  = absint( $wp->query_vars['order-received'] );

        if ( $order_id > 0 ){
            // Get an instance of the WC_Order object
            $order = wc_get_order( $order_id );
            ?>
            fbq('track', 'Purchase', {
                value:    <?php echo $order->get_total(); ?>,
                currency: '<?php echo $order->get_order_currency(); ?>',
            });
            gtag('event', 'conversion', {
                'send_to': 'AW-1040152560/TXJICIbJhtsBEPDv_e8D',
                'transaction_id': <?php echo $order_id; ?>,
                'value': <?php echo $order->get_total(); ?>,
                'currency': 'USD'
            });
        <?php
        }
    ## 3. Other pages - (EXCEPT Order received and Checkout)
    } else {

    ?>
    jQuery(function($){
        if (typeof woocommerce_params === 'undefined')
            return false;

        var price;
        jQuery('body').on( 'adding_to_cart', function(a,b,d){
            var sku = d.product_sku, // product Sku
                pid = d.product_id,  // product ID
                qty = d.quantity;    // Quantity

            jQuery.ajax({
                url: woocommerce_params.ajax_url,
                type: 'POST',
                data: {
                    'action' : 'product_added_to_cart',
                    'sku'    : sku,
                    'pid'    : pid,
                    'qty'    : qty
                },
                success: function(result) {
                    // The FB Pixels script for AddToCart
                    if( result > 0 ){
                        fbq('track', 'AddToCart', {
                            value:    result,
                            currency: '<?php echo $currency; ?>',
                        });
                        console.log(result);
                    }
                }
            });
        });
    });
    <?php
    }
    ## For single product pages - Normal add to cart
    if( is_product() && isset($_POST['add-to-cart']) ){
        global $product;

        // variable product
        if( $product->is_type('variable') && isset($_POST['variation_id']) ) {
            $product_id = $_POST['variation_id'];
            $price = number_format( wc_get_price_including_tax( wc_get_product($_POST['variation_id']) ), 2 );
        }
        // Simple product
        elseif ( $product->is_type('simple') ) {
            $product_id = $product->get_id();
            $price = number_format( wc_get_price_including_tax( $product ), 2 );
        }
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

        ?>
        fbq('track', 'AddToCart', {
            value:    <?php echo $price; ?>,
            currency: '<?php echo $currency; ?>',
        });
        <?php
    }
    ?>
    </script>
    <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $init_id; ?>&ev=PageView&noscript=1" />
    </noscript>
    <?php
}

add_action('wp_ajax_sendWholesale', 'wholesaleSubmit');
add_action('wp_ajax_nopriv_sendWholesale', 'wholesaleSubmit');
function wholesaleSubmit() {
    global $post;

    $success = false;

    // contact info
    $firstName = isset( $_POST['firstName'] ) ? $_POST['firstName'] : "";
    $lastName = isset( $_POST['lastName'] ) ? $_POST['lastName'] : "";
    $phone = isset( $_POST['phone'] ) ? $_POST['phone'] : "";
    $emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);
    // shipping info
    $company = isset( $_POST['company'] ) ? $_POST['company'] : "";
    $address = isset( $_POST['address'] ) ? $_POST['address'] : "";
    $address2 = isset( $_POST['address2'] ) ? $_POST['address2'] : "";
    $city = isset( $_POST['city'] ) ? $_POST['city'] : "";
    $state = isset( $_POST['state'] ) ? $_POST['state'] : "";
    $zip = isset( $_POST['zip'] ) ? $_POST['zip'] : "";
    // order info
    $service = isset( $_POST['service'] ) ? $_POST['service'] : "";
    $qty = isset( $_POST['qty'] ) ? $_POST['qty'] : "";
    // admin email
    $email = esc_attr(get_option('admin_email'));

    if ( 
        $company 
        && $firstName 
        && $lastName 
        && $phone 
        && $emailaddress
        && $address 
        && $city 
        && $state 
        && $zip 
        && $service 
        && $qty
    ) {

        $subject = "Smoke Break Wholesale Inquiry";

        $headers = 'From:' . $email . "\r\n";
        $headers .= 'Reply-To:' . $emailaddress . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $headers .= "charset: ISO-8859-1\r\n";
        $headers .= "X-Mailer: PHP/".phpversion()."\r\n";

        $formcontent = '<html><body><center>';
            $formcontent .= '<table rules="all" style="border: 1px solid #cccccc; width: 600px;" cellpadding="10">';
            $formcontent .= "<tr><td><strong>Name:</strong></td><td>".$firstName." ".$lastName."</td></tr>";
            $formcontent .= "<tr><td><strong>Email:</strong></td><td>".$emailaddress."</td></tr>";
            $formcontent .= "<tr><td><strong>Phone:</strong></td><td>".$phone."</td></tr>";
            $formcontent .= "<tr><td><strong>Company:</strong></td><td>".$company."</td></tr>";
            $formcontent .= "<tr><td><strong>Shipping:</strong></td><td>".$address.'<br />'.$address2.'<br />'.$city.','.$state.' '.$zip."</td></tr>";
            $formcontent .= "<tr><td><strong>Service:</strong></td><td>".$service."</td></tr>";
            $formcontent .= "<tr><td><strong>Quantity:</strong></td><td>".$qty."</td></tr>";
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

    $success = false;

    $handle = isset( $_POST['handle'] ) ? $_POST['handle'] : "";
    $emailaddress = filter_var($_POST['emailaddress'], FILTER_SANITIZE_EMAIL);
    $address = isset( $_POST['address'] ) ? $_POST['address'] : "";
    $address2 = isset( $_POST['address2'] ) ? $_POST['address2'] : "";
    $city = isset( $_POST['city'] ) ? $_POST['city'] : "";
    $state = isset( $_POST['state'] ) ? $_POST['state'] : "";
    $zip = isset( $_POST['zip'] ) ? $_POST['zip'] : "";

    $email = esc_attr(get_option('admin_email'));

    if ( $handle && $emailaddress && $address && $city && $state && $zip ) {

        $subject = "Smoke Break Influencer Inquiry";

        $headers = 'From:' . $email . "\r\n";
        $headers .= 'Reply-To:' . $emailaddress . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $headers .= "charset: ISO-8859-1\r\n";
        $headers .= "X-Mailer: PHP/".phpversion()."\r\n";

        $formcontent = '<html><body><center>';
            $formcontent .= '<table rules="all" style="border: 1px solid #cccccc; width: 600px;" cellpadding="10">';
            $formcontent .= "<tr><td><strong>Handle:</strong></td><td>".$handle."</td></tr>";
            $formcontent .= "<tr><td><strong>Email:</strong></td><td>".$emailaddress."</td></tr>";
            $formcontent .= "<tr><td><strong>Address:</strong></td><td>".$address.'<br />'.$address2.'<br />'.$city.','.$state.' '.$zip."</td></tr>";
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