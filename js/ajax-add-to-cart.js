jQuery(document).ready(function($) 
{
    $(document).on('click', '#gto-add-cart-btn', function(e) {
        e.preventDefault();
        
        var $this = $(this);
        var product_id =  $this.data('product_id'); 
        var product_qty = $this.data('quantity') || 1;
        var product_name = $this.data('product_name');
        
        // Disable button during AJAX
        $this.prop('disabled', true).addClass('loading');
        
        // AJAX call
        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: product_id,
                quantity: product_qty
            },
            success: function(response) {
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                }
                
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $this]);
                $this.prop('disabled', false).removeClass('loading').text('Added!');
                $this.addClass('gto-added-item');
                
                /*Show "View cart" message
                const notification = $('<div class="woocommerce-message" role="alert" tabindex="-1">' + product_name + ' has been added to your cart.<a href="/cart" class="button wc-forward">View cart</a></div>');
                $('#top .title_container .container').append(notification);

                //scroll to the notification
                notification.fadeIn('slow', function() 
                {
                    $('html, #header_main').animate({
                        scrollTop: notification.offset().top - 300
                    }, 500); 
                });
                
                
                // Revert button text after 3 seconds
                setTimeout(function() {
                    $this.text('Add to cart');
                }, 3000);

                */
            },
            error: function() 
            {
                window.location = $this.closest('a').attr('href') || wc_add_to_cart_params.cart_url;
                $this.prop('disabled', false).removeClass('loading');
            }
        });
    });
});