<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

?>

<?php the_content(); 

if($attribute_finish)
{
    foreach($attribute_finish as $finish)
    {
        $finish_id = $finish->term_id;
        $suitablity_id= get_field('suitablity_for_finish', 'pa_finish_' . $finish_id);

        if ($suitablity_id) 
        {
            $suitability_post = get_post($suitablity_id);
            echo apply_filters('the_content', $suitability_post->post_content);
        }
        
    }
} 

?>
