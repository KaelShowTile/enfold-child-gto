<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
global $product;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

// Get all product categories
$get_product_id = $product->get_id();
$terms = get_the_terms($get_product_id, 'product_cat');
$current_url = get_permalink($get_product_id);
$categories = array();

if ($terms && !is_wp_error($terms)) {
    
    // Organize categories by parent
    foreach ($terms as $term) {
        $categories[$term->parent][] = $term;
    }
}

if ( ! $short_description &&  ! $terms) {
	return;
}


?>
<div class="woocommerce-product-details__short-description">

	<div>

		<div class = "product-categories-list-container">

			<?php 

				if (isset($categories[0])){

					foreach ($categories[0] as $parent_category){						
						$parent_category_name = $parent_category->name;
						$parent_category_id = $parent_category->term_id;
						$parent_category_url = get_term_link($parent_category->term_id, 'product_cat');

						if ($parent_category_name == "Size"){
							echo '<li>';
				        		echo '<a class="parent-categories-item" href="' . $parent_category_url . '">';
				        		echo esc_html($parent_category_name) . ':'; 
				        		echo '</a>';

				        		echo '<p>';

				        		if (isset($categories[$parent_category_id])){
				        			$cat_count = 0;

				        			foreach ($categories[$parent_category_id] as $child_category){ 
				        				$child_category_url = get_term_link($child_category->term_id, 'product_cat');

				        				if ($cat_count !== 0){
				        					echo ', ';
				        				}  

				        				echo '<a class="child-categories-item" href="' . $child_category_url . '">';

				        				$custom_size = $product->get_attribute('pa_size');
				        				if(empty($custom_size)){
				        					echo esc_html($child_category->name);
				        				}
				        				else{
				        					echo $custom_size;
				        				}

				        				echo '</a>';

				        				$cat_count = $cat_count + 1;
				        			}

				        		} 

				        		echo '</p>';

				        	echo'</li>';
						}

					}

					foreach ($categories[0] as $parent_category){						
						$parent_category_name = $parent_category->name;
						$parent_category_id = $parent_category->term_id;
						$parent_category_url = get_term_link($parent_category->term_id, 'product_cat');

						if($parent_category_name !== "Tiles on sale" && $parent_category_name !== "Size"){ 	
			        		echo '<li>';
				        		echo '<a class="parent-categories-item" href="' . $parent_category_url . '">';
				        		echo esc_html($parent_category_name). ':'; 
				        		echo '</a>';

				        		echo '<p>';

				        		if (isset($categories[$parent_category_id])){
				        			$cat_count = 0;

				        			foreach ($categories[$parent_category_id] as $child_category){ 
				        				$child_category_url = get_term_link($child_category->term_id, 'product_cat');

				        				if ($cat_count !== 0){
				        					echo ', ';
				        				}  

				        				echo '<a class="child-categories-item" href="' . $child_category_url . '">';
				        				echo esc_html($child_category->name);  
				        				echo '</a>';

				        				$cat_count = $cat_count + 1;
				        			}
				        		} 
				        		echo '</p>';
				        	echo'</li>';
			        	}
					}

					/*ACF parameters

					$has_finish_attr = $product->get_attribute('pa_finish');

				    if(get_field('finish') || $has_finish_attr){
				        echo '<li>';
				        	echo '<p class="parent-categories-item">Finish:</p>';
				        	echo '<p class="child-categories-item">'; 
							if(get_field('finish')){
								echo esc_html(the_field('finish'));
							}else{
								echo $has_finish_attr;
							}
				        	echo '</p>';
				        echo'</li>';
				    }

					$has_edge_attr = $product->get_attribute('pa_edge');

				    if(get_field('edge') || $has_edge_attr){
				        echo '<li>';
				        	echo '<p class="parent-categories-item">Edge:</p>';
				        	echo '<p class="child-categories-item">'; 
							if(get_field('edge')){
								echo esc_html(the_field('edge'));
							}else{
								echo $has_edge_attr;
							}
				        	echo '</p>';
				        echo'</li>';
				    }

					$has_thickness_attr = $product->get_attribute('pa_thickness');

				    if(get_field('thickness') || $has_thickness_attr){
				        echo '<li>';
				        	echo '<p class="parent-categories-item">Thickness:</p>';
				        	echo '<p class="child-categories-item">'; 
							if(get_field('thickness')){
								echo esc_html(the_field('thickness'));
							}else{
								echo $has_thickness_attr;
							}
				        	echo '</p>';
				        echo'</li>';
				    }

					$has_package_attr = $product->get_attribute('pa_package');

				    if(get_field('package') || $has_package_attr){
				        echo '<li>';
				        	echo '<p class="parent-categories-item">Package:</p>';
				        	echo '<p class="child-categories-item">'; 
							if(get_field('package')){
								echo esc_html(the_field('package'));
							}else{
								echo $has_package_attr;
							}
				        	echo '</p>';
				        echo'</li>';
				    }

					$has_slip_rate_attr = $product->get_attribute('pa_slip_rate');

				    if(get_field('slip_rate') || $has_slip_rate_attr){
				        echo '<li>';
				        	echo '<p class="parent-categories-item">Slip Rate:</p>';
				        	echo '<p class="child-categories-item">'; 
							if(get_field('slip_rate')){
								echo esc_html(the_field('slip_rate'));
							}else{
								echo $has_slip_rate_attr;
							}
				        	echo '</p>';
				        echo'</li>';
				    }

					$has_grout_attr = $product->get_attribute('pa_grout-colour');

				    if(get_field('grout') || $has_grout_attr){
				        echo '<li>';
				        	echo '<p class="parent-categories-item">Grout Colour:</p>';
				        	echo '<p class="child-categories-item">'; 
							if(get_field('grout')){
								echo esc_html(the_field('grout'));
							}else{
								echo $has_grout_attr;
							}
				        	echo '</p>';
				        echo'</li>';
				    } 
						
					*/
				}
			?>

		</div>

	</div>

	<?php echo $short_description; // WPCS: XSS ok.if (function_exists('display_linked_product'))
	if (function_exists('display_linked_product'))
	{
		echo display_linked_product($get_product_id);
	} ?>

	</div>
	
</div>
