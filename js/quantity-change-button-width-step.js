jQuery(document).ready(function($) 
{
    // Override WooCommerce default +/- button behavior
    $(document).on('click', '.quantity .plus, .quantity .minus', function(e) 
    {
        e.preventDefault();
        
        var $input = $(this).siblings('.qty');
        var currentVal = parseFloat($input.attr('value')) || 
                        parseFloat($input.val()) || 
                        min;

        var step = parseFloat($input.attr('step'));
        var min = parseFloat($input.attr('min'));
        var max = parseFloat($input.attr('max')) || Infinity;
        
        if (isNaN(currentVal)) currentVal = min;
        if (isNaN(step)) step = 1;
        if (isNaN(min)) min = 0;
        
        if(step !== 1)
        {
            if ($(this).is('.plus')) 
            {
                var newVal = (currentVal + step).toFixed(2);
                console.log(currentVal);
                console.log(step);
                console.log(newVal);
                if (newVal > max) newVal = max;
                $input.val(newVal).change();
                $input.attr('value', newVal).val(newVal);
            } 
            else 
            {
                var newVal = (currentVal - step).toFixed(2);
                if (newVal < min) newVal = min;
                $input.val(newVal).change();
                $input.attr('value', newVal).val(newVal);
            }
        }
    });

});