<?php

/**
 * Template Name: Shop Home
 */

get_header();

?>

<!-- <div id="holidayBanner">
    <div class="visual half" style="background: url(<?php // echo get_stylesheet_directory_uri()?>/assets/img/mypillow.jpg) no-repeat scroll center / cover;"></div>
    <div class="deal half">
        <div>
            <h2>Happy<br />4/20!</h2>
            <h3>FREE Shipping on all orders over <strong>$40</strong></h3>
        </div>
    </div>
</div> -->

<?php $args = array(
    'posts_per_page' => -1,
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'accessories'
        )
    ),
    'post_type' => 'product',
    'orderby' => 'date',
    'order' => 'asc',
    'post__in' => array(3242,444)
);
$products = new WP_Query( $args );
echo '<div id="pillows">';
while ( $products->have_posts() ) {
    $products->the_post();
    ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail("large"); ?>
            <div class="listprice">
                <?php 
                    echo '<span class="regular sale">'.$product->get_price_html(). '</span>';
                ?>
            </div>
        </a>
    <?php
}
echo "</div>";
wp_reset_query();

$args = array(
    'posts_per_page' => -1,
    'post_type' => 'product',
    'orderby' => 'date',
    'order' => 'asc',
    'post__not_in' => array(3242,444)
);
$products = new WP_Query( $args );
echo '<div id="itemlisting">';
while ( $products->have_posts() ) {
    $products->the_post();
    ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail("large"); ?>
            <div class="listprice">
                <?php 
                    echo '<span class="regular sale">'.$product->get_price_html(). '</span>';
                ?>
            </div>
        </a>
    <?php
}
echo "</div>";
wp_reset_query();

get_footer();

?>