<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

?>

<div id="fliter-loading-icon" style="display: none;">
    <img src="/wp-content/uploads/2025/01/system-regular-719-spinner-circle-loop-snake-resize.gif" alt="Loading..." />
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/round-price.js"></script>
</div>

<?php 


do_action( 'woocommerce_before_main_content' ); 

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10   
 */

woocommerce_show_messages();

do_action( 'woocommerce_shop_loop_header' );


if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	//do_action( 'woocommerce_before_shop_loop' );

	$current_term = get_queried_object();

	// Check if it's a valid term and display the description
	if ($current_term && !is_wp_error($current_term)) {
	    // Output the term description
	    echo '<div class="taxonomy-description">';
	    echo '<p>' .wp_kses_post($current_term->description) . '</p>';
	    echo '</div>';
	}

	//load filter data from setting page
	$search_colors = get_field('colors_filter', 28905);
	$search_sizes = get_field('size_filter', 28905);
	$search_price_row = get_field('price_range', 28905);
	$search_finish = get_field('finish_filter', 28905);

	// Get current category or attribute
    $current_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $path = parse_url($current_url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $current_cate;
    $current_attr;
    $parent_category_slug = 'categroy';

    if (count($segments) == 1)
    {
        $current_cate = $segments[count($segments) - 1];
        $parent_category_slug = $current_cate;
    }
    elseif (count($segments) == 2)
    {
        $parent_category_slug = $segments[count($segments) - 2];
        $current_cate = $segments[count($segments) - 1];
    }

    //Create filters
	echo'<div class = "gto-custom-product-filter">';

	if($search_price_row)
	{
		echo '<div class="archive-fliter-dropdown">';

			echo '<button class="archive-fliter-dropdown-btn">Price</button>';

			echo '<div class="archive-fliter-dropdown-content">';

				foreach( $search_price_row as $price )
				{
					echo '<label><input type="checkbox" id="fliter-price-option" value="' . $price['minimum_price'] . '-' . $price['maximum_price'] . ' ">$' . $price['minimum_price'] . ' - $' . $price['maximum_price'] . ' </label>';
				}	

			echo '</div>';

		echo '</div>';
	}

	if($search_sizes)
	{
		if($parent_category_slug == 'size')
		{
			echo '<div class="archive-fliter-dropdown hide-this-area">';
		}
		else
		{
			echo '<div class="archive-fliter-dropdown">';
		}
				echo '<button class="archive-fliter-dropdown-btn">Size</button>';

				echo '<div class="archive-fliter-dropdown-content">';

					foreach( $search_sizes as $size )
					{
						echo '<label><input type="checkbox" id="fliter-size-option" value="' . esc_attr($size->term_id) . '">' . esc_html($size->name) . '</label>';
					}	

				echo '</div>';

			echo '</div>';
	}

	if($search_colors)
	{
		
		if($parent_category_slug == 'colours')
		{
			echo '<div class="archive-fliter-dropdown hide-this-area">';
		}
		else
		{
			echo '<div class="archive-fliter-dropdown">';
		}
				echo '<button class="archive-fliter-dropdown-btn">Colour</button>';

				echo '<div class="archive-fliter-dropdown-content">';

					foreach( $search_colors as $color )
					{
						echo '<label><input type="checkbox" id="fliter-color-option" value="' . esc_attr($color->term_id) . '">' .esc_html($color->name) . '</label>';
					}

				echo '</div>';	

			echo '</div>';
	}

	if($search_finish)
	{
		if($parent_category_slug == 'finish')
		{
			echo '<div class="archive-fliter-dropdown hide-this-area">';
		}
		else
		{
			echo '<div class="archive-fliter-dropdown">';
		}
				echo '<button class="archive-fliter-dropdown-btn">Finish</button>';

				echo '<div class="archive-fliter-dropdown-content">';

					foreach( $search_finish as $finish )
					{
						echo '<label><input type="checkbox" id="fliter-finish-option" value="' . esc_attr($finish->term_id) . '">' .esc_html($finish->name) . '</label>';
					}

				echo '</div>';	

			echo '</div>';
	}

		echo '<div class="archive-fliter-dropdown hide-this-area">';

			echo '<p id="current-parent-slug">' . $parent_category_slug . '<p>';
			
			if($current_cate)
			{
				echo '<p id="current-child-slug">' . $current_cate . '<p>';
			}
			
		echo '</div>';

	echo '</div>';

	echo '<div id = "product-list">';

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	echo '</div>';

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );

	if ( ! is_tax( 'product_cat' ) ) { ?>
		
		<script type="text/javascript">
		    var ajaxfilter = {
		        ajaxurl: "<?php echo admin_url('admin-ajax.php'); ?>"
		    };
		</script>
		<script type="text/javascript" src="https://www.gettilesonline.com.au/wp-content/themes/enfold-child/js/ajax-filter.js" id="ajax-filter-js"></script>

		<?php
	}


} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
} ?>

