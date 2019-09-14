	</div><!-- .col-full -->
</div><!-- #content -->

<?php do_action( 'storefront_before_footer' ); ?>

<footer>
	<img class="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg" alt="" />
	<div class="social-share">
		<a target="_blank" href="https://facebook.com/smokebreaklive" class="facebook">
		    <i class="fa fa-facebook"></i>
		</a>
		<a class="instagram" target="_blank" href="https://instagram.com/smokebreaklive">
		    <i class="fa fa-instagram"></i>
		</a>
		<a class="twitter" target="_blank" href="https://twitter.com/live_smokebreak">
		    <i class="fa fa-twitter"></i>
		</a>
	</div>
	<p>© <?php echo date("Y"); ?> Smoke Break.</p>
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/creditcards.png" alt="" />
</footer>

<?php do_action( 'storefront_after_footer' ); ?>

<?php wp_footer(); ?>