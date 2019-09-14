<?php

/**
 * Template Name: Shop Home
 */

get_header();

// $args = array(
//     'orderby'    => 'title',
//     'order'      => 'ASC'
// );
// $product_categories = get_terms( 'product_cat', $args );
// $count = count($product_categories);
// if ( $count > 0 ){
//     foreach ( $product_categories as $product_category ) {
//         echo '<h4><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</a></h4>';
//         $args = array(
//             'posts_per_page' => -1,
//             'tax_query' => array(
//                 'relation' => 'AND',
//                 array(
//                     'taxonomy' => 'product_cat',
//                     'field' => 'slug',
//                     // 'terms' => 'white-wines'
//                     'terms' => $product_category->slug
//                 )
//             ),
//             'post_type' => 'product',
//             'orderby' => 'title,'
//         );
//         $products = new WP_Query( $args );
//         echo "<div>";
//         while ( $products->have_posts() ) {
//             $products->the_post();
//         }
//         echo "</div>";
//     }
// }

$args = array(
    'posts_per_page' => -1,
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            // 'terms' => 'white-wines'
            'terms' => 'pillows'
        )
    ),
    'post_type' => 'product',
    'orderby' => 'date',
    'order' => 'asc'
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
                    if($product->get_sale_price()) {
                        echo '<span class="regular sale">$'.number_format($product->get_regular_price()). '</span>';
                        echo '<span class="sale">$'.number_format($product->get_sale_price()). '</span>';
                    } else {
                        echo '<span class="regular">$'.number_format($product->get_price()). '</span>';
                    }
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
            <?php the_post_thumbnail("medium"); ?>
            <div class="listprice">
                <?php 
                    if($product->get_sale_price()) {
                        echo '<span class="regular sale">$'.number_format($product->get_regular_price()). '</span>';
                        echo '<span class="sale">$'.number_format($product->get_sale_price()). '</span>';
                    } else {
                        echo '<span class="regular">$'.number_format($product->get_price()). '</span>';
                    }
                ?>
            </div>
        </a>
    <?php
}
echo "</div>";
wp_reset_query();

get_footer();

?>