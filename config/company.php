<?php

// config/company.php

return [

    /*
    |--------------------------------------------------------------------------
    | Company Contact Information
    |--------------------------------------------------------------------------
    |
    | Stores static company details used across the site, like in the
    | contact page or footer. Use `config('company.key')` to access.
    |
    */

    'address' => 'tripix wQ 966 munich Express 70 Germany, park lan, TX 7859', // <-- EDIT THIS

    'phone' => [
        // Using descriptive keys for clarity
        'customer_service_1' => [
            'display' => '+9-555-888-679', // <-- EDIT THIS (What the user sees)
            'link' => 'tel:+9555888679',    // <-- EDIT THIS (The actual tel: link)
        ],
        'customer_service_2' => [
            'display' => '+9-666-888-679', // <-- EDIT THIS
            'link' => 'tel:+9666888679',    // <-- EDIT THIS
        ],
        // Add more numbers if needed following the same pattern
        // 'sales' => [
        //     'display' => '...',
        //     'link' => 'tel:...',
        // ],
    ],

    'email' => [
        'careers' => 'careers@example.com', // <-- EDIT THIS
        'info' => 'info@example.com',      // <-- EDIT THIS
        // Add more emails if needed
        // 'support' => 'support@example.com',
    ],

    'socials' => [
        'twitter' => [
            'url' => 'https://x.com/mounirakajiayour_handle', // <-- EDIT THIS (Your actual URL)
            'icon' => 'fa-brands fa-x-twitter', // Font Awesome class (usually keep as is)
            'title' => 'Twitter/X',             // Tooltip text
        ],
        'instagram' => [
            'url' => 'https://www.instagram.com/your_handle', // <-- EDIT THIS
            'icon' => 'fa-brands fa-instagram',
            'title' => 'Instagram',
        ],
        'linkedin' => [
            'url' => 'https://www.instagram.com/colored.morocco/company/your_page', // <-- EDIT THIS (or # if none)
            'icon' => 'fa-brands fa-linkedin-in',
            'title' => 'LinkedIn',
        ],
        'vimeo' => [
            'url' => 'https://vimeo.com/your_channel', // <-- EDIT THIS (or # if none)
            'icon' => 'fa-brands fa-vimeo-v',
            'title' => 'Vimeo',
        ],
        // Add more social platforms if needed
        // 'facebook' => [
        //     'url' => '...',
        //     'icon' => 'fa-brands fa-facebook-f',
        //     'title' => 'Facebook',
        // ],
    ],

    // You could add map coordinates or other details here too
    'map_iframe_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d230224.800092822!2d-74.18376824029953!3d40.697646270765524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1737472871311!5m2!1sen!2sbd', // <-- EDIT THIS (Your Google Maps embed source)

];