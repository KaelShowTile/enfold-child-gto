jQuery(document).ready(function($) {

    const $trigger = $('a[title="gto-mega-menu-element"]');
    const $targetDiv = $('#gto-mega-menu-container');
    let hideTimeout;

    // Check if elements exist
    if ($trigger.length && $targetDiv.length) {
        $trigger.on('mouseenter', function() {
            // Mouse enter trigger
            clearTimeout(hideTimeout);
            $targetDiv.stop(true, true).fadeIn(200);
        });

        $trigger.on('mouseleave', function() {
            // Mouse leave trigger
            hideTimeout = setTimeout(function() {
                $targetDiv.stop(true, true).fadeOut(200);
            }, 100);
        });

        $targetDiv.on('mouseenter', function() {
            // Mouse enter menu
            clearTimeout(hideTimeout);
        });

        $targetDiv.on('mouseleave', function() {
            // Mouse leave menu
            $targetDiv.stop(true, true).fadeOut(200);
        });
    } else {
        console.log('Trigger or target element not found');
    }
});
