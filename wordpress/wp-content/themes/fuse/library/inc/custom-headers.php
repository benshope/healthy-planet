<?php
// Register Theme Features
function wpgrade_custom_headers_suport()  {

    // Add theme support for Custom Header
    $header_args = array(
        'default-image'          => '',
        'width'                  => 0,
        'height'                 => 0,
        'flex-width'             => false,
        'flex-height'            => false,
        'random-default'         => false,
        'header-text'            => false,
        'default-text-color'     => '',
        'uploads'                => true,

    );
    add_theme_support( 'custom-header', $header_args );
}

// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'wpgrade_custom_headers_suport' );