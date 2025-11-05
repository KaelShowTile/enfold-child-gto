jQuery(document).ready(function($) {

    const $trigger = $('a[title="gto-mega-menu-element"]');
    const $targetDiv = $('#gto-mega-menu-container');

    // Check if elements exist
    if ($trigger.length && $targetDiv.length) {
        $trigger.on('mouseenter', function() {
            // Mouse enter
            $targetDiv.stop(true, true).fadeIn(200);
        });

        // Hide on click outside
        $(document).on('click', function(e) {
            if (!$targetDiv.is(e.target) && $targetDiv.has(e.target).length === 0 && !$trigger.is(e.target) && $trigger.has(e.target).length === 0) {
                $targetDiv.stop(true, true).fadeOut(200);
            }
        });
    } else {
        console.log('Trigger or target element not found');
    }
});
