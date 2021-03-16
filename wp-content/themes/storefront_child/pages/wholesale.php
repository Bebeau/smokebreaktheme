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
        	
        	echo '<h3>Contact</h3>';
        	echo '<div class="half">';
		        echo '<div class="input">';
		        	echo '<label for="firstName">First Name <span>*</span></label>';
		        	echo '<input type="text" name="firstName" />';
		        echo '</div>';
		        echo '<div class="input">';
		        	echo '<label for="lastName">Last Name <span>*</span></label>';
		        	echo '<input type="text" name="lastName" />';
		        echo '</div>';
		    echo '</div>';

		    echo '<div class="half">';
		        echo '<div class="input">';
		        	echo '<label for="phone">Phone <span>*</span></label>';
		        	echo '<input type="tel" name="phone" />';
		        echo '</div>';
		        echo '<div class="input">';
		        	echo '<label for="emailaddress">Email Address <span>*</span></label>';
		        	echo '<input type="email" name="emailaddress" />';
		        echo '</div>';
		    echo '</div>';

		    echo '<h3>Shipping</h3>';
	        echo '<div class="input">';
	        	echo '<label for="company">Company/Brand <span>*</span></label>';
	        	echo '<input type="text" name="company" />';
	        echo '</div>';

	        echo '<div class="input">';
	        	echo '<label for="address">Address <span>*</span></label>';
	        	echo '<input type="text" name="address" />';
	        echo '</div>';

	        echo '<div class="input">';
	        	echo '<label for="address2">Apt/Suite/Unit</label>';
	        	echo '<input type="text" name="address2" />';
	        echo '</div>';

	        echo '<div class="third">';
		        echo '<div class="input">';
		        	echo '<label for="city">City <span>*</span></label>';
		        	echo '<input type="text" name="city" />';
		        echo '</div>';
		        echo '<div class="input">';
		        	echo '<label for="state">State <span>*</span></label>';
		        	echo '<select id="state">';
		        		echo '<option value="AL">Alabama</option>';
						echo '<option value="AK">Alaska</option>';
						echo '<option value="AZ">Arizona</option>';
						echo '<option value="AR">Arkansas</option>';
						echo '<option value="CA">California</option>';
						echo '<option value="CO">Colorado</option>';
						echo '<option value="CT">Connecticut</option>';
						echo '<option value="DE">Delaware</option>';
						echo '<option value="DC">District Of Columbia</option>';
						echo '<option value="FL">Florida</option>';
						echo '<option value="GA">Georgia</option>';
						echo '<option value="HI">Hawaii</option>';
						echo '<option value="ID">Idaho</option>';
						echo '<option value="IL">Illinois</option>';
						echo '<option value="IN">Indiana</option>';
						echo '<option value="IA">Iowa</option>';
						echo '<option value="KS">Kansas</option>';
						echo '<option value="KY">Kentucky</option>';
						echo '<option value="LA">Louisiana</option>';
						echo '<option value="ME">Maine</option>';
						echo '<option value="MD">Maryland</option>';
						echo '<option value="MA">Massachusetts</option>';
						echo '<option value="MI">Michigan</option>';
						echo '<option value="MN">Minnesota</option>';
						echo '<option value="MS">Mississippi</option>';
						echo '<option value="MO">Missouri</option>';
						echo '<option value="MT">Montana</option>';
						echo '<option value="NE">Nebraska</option>';
						echo '<option value="NV">Nevada</option>';
						echo '<option value="NH">New Hampshire</option>';
						echo '<option value="NJ">New Jersey</option>';
						echo '<option value="NM">New Mexico</option>';
						echo '<option value="NY">New York</option>';
						echo '<option value="NC">North Carolina</option>';
						echo '<option value="ND">North Dakota</option>';
						echo '<option value="OH">Ohio</option>';
						echo '<option value="OK">Oklahoma</option>';
						echo '<option value="OR">Oregon</option>';
						echo '<option value="PA">Pennsylvania</option>';
						echo '<option value="RI">Rhode Island</option>';
						echo '<option value="SC">South Carolina</option>';
						echo '<option value="SD">South Dakota</option>';
						echo '<option value="TN">Tennessee</option>';
						echo '<option value="TX">Texas</option>';
						echo '<option value="UT">Utah</option>';
						echo '<option value="VT">Vermont</option>';
						echo '<option value="VA">Virginia</option>';
						echo '<option value="WA">Washington</option>';
						echo '<option value="WV">West Virginia</option>';
						echo '<option value="WI">Wisconsin</option>';
						echo '<option value="WY">Wyoming</option>';
		        	echo '</select>';
		        echo '</div>';
		        echo '<div class="input">';
		        	echo '<label for="zip">Zipcode <span>*</span></label>';
		        	echo '<input type="text" name="zip" />';
		        echo '</div>';
		    echo '</div>';

		    echo '<h3>Order Details</h3>';
	        echo '<div class="input">';
	        	echo '<label for="service">Service <span>*</span></label>';
	        	echo '<select id="service">';
	        		echo '<option value="wholesale" selected>Wholesale</option>';
	        		echo '<option value="manufacturing">White Label</option>';
	        	echo '</select>';
	        echo '</div>';

	        echo '<div class="input">';
	        	echo '<label for="qty">How many pillows? <span>*</span></label>';
	        	echo '<input type="number" name="qty" min="10" value="10" />';
	        echo '</div>';
	        echo '<button type="submit">Submit</button>';
        echo '</form>';
    echo '</div>';
endwhile;
endif;

get_footer();

?>