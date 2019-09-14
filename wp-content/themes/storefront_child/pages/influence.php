<?php

/**
 * Template Name: Influence
 */

get_header();

if (have_posts()) : while (have_posts()) : the_post();
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
    echo '<div id="about">';
        echo '<h1>'.get_the_title().'</h1>';
        echo '<div class="text">'.get_the_content().'</div>';
        echo '<a href="https://theinitgroup.com" target="_BLANK"><img class="signature" src="'.get_stylesheet_directory_uri().'/assets/img/signature.jpg" alt="" /></a>';
        echo '<form action="" method="POST" id="influencefrm">';
        	echo '<div class="input">';
	        	echo '<label for="company">@handle</label>';
	        	echo '<input type="text" name="company" placeholder="@" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="address">Address</label>';
	        	echo '<input type="text" name="address" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="address2">Apt/Suite/Unit</label>';
	        	echo '<input type="text" name="address2" />';
	        echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="city">City</label>';
	        	echo '<input type="text" name="city" />';
	        echo '</div>';
	        echo '<div class="input">'; ?>
	        	<label for="state">State</label>
	        	<select>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>
	        <?php echo '</div>';
	        echo '<div class="input">';
	        	echo '<label for="zip">Zip</label>';
	        	echo '<input type="text" name="zip" />';
	        echo '</div>';
	        echo '<button type="submit">Submit</button>';
        echo '</form>';
    echo '</div>';
endwhile;
endif;

get_footer();

?>