<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

get_header( 'full' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="productBanner">
				<img src="<?php echo bloginfo('stylesheet_directory');?>/assets/img/ogkush/pillow-main.png" alt="" />
			</div>
			<div class="col-full productWrap">
				<div class="itemInfo">
					<?php 
						the_title("<h1>","</h1>");
						echo '<div class="itemPrice">';
							echo $product->get_price_html();
						echo '</div>';
						echo '<div class="itemCart">';
							wc_get_template( 'single-product/add-to-cart/simple.php' );
						echo '</div>';
					?>
					<img src="<?php echo bloginfo('stylesheet_directory');?>/assets/img/creditcards.png" alt="" />
				</div>

				<div id="itemDesc">
					<div class="half">
						<h3>Description</h3>
						<?php the_content(); ?>
					</div>
					<div class="half images">
						<!-- Add carousel of product images here -->
						<!-- the viewport -->
						<div class="m-scooch m-fluid">
							<!-- the slider -->
							<div class="m-scooch-inner">
								<?php
									$attachment_ids = $product->get_gallery_image_ids();
									if ( $attachment_ids && $product->get_image_id() ) {
										$cnt = 1;
										foreach ( $attachment_ids as $attachment_id ) {
											if($cnt === 1) {
												echo '<div class="m-item m-active">';
											} else {
												echo '<div class="m-item">';
											}
											echo wp_get_attachment_image($attachment_id, 'large');
											echo '</div>';
											$cnt++;
										}
									}
								?>
							</div>
							<div class="m-scooch-controls m-scooch-bulleted">
							    <a href="#" data-m-slide="1" class="m-active"></a>
							    <?php
									if ( $attachment_ids && $product->get_image_id() ) {
										$cnt = 1;
										foreach ( $attachment_ids as $attachment_id ) {
											$cnt++;
											echo '<a href="#" data-m-slide="'.$cnt.'"></a>';
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>

				<div id="itemPress">
					<h4>As Seen On...</h4>
					<a href="https://nowthisnews.com/weed" class="pressLogo nowThisWeed" target="_BLANK">
					</a>
					<a href="https://thechive.com" class="pressLogo theChive"target="_BLANK">
					</a>
					<a href="https://www.leafly.com" class="pressLogo leafly"target="_BLANK">
					</a>
					<a href="https://www.thrillist.com" class="pressLogo thrillist"target="_BLANK">
					</a>
				</div>

				<div id="itemSpecs">
					<div class="half">
						<img src="<?php echo bloginfo('stylesheet_directory');?>/assets/img/ogkush/pillow-specs.jpg" alt="" />
					</div>
					<div class="half">
						<h3>Product Specs</h3>
						<ul>
							<li>
								18 inches by 18 inches
							</li>
							<li>
								100% polyester case and insert
							</li>
							<li>
								Hidden zipper
							</li>
							<li>
								Machine-washable cover
							</li>
							<li>
								Shape-retaining polyester insert included
							</li>
						</ul>
					</div>
				</div>

				<div id="itemReviews">
				</div>

				<div class="itemInfo mypillow">
					<img id="pillowGuy" src="<?php echo bloginfo('stylesheet_directory');?>/assets/img/ogkush/pillowguy.png" alt="" />
					<div class="itemCheckout">
						<h3>Get Yours Today!</h3>
						<?php
							echo '<div class="itemPrice">';
								echo $product->get_price_html();
							echo '</div>';
							echo '<div class="itemCart">';
								wc_get_template( 'single-product/add-to-cart/simple.php' );
							echo '</div>';
						?>
						<img src="<?php echo bloginfo('stylesheet_directory');?>/assets/img/creditcards.png" alt="" />
					</div>
				</div>
			</div>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
