<?php

/**
 * Template Name: Wholesale
 */

get_header();

if (have_posts()) : while (have_posts()) : the_post();
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
    echo '<div id="about">';
        echo '<h1>'.get_the_title().'</h1>';
        echo '<center><img src='.$image[0].' alt="Kyle Bebeau" /></center>';
        echo '<div class="text">'.get_the_content().'</div>';
        echo '<a href="https://theinitgroup.com" target="_BLANK"><img class="signature" src="'.get_stylesheet_directory_uri().'/assets/img/signature.jpg" alt="" /></a>';
        echo '<form action="" method="POST" id="wholesalefrm">';
        	echo '<div class="input">';
	        	echo '<label for="company">Company/Brand <span>*</span></label>';
	        	echo '<input type="text" name="company" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="client">Name <span>*</span></label>';
	        	echo '<input type="text" name="client" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="phone">Phone <span>*</span></label>';
	        	echo '<input type="tel" name="phone" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="emailaddress">Email Address <span>*</span></label>';
	        	echo '<input type="email" name="emailaddress" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="service">Service <span>*</span></label>';
	        	echo '<select>';
	        		echo '<option value="wholesale" selected>Wholesale</option>';
	        		echo '<option value="manufacturing">Custom Manufacturing</option>';
	        	echo '</select>';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="qty">How many pillows? <span>*</span></label>';
	        	echo '<input type="number" name="qty" />';
	        echo '</div>';
	        echo '<button type="submit">Submit</button>';
        echo '</form>';
    echo '</div>';
endwhile;
endif;

get_footer();

?>