jQuery(document).ready(function($) 
{
    $('#generate-tile-set').on('click', function() 
    {
        // Retrieve the sampleList from local storage
        let sampleList = JSON.parse(localStorage.getItem('sampleList')) || [];

        // Create an array to hold product names
        let productNames = [];

        // Loop through the sampleList and extract product names
        $.each(sampleList, function(index, product) {
            if (product.name) { 
                productNames.push(product.name);
            }
        });

        // Join the names into a single string, separated by commas 
        let passName = productNames.join(', ');

        // Save the new string in local storage  
        localStorage.setItem('passName', passName);
        localStorage.setItem('sampleList', JSON.stringify([]));

    });
});