<div class="category-page-review-list-container container">

	<h2>Customer Reviews</h2>

	<div class="gto-product-review-list">

	<?php 

	$reviews = get_product_reviews(0);
	$total_review = 0;
	$total_score = 0;

	if (!empty($reviews))
	{
		foreach ($reviews as $review)
		{
			if(esc_html($review->show_review == 1))
			{
				$rating_score = $review->product_rating;
				$full_stars = floor($rating_score);
				$half_star = ($rating_score - $full_stars) >= 0.5 ? 1 : 0; 
				$empty_stars = 5 - $full_stars - $half_star;

				$total_review ++;
				$total_score = $total_score + $rating_score;

				?>

				<li class="gto-product-review-item">

					<h5 class="reviewr-name"><?php echo esc_html($review->customer_name); ?></h5>
					<p class="review-date"><?php echo date('F j, Y', strtotime($review->review_date)); ?></p>

					<div class="rating-stars-container">

					    <?php for ($i = 1; $i <= $full_stars; $i++): ?>
					        <span class="rating-stars filled">&starf;</span> <!-- Full star -->
					    <?php endfor; ?>
					    
					    <?php if ($half_star): ?>
					        <span class="rating-stars half">&starf;</span> <!-- Half star -->
					    <?php endif; ?>
					    
					    <?php for ($i = 1; $i <= $empty_stars; $i++): ?>
					        <span class="rating-stars">&starf;</span> <!-- Empty star -->
					    <?php endfor; ?>

					</div>

					<?php 
						if(!empty($review->review_imgs))
						{
							$images = explode(',', $review->review_imgs);

							echo '<div class="review-images">';

					            foreach ($images as $image) 
					            {
					                echo '<a href="/submit-review/' . $image . '" lightbox-added><img src="/submit-review/' . $image . '" alt="Review Image" "></a>';
					            }

				            echo '</div>';
						}
					?>

					<p class= "review-content"><?php echo esc_html($review->review_content); ?></p>

				</li>

			<?php }
		}
	}
	else
	{
		echo '<p class="no-review">No Review Found.</p>';
	}

	?>

	</div>

</div>

<?php 

$current_category = get_queried_object();
    
// Get the custom field value
$below_category_content = get_field('below_category_content', 'product_cat_' . $current_category->term_id);

if ($below_category_content) 
{
    echo '<div class="container">';
        echo '<div class="below-category-content">';
        echo $below_category_content;
        echo '</div>';
    echo '</div>';
}

// Q&A

echo '<div class="container cate-qa-container">';

$qa_cate = get_field('qna_for_category', 'product_cat_' . $current_category->term_id);

if( $qa_cate ){

	$qa_shortcode_string = "[av_toggle_container faq_markup='faq_markup' initial='0' mode='accordion' sort='' styling='' colors='' font_color='' background_color='' border_color='' toggle_icon_color='' colors_current='' font_color_current='' toggle_icon_color_current='' background_current='' background_color_current='' background_gradient_current_direction='vertical' background_gradient_current_color1='#000000' background_gradient_current_color2='#ffffff' background_gradient_current_color3='' hover_colors='' hover_font_color='' hover_background_color='' hover_toggle_icon_color='' size-toggle='' av-desktop-font-size-toggle='' av-medium-font-size-toggle='' av-small-font-size-toggle='' av-mini-font-size-toggle='' size-content='' av-desktop-font-size-content='' av-medium-font-size-content='' av-small-font-size-content='' av-mini-font-size-content='' heading_tag='' heading_class='' alb_description='' id='conept-qna-container' custom_class='' template_class='' element_template='' one_element_template='' av_uid='av-md2dbkdv' sc_version='1.0' admin_preview_bg='']";

	echo "<h2>Q&A</h2>";

	foreach ($qa_cate as $row){
		$question = esc_html($row['qnac_question']);
		$answer = esc_html($row['qnac_answer']);

		$qa_shortcode_string = $qa_shortcode_string . "[av_toggle title='" . $question . "' title_open='' tags='' title_pos='' slide_speed='' custom_id='' aria_collapsed='' aria_expanded='' element_template='' one_element_template='' av_uid='' sc_version='1.0' ]" . $answer . "[/av_toggle]";
	}

	$qa_shortcode_string = $qa_shortcode_string . "[/av_toggle_container]";
	echo do_shortcode($qa_shortcode_string);
}
echo '</div>';


/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
