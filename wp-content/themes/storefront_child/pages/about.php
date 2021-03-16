<?php

/**
 * Template Name: About
 */

get_header();

if (have_posts()) : while (have_posts()) : the_post();
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
    echo '<div id="about">';
        // echo '<h1>'.get_the_title().'</h1>';
        if($image) {
        	echo '<center><img src='.$image[0].' alt="Kyle Bebeau" /></center>';
        }
        echo '<div class="text">'.get_the_content().'</div>';
        echo '<a href="https://theinitgroup.com" target="_BLANK"><img class="signature" src="'.get_stylesheet_directory_uri().'/assets/img/signature.jpg" alt="" /></a>';
    echo '</div>';
endwhile;
endif;

get_footer();

?>