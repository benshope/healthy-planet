<?php

/*
 *
 * Require the framework class before doing anything else, so we can use the defined URLs and directories.
 * If you are running on Windows you may have URL problems which can be fixed by defining the framework url first.
 *
 */
//load the translations
load_theme_textdomain( wpGrade_txtd, get_template_directory() .'/library/languages' );

//define('Redux_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('Redux_Options')) {
    require_once(dirname(__FILE__) . '/options/defaults.php');
}

/*
 *
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections) {
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', wpGrade_txtd),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', wpGrade_txtd),
		'icon' => 'paper-clip',
		'icon_class' => '',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
//add_filter('redux-opts-sections-twenty_eleven', 'add_another_section');

/*
 * 
 * Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.
 *
 */
//function change_framework_args($args) {
//    $args['dev_mode'] = false;
//
//    return $args;
//}
//add_filter('redux-opts-args-twenty_eleven', 'change_framework_args');


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options() {
    $args = array();

    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['dev_mode_icon_class'] = '';

    // If you want to use Google Webfonts, you MUST define the api key.
    $args['google_api_key'] = 'AIzaSyB7Yj842mK5ogSiDa3eRrZUIPTzgiGopls';

    // Define the starting tab for the option panel.
    // Default: '0';
    //$args['last_tab'] = '0';

    // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
    // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
    // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
    // Default: 'standard'
    $args['admin_stylesheet'] = 'custom';

    // Add HTML before the form.
    //$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', wpGrade_txtd);

    // Add content after the form.
    //$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', wpGrade_txtd);

    // Set footer/credit line.
    //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', wpGrade_txtd);

    // Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/pixelgrade',
        'title' => __('Follow me on Twitter', wpGrade_txtd),
        'img' => Redux_OPTIONS_URL . 'img/social/Twitter.png'
    );
    $args['share_icons']['linked_in'] = array(
        'link' => 'http://www.linkedin.com/company/pixelgrade-media',
        'title' => __('Find me on LinkedIn', wpGrade_txtd),
        'img' => Redux_OPTIONS_URL . 'img/social/LinkedIn.png'
    );
    $args['share_icons']['facebook'] = array(
        'link' => 'http://www.facebook.com/PixelGradeMedia',
        'title' => __('Find me on LinkedIn', wpGrade_txtd),
        'img' => Redux_OPTIONS_URL . 'img/social/Facebook.png'
    );

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = '';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = WPGRADE_SHORTNAME .'_options';

    // Set a custom menu icon.
    $args['menu_icon'] = get_template_directory_uri() . '/library/admin-panel/options/img/theme_options.png';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Theme Options', wpGrade_txtd);

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Options', wpGrade_txtd);

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: redux_options
    $args['page_slug'] = WPGRADE_SHORTNAME .'_options';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    //$args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options-general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    $args['page_position'] = '60.66';

    // Set a custom page icon class (used to override the page icon next to heading)
    //$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';
	//$args['dev_mode_icon_type'] = 'image';
	//$args['import_icon_type'] == 'image';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
//    $args['help_tabs'][] = array(
//        'id' => 'redux-opts-1',
//        'title' => __('Theme Information 1', wpGrade_txtd),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', wpGrade_txtd)
//    );
//    $args['help_tabs'][] = array(
//        'id' => 'redux-opts-2',
//        'title' => __('Theme Information 2', wpGrade_txtd),
//        'content' => __('<p>This is the tab content, HTML is allowed.</p>', wpGrade_txtd)
//    );

    // Set the help sidebar for the options page.                                        
    //$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', wpGrade_txtd);

    /*
     * Create a taxonomy list
     */

    $sections = array();

    $sections[] = array(
        'icon' => 'cogs',
        'icon_class' => '',
        'title' => __('General Options', wpGrade_txtd),
        'desc' => __('<p class="description">Welcome to the '. WPGRADE_THEMENAME .' options panel! You can switch between option groups by using the left-hand tabs.</p>', wpGrade_txtd),
        'fields' => array(
			array(
                'id' => 'wpGrade_import_demodata_button',
                'type' => 'raw_html_option',
                'title' => __('Import Demo Data', wpGrade_txtd),
                'sub_desc' => __('Here you can import the demo data and get on your way of setting up the site like the theme demo.', wpGrade_txtd),
                'html' => import(),
            ),
            array(
                'id' => 'use_smooth_scrool',
                'type' => 'checkbox',
                'title' => __('Smooth Scrolling', wpGrade_txtd),
                'sub_desc' => __('Enable/ Disable smooth scrolling option', wpGrade_txtd),
                'std' => '1',
                'switch' => true
            ),
            array(
                'id' => 'portfolio_use_taxonomies_info_alert',
                'type' => 'info',
                'desc' => __('<h2>Branding Options</h2>', wpGrade_txtd)
            ),
            array(
                'id' => 'main_logo',
                'type' => 'upload',
                'title' => __('Main Logo', wpGrade_txtd),
                'sub_desc' => __('Upload here your logo image (we recommend a height of 80-100px).If there is no image uploaded, plain text will be used instead (generated from the site\'s name).
     ', wpGrade_txtd),
            ),
            array(
                'id' => 'main_small_logo',
                'type' => 'upload',
                'title' => __('Smaller Logo', wpGrade_txtd),
                'sub_desc' => __('Add a smaller logo with less detail for the sticky header that appear on scroll. If there is no image uploaded, main logo or plain text will be used instead.
     ', wpGrade_txtd),
            ),
            array(
                'id' => 'use_retina_logo',
                'type' => 'checkbox_hide_below',
                'title' => __('Retina 2x Logo', wpGrade_txtd),
                'sub_desc' => __('To be Retina-ready you need to add a 2x logo image (double the dimensions of the 1x logo above).', wpGrade_txtd),
                'switch' => true
            ),
            array(
                'id' => 'retina_main_logo',
                'type' => 'upload',
                'title' => __('Retina 2x Logo Image', wpGrade_txtd),
            ),
            array(
                'id' => 'favicon',
                'type' => 'upload',
                'title' => __('Favicon', wpGrade_txtd),
                'sub_desc' => __('Upload a 16px x 16px image that will be used as a favicon.', wpGrade_txtd),
            ),
            array(
                'id' => 'apple_touch_icon',
                'type' => 'upload',
                'title' => __('Apple Touch Icon', wpGrade_txtd),
                'sub_desc' => __('You can customize the icon for the Apple touch shortcut to your website. The size of this icon must be 77x77px.', wpGrade_txtd)
            ),
            array(
                'id' => 'metro_icon',
                'type' => 'upload',
                'title' => __('Metro Icon', wpGrade_txtd),
                'sub_desc' => __('You can customize the icon for the shortcuts of your website in the Metro interface. The size of this icon must be 144x144px.', wpGrade_txtd)
            ),
			array(
                'id' => 'google_analytics',
                'type' => 'textarea',
                'title' => __('Google Analytics', wpGrade_txtd),
                'sub_desc' => __('Paste here your Google Analytics tracking code (or for what matters any tracking code) and we will put it on every page.', wpGrade_txtd),
                'desc' => __('', wpGrade_txtd)
            ),
        )
    );
    // Style Options
    $sections[] = array(
        'icon' => "quote-right",
        'icon_class' => '',
        'title' => __('Style Options', wpGrade_txtd),
        'desc' => __('<p class="description">Give some style to your website!</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'main_color',
                'type' => 'color',
                'title' => __('Main Color', wpGrade_txtd),
                'sub_desc' => __('Use the color picker to change the main color of the site to match your brand color.', wpGrade_txtd),
				'std' => '#28a0ff'
            ),
            array(
                'id' => 'use_google_fonts',
                'type' => 'checkbox_hide_below',
                'title' => __('Do you need custom web fonts?', wpGrade_txtd),
                'sub_desc' => __('Tap into the massive <a href="http://www.google.com/fonts/">Google Fonts</a> collection (with Live preview).', wpGrade_txtd),
                'std' => '0',
                'switch' => true,
                'next_to_hide' => 3
            ),
            array(
                'id' => 'google_main_font',
                'type' => 'google_webfonts',
                'title' => __('Main Font', wpGrade_txtd),
                'sub_desc' => 'Select a font for the main titles'
            ),
            array(
                'id' => 'google_body_font',
                'type' => 'google_webfonts',
                'title' => __('Body Font', wpGrade_txtd),
                'sub_desc' => 'Select a font for content and other general areas'
            ),
            array(
                'id' => 'google_menu_font',
                'type' => 'google_webfonts',
                'title' => __('Menu Font', wpGrade_txtd),
                'sub_desc' => 'Select a font for menu'
            ),
			array(
                'id' => 'deactivate_stock_popup',
                'type' => 'checkbox',
                'title' => __('Do you want to use your own popup for images?', wpGrade_txtd),
                'sub_desc' => __('Set this to ON to deactivate our stock popup.', wpGrade_txtd),
                'std' => '0',
                'switch' => true
            ),
//			array(
//                'id' => 'bw_portfolio_filter',
//                'type' => 'checkbox',
//                'title' => __('Portfolio B&W Images Filter', wpGrade_txtd),
//                'sub_desc' => __('Do you want that nice black&white filter on the portfolio images?', wpGrade_txtd),
//				'std' => '1',
//                'switch' => true,
//            ),
//			array(
//                'id' => 'portfolio_text_color',
//                'type' => 'color',
//                'title' => __('Portfolio Hover Text Color', wpGrade_txtd),
//                'sub_desc' => __('Use the color picker to change the color of text and graphics that appear on hover over the portfolio items.', wpGrade_txtd),
//				'std' => '#ffffff',
//            ),
            array(
                'id' => 'custom_css',
                'type' => 'textarea',
                'title' => __('Custom CSS Style', wpGrade_txtd),
                'sub_desc' => __('Use this area to make slight css changes. It will be included in the head section of the page.', wpGrade_txtd),
                'desc' => __('', wpGrade_txtd),
                'validate' => 'html'
            ),
            array(
                'id' => 'custom_js',
                'type' => 'textarea',
                'title' => __('Custom Javascript', wpGrade_txtd),
                'sub_desc' => __('Use this area to make custom javascript calls.This code will be loaded in head section', wpGrade_txtd),
                'desc' => __('jQuery is available here.', wpGrade_txtd),
                'validate' => 'html'
            ),
            array(
                'id' => 'display_custom_css_inline',
                'type' => 'checkbox',
                'title' => __('Display Custom Css Inline', wpGrade_txtd),
                'sub_desc' => __('By default '. WPGRADE_THEMENAME .' saves all custom css settings in a file custom_css.css.php.<br />If your host doesn\'t support the .css.php mimetype you will need to display the custom css inline by turning this setting on.', wpGrade_txtd),
                'std' => '0',
                'switch' => true,
            ),
        )
    );
    $sections[] = array ('divider' => true,'title' => '' );
    // Header Options
    $sections[] = array(
        'icon' => 'bookmark',
        'icon_class' => '',
        'title' => __('Header Options', wpGrade_txtd),
        'desc' => __('<p class="description">Change header related options from here.</p>', wpGrade_txtd),
        'fields' => array(
             array(
                'id' => 'header_fixed',
                'type' => 'checkbox_hide_below',
                'next_to_hide' => 1,
                'title' => __('Sticky Header', wpGrade_txtd),
                'sub_desc' => __('Do you want the header to stay fixed on top of the browser windows when you scroll?', wpGrade_txtd),
				'std' => '1',
                'switch' => true
            ),
            array(
                'id' => 'header_searchform',
                'type' => 'checkbox',
                'title' => __('Header Search Form', wpGrade_txtd),
                'sub_desc' => __('Do you want a searchform displayed in the sticky menu?', wpGrade_txtd),
                'std' => '1',
                'switch' => true
            ),
            array(
                'id' => 'nocontent_header_height',
                'type' => 'text',
                'title' => __('Header Image Height', wpGrade_txtd),
                'sub_desc' => __('What height should the header be when there is no header content but you have a featured image (in pixels)?', wpGrade_txtd),
                'std' => '400',
            ),
        )
    );
    // Footer Options
    $sections[] = array(
        'icon' => 'bookmark-empty',
        'icon_class' => '',
        'title' => __('Footer Options', wpGrade_txtd),
        'desc' => __('<p class="description">Change footer related options from here.</p>', wpGrade_txtd),
        'fields' => array(
//            array(
//                'id' => 'use_site_wide_box',
//                'type' => 'checkbox_hide_below',
//                'title' => __('Site-Wide Call-to-Action', wpGrade_txtd),
//                'sub_desc' => __('Use a site-wide block section as a call to action area.', wpGrade_txtd),
//                'std' => '1',
//                'switch' => true,
//                'next_to_hide' => 3,
//            ),
//            array(
//                'id' => 'site_wide_section',
//                'type' => 'editor',
//                'title' => __('Site-Wide Call-to-Action Content', wpGrade_txtd),
//                'sub_desc' => __('The content that you would like to appear in the site-wide block section (html supported).', wpGrade_txtd),
//				'std' => '<h3>This is a site-wide call to action! So... action please!</h3>',
//				'rows' => 6,
//            ),
//            array(
//                'id' => 'site_wide_button_label',
//                'type' => 'text',
//                'title' => __('Button Text', wpGrade_txtd),
//                'sub_desc' => __('The label text of the call to action button.', wpGrade_txtd),
//				'std' => 'Click Me',
//            ),
//            array(
//                'id' => 'site_wide_button_link',
//                'type' => 'text',
//                'title' => __('Button Link', wpGrade_txtd),
//                'sub_desc' => __('The URL of the call to action button.', wpGrade_txtd),
//				'std' => '#',
//            ),
            array(
                'id' => 'use_footer_twitter_box',
                'type' => 'checkbox_hide_below',
                'title' => __('Twitter Box', wpGrade_txtd),
                'sub_desc' => __('Use a twitter block in footer ?', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                'next_to_hide' => 3,
            ),
            array(
                'id' => 'footer_twitter_id',
                'type' => 'text',
                'title' => __('Twitter Username', wpGrade_txtd),
                'sub_desc' => __('The username which should feed this box with tweets.', wpGrade_txtd),
                'std' => 'twitter',
            ),
            array(
                'id' => 'footer_twitter_count',
                'type' => 'text',
                'title' => __('Number of tweets', wpGrade_txtd),
                'sub_desc' => __('How many tweets would you like to show in the slider.', wpGrade_txtd),
                'std' => '3',
            ),
            array(
                'id' => 'footer_twitter_title',
                'type' => 'text',
                'title' => __('Twitter Link Title', wpGrade_txtd),
                'sub_desc' => __('The title of the box with the Twitter link.', wpGrade_txtd),
                'std' => 'Follow Us',
            ),
            array(
                'id' => 'copyright_text',
                'type' => 'editor',
                'title' => __('Copyright Text', wpGrade_txtd),
                'sub_desc' => __('Text that will appear in footer left area (eg. Copyright 2013 '. WPGRADE_THEMENAME .' All Rights Reserved).', wpGrade_txtd),
                'std' => 'Copyright 2013 '. WPGRADE_THEMENAME .' All Rights Reserved.',
				'rows' => 4,
            ),
			array(
                'id' => 'do_social_footer_menu',
                'type' => 'checkbox',
                'title' => __('Social Footer Menu', wpGrade_txtd),
                'sub_desc' => __('Show social icons in the footer. The links and order are taken from the Social and SEO Options tabs.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
            ),
        )
    );
    $sections[] = array ('divider' => true,'title' => '' );
    $sections[] = array(
        'icon' => "home",
        'icon_class' => '',
        'title' => __('Home Page', wpGrade_txtd),
        'desc' => __('<p class="description">General settings for the home page layout.</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'homepage_use_slider',
                'type' => 'checkbox_hide_below',
                'title' => __('Display Slider', wpGrade_txtd),
                'sub_desc' => __('Do you want to use the homepage parallax slider ?', wpGrade_txtd),
	            'std' => '1',
	            'switch' => true,
	            'next_to_hide' => 6,
            ),
	        array(
		        'id' => 'homepage_slider_speed',
		        'type' => 'text',
		        'title' => __('Slideshow Speed', wpGrade_txtd),
		        'sub_desc' => __('Change the speed of the slideshow .', wpGrade_txtd),
		        'std' => '7000',
	        ),
            array(
                'id' => 'homepage_slider_fullscreen',
                'type' => 'checkbox_show_below',
                'next_to_show' => 1,
                'title' => __('Fullscreen slider', wpGrade_txtd),
                'sub_desc' => __('', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
            ),
            array(
                'id' => 'homepage_slider_height',
                'type' => 'text',
                'title' => __('Slider Height', wpGrade_txtd),
                'sub_desc' => __('When not set the slider adjusts it\'s height accordin to it\'s content', wpGrade_txtd),
                'std' => '',
            ),
	        array(
		        'id' => 'homepage_slider_animation_speed',
		        'type' => 'text',
		        'title' => __('Animation Speed', wpGrade_txtd),
		        'sub_desc' => __('Change the speed of the animation .', wpGrade_txtd),
		        'std' => '1000',
	        ),
	        array(
		        'id' => 'homepage_slider_directionnav',
		        'type' => 'checkbox',
		        'title' => __('Show Direction Arrows', wpGrade_txtd),
		        'sub_desc' => __('', wpGrade_txtd),
		        'std' => '1',
		        'switch' => true,
	        ),
	        array(
		        'id' => 'homepage_slider_controlnav',
		        'type' => 'checkbox',
		        'title' => __('Show Control Bullets', wpGrade_txtd),
		        'sub_desc' => __('', wpGrade_txtd),
		        'std' => '1',
		        'switch' => true,
	        ),
            array(
                'id' => 'homepage_content1',
                'type' => 'editor',
                'title' => __('First Content Area', wpGrade_txtd),
                'sub_desc' => __('This content will be displayed after the slider', wpGrade_txtd),
				'std' => '<h1 style="text-align: center;">Congratulations!</h1>'.
							'<h3 style="text-align: center;">Your site is just around the corner.</h3>'.
							'&nbsp;'.
							'<p style="text-align: center;">Start by <strong><a href="https://www.youtube.com/watch?v=PXttlzzpTV8">watching this video</a></strong> about how to Install and Setup this theme.</p>',
                'rows' => 10,
            ),
            array(
                'id' => 'homepage_use_portfolio',
                'type' => 'checkbox_hide_below',
                'title' => __('Portfolio - Latest Items', wpGrade_txtd),
                'sub_desc' => __('Display the latest portfolio items in a full-width, grid based gallery.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
				'next_to_hide' => 3,
            ),
			array(
                'id' => 'homepage_portfolio_title',
                'type' => 'text',
                'title' => __('Latest Items Title', wpGrade_txtd),
                'sub_desc' => __('Change here the title of the latest items section on the homepage.', wpGrade_txtd),
                'std' => __('Featured Works', wpGrade_txtd),
            ),
			array(
                'id' => 'homepage_portfolio_more',
                'type' => 'text',
                'title' => __('Latest Items More', wpGrade_txtd),
                'sub_desc' => __('Change here the text of the more button for the latest items section on the homepage.', wpGrade_txtd),
                'std' => __('View portfolio', wpGrade_txtd),
            ),
			array(
                'id' => 'homepage_portfolio_limit',
                'type' => 'text',
                'title' => __('How many projects?', wpGrade_txtd),
                'sub_desc' => __('Set the number of projects you want displayed on the homepage (since we use a 3 column grid, we will use the closest number multiple of 3 to yours).', wpGrade_txtd),
				'std' => '3',
            ),
	        array(
		        'id' => 'homepage_display_latest_posts',
		        'type' => 'checkbox_hide_below',
		        'title' => __('Display Latest Posts', wpGrade_txtd),
		        'sub_desc' => __('Do you want to the latest posts on homepage ?', wpGrade_txtd),
		        'std' => '1',
		        'switch' => true,
		        'next_to_hide' => 5
	        ),
            array(
                'id' => 'homepage_latest_posts_layout',
                'type' => 'radio_img',
                'title' => __('Latest posts layout', wpGrade_txtd),
                'sub_desc' => __('Choose the layout for the latest posts module on homepage. <br>For a good patchwork layout posts need to have at least 3 images attached.', wpGrade_txtd),
                'options' => array(
                    'patchwork' => array('title' => 'Patchwork', 'img' => Redux_OPTIONS_URL . 'img/lp1.png'),
                    'rows' => array('title' => 'Rows', 'img' => Redux_OPTIONS_URL . 'img/lp2.png')
                ),
                'std' => 'rows'
            ),
	        array(
		        'id' => 'homepage_latest_posts_title',
		        'type' => 'text',
		        'title' => __('Latest Posts Title', wpGrade_txtd),
		        'sub_desc' => __('Change here the title of the latest posts section on the homepage.', wpGrade_txtd),
		        'std' => __('From the blog', wpGrade_txtd),
	        ),
	        array(
		        'id' => 'homepage_more_latest_posts',
		        'type' => 'text',
		        'title' => __('Latest Posts More', wpGrade_txtd),
		        'sub_desc' => __('Change here the text of the more button for the latest posts section on the homepage.', wpGrade_txtd),
		        'std' => __('View All Articles', wpGrade_txtd),
	        ),
	        array(
		        'id' => 'homepage_latest_posts_limit',
		        'type' => 'text',
		        'title' => __('How many posts?', wpGrade_txtd),
		        'sub_desc' => __('Set the number of posts you want displayed on the homepage.', wpGrade_txtd),
		        'std' => '3',
	        ),
			array(
                'id' => 'homepage_latest_posts_readmore',
                'type' => 'checkbox',
                'title' => __('Show read more buttons?', wpGrade_txtd),
				'sub_desc' => __('Do you want to show read more buttons under your posts excerpts and categories?', wpGrade_txtd),
				'std' => '0',
                'switch' => true
            ),
            array(
                'id' => 'homepage_content2',
                'type' => 'editor',
                'title' => __('Secondary Content Area', wpGrade_txtd),
                'sub_desc' => __('This content will be displayed after the portfolio latest items gallery.', wpGrade_txtd),
				'std' => '<h3>This is your secondary content area!</h3>',
				'rows' => 10,
            ),
        )
    );

    // prepare the contact forms  list
    $contact_forms = array();
    $contact_form_field = array();
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
    if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
        global $wpdb;
        $cf7 = $wpdb->get_results("SELECT ID, post_title
            FROM $wpdb->posts
            WHERE post_type = 'wpcf7_contact_form'
            ");
        $contact_forms = array();
        if ($cf7) {
            foreach ( $cf7 as $cform ) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        }

        $contact_form_field = array(
            'id' => 'contact_form_7',
            'type' => 'select', // create a new type with font preview
            'title' => __('Select Form', wpGrade_txtd),
            'sub_desc' => 'Select a contact form previously created with the Contact Form 7 plugin. You can create one <a href="'.admin_url( 'admin.php?page=wpcf7' ).'" title="Contact Form 7">here</a>',
            'options' => $contact_forms
        );

    } else {
        $contact_form_field = array(
            'id' => 'contact_form_7_inactive',
            'type' => 'info', // create a new type with font preview
            'title' => __('Notice', wpGrade_txtd),
            'desc' => '<p class="description">Contact form 7 is not active. You can install/activate it from <a href="'.admin_url( 'themes.php?page=install-required-plugins' ).'" title="Contact Form 7">here</a></p>',
        );
    }

    //Contact Page
    $sections[] = array(
        'icon' => "envelope",
        'icon_class' => '',
        'title' => __('Contact Page', wpGrade_txtd),
        'desc' => __('<p class="description">General settings for the contact page template!</p>', wpGrade_txtd),
        'fields' => array(
           array(
               'id' => 'contact_form_title',
               'type' => 'text',
               'title' => __('First Box Title', wpGrade_txtd),
               'std' => "Get in Touch",
           ),
           array(
               'id' => 'contact_content_left',
               'type' => 'editor',
               'title' => __('First Box Content', wpGrade_txtd),
               'sub_desc' => __('This content will be displayed on the left side of the contact form.', wpGrade_txtd),
               'std' => '<p>If you have questions or comments, please get a hold of us in whichever way is most convenient.</p><p>Ask away. There is no reasonable question that our team can not answer.</p>',
               'rows' => 10,
           ),
            
            $contact_form_field,
           array(
               'id' => 'contact_info_title',
               'type' => 'text',
               'title' => __('Contact Info Title', wpGrade_txtd),
               'std' => "Reach Us",
           ),
            array(
                'id' => 'contact_phone',
                'type' => 'text',
                'title' => __('Phone Number', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_email',
                'type' => 'text',
                'title' => __('Email Address', wpGrade_txtd),
            ),
            array(
                'id' => 'contact_address',
                'type' => 'text',
                'title' => __('Address', wpGrade_txtd),
            ),
//            array(
//                'id' => 'contact_use_gmap',
//                'type' => 'checkbox_hide_below',
//                'title' => __('Use Google Maps?', wpGrade_txtd),
//                'sub_desc' => __('Do you want to use a Google map or keep using the featured image on top?', wpGrade_txtd),
//                'std' => '0',
//                'switch' => true
//            ),
            array(
                'id' => 'contact_gmap_link',
                'type' => 'textarea',
                'title' => __('Google Maps Link', wpGrade_txtd),
				'desc' => '',
				'sub_desc' => __('Paste here the the URL that you\'ve got from Google Maps, after navigating to your location.<br />Here it is <a href="http://screenr.com/MjV7" target="_blank">a short movie</a> showing you how to get the URL', wpGrade_txtd),
            ),
			array(
                'id' => 'contact_gmap_custom_style',
                'type' => 'checkbox',
                'title' => __('Custom Styling for Map?', wpGrade_txtd),
				'sub_desc' => __('Allow us to change the map colors to better match your website.', wpGrade_txtd),
				'std' => '1',
                'switch' => true
            ),
            
            
            
        )
    );
    $sections[] = array ('divider' => true,'title' => '' );

    $sections[] = array(
        'icon' => 'camera',
        'icon_class' => '',
        'title' => __('Portfolio Options', wpGrade_txtd),
        'desc' => __('<p class="description">General settings for portfolio items.</p>', wpGrade_txtd),
        'fields' => array(
			array(
                'id' => 'portfolio_title',
                'type' => 'editor',
                'title' => __('Portfolio Archive Title', wpGrade_txtd),
                'sub_desc' => __('This is the title of the portfolio page (it will appear over the header image bellow).', wpGrade_txtd),
				'std' => __('Our Projects.', wpGrade_txtd),
				'rows' => 4,
            ),
            array(
                'id' => 'portfolio_header_image',
                'type' => 'upload',
                'title' => __('Portfolio Archive Header Image', wpGrade_txtd),
                'sub_desc' => __('Image that will be used on top of the portfolio archive page.', wpGrade_txtd),
            ),
			array(
                'id' => 'portfolio_filter_text',
                'type' => 'text',
                'title' => __('Filter By Text', wpGrade_txtd),
                'sub_desc' => __('Change here the text on the left side of the categories list.', wpGrade_txtd),
				'std' => 'Filter by...',
            ),
			array(
                'id' => 'portfolio_category_description',
                'type' => 'checkbox',
                'title' => __('Display Category Description', wpGrade_txtd),
                'sub_desc' => __('Do you want to display the portfolio category description on the category pages?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'portfolio_archive_limit',
                'type' => 'text',
                'title' => __('How many projects?', wpGrade_txtd),
                'sub_desc' => __('Set the number of projects you want to be loaded at once.', wpGrade_txtd),
				'std' => '6',
            ),
			array(
                'id' => 'portfolio_ajax_loading_pagination',
                'type' => 'checkbox_hide_below',
                'title' => __('Use AJAX Loading Pagination', wpGrade_txtd),
                'sub_desc' => __('Do you want to use a load more button instead of older/newer links on portfolio pages?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'portfolio_ajax_loading_text',
                'type' => 'text',
                'title' => __('Load More Text?', wpGrade_txtd),
                'sub_desc' => __('Change here the text of the load more link (HTML is supported).', wpGrade_txtd),
				'std' => '<span>View More</span> Work...',
            ),
            array(
                'id' => 'portfolio_technical_stuff_info_alert',
                'type' => 'info',
                'desc' => __('<h2>Technical Stuff</h2>', wpGrade_txtd)
            ),
            array(
                'id' => 'portfolio_single_label',
                'type' => 'text',
                'title' => __('Single Item Label', wpGrade_txtd),
                'sub_desc' => __('Here you can change the singular label.The default is "Project"', wpGrade_txtd),
                'std' => __('Portfolio', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_plural_label',
                'type' => 'text',
                'title' => __('Multiple Items Label (plural)', wpGrade_txtd),
                'sub_desc' => __('Here you can change the plural label.The default is "Projects"', wpGrade_txtd),
                'std' => __('Projects', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_rewrite_slug',
                'type' => 'checkbox_hide_below',
                'title' => __('Change Single Item Slug', wpGrade_txtd),
                'sub_desc' => __('Do you want to rewrite the single portfolio item slug ?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
            array(
                'id' => 'portfolio_slug',
                'type' => 'text',
                'title' => __('New Single Item Slug', wpGrade_txtd),
                'sub_desc' => __('Change the single portfolio item slug as you need it.<br /> Exemple from www.your-domain.com/<b>portfolio</b>/item1 in www.your-domain.com/<b>new-slug</b>/item1', wpGrade_txtd),
                'desc' => __('After you change this you need to go and <a href="'.admin_url( 'options-permalink.php' ).'" title="Just hit the Save changes button">save the permalinks</a> to flush them.', wpGrade_txtd),
				'std' => __('portfolio', wpGrade_txtd),
            ),
            array(
                'id' => 'portfolio_rewrite_archive_slug',
                'type' => 'checkbox_hide_below',
                'title' => __('Change Archive Slug', wpGrade_txtd),
                'sub_desc' => __('Do you want to rewrite the portfolio archive slug? This will only be used if you don\'t have a page with the Portfolio template!', wpGrade_txtd),
				'std' => '0',
                'switch' => true,
            ),
            array(
                'id' => 'portfolio_archive_slug',
                'type' => 'text',
                'title' => __('New Archive Slug', wpGrade_txtd),
                'sub_desc' => __('Exemple from www.your-domain.com/<b>portfolio</b> in www.your-domain.com/<b>new-slug</b>', wpGrade_txtd),
                'desc' => __('After you change this you need to go and <a href="'.admin_url( 'options-permalink.php' ).'" title="Just hit the Save changes button">save the permalinks</a> to flush them.', wpGrade_txtd),
            ),
			array(
                'id' => 'portfolio_category_rewrite_slug',
                'type' => 'checkbox_hide_below',
                'title' => __('Change Category Slug', wpGrade_txtd),
                'sub_desc' => __('Do you want to rewrite the portfolio category slug ?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
            array(
                'id' => 'portfolio_category_slug',
                'type' => 'text',
                'title' => __('New Category Slug', wpGrade_txtd),
                'sub_desc' => __('Change the portfolio category slug as you need it.<br /> Exemple from www.your-domain.com/<b>portfolio-category</b>/category in www.your-domain.com/<b>new-slug</b>/category', wpGrade_txtd),
                'desc' => __('After you change this you need to go and <a href="'.admin_url( 'options-permalink.php' ).'" title="Just hit the Save changes button">save the permalinks</a> to flush them.', wpGrade_txtd),
				'std' => __('portfolio-category', wpGrade_txtd),
            ),
//            array(
//                'id' => 'portfolio_use_categories',
//                'type' => 'checkbox',
//                'title' => __('Use Categories', wpGrade_txtd),
//                'sub_desc' => __('Do you want to assign categories to portfolio items ?', wpGrade_txtd),
//                'switch' => true
//            ),
            array(
                'id' => 'portfolio_use_tags',
                'type' => 'checkbox',
                'title' => __('Use Tags', wpGrade_txtd),
                'sub_desc' => __('Do you want to assign tags to portfolio items ?', wpGrade_txtd),
                'switch' => true
            ),
        )
    );

    $sections[] = array(
        'icon' => 'file-alt',
        'icon_class' => '',
        'title' => __('Blog Options', wpGrade_txtd),
        'desc' => __('<p class="description">Change blog archive and single post related options here.</p>', wpGrade_txtd),
        'fields' => array(
			array(
                'id' => 'blog_archive_title',
                'type' => 'text',
                'title' => __('Archive Title', wpGrade_txtd),
                'sub_desc' => __('This is the title of the blog archive page (it will appear over the header image bellow).', wpGrade_txtd),
				'std' => __('Blog & News.', wpGrade_txtd),
            ),
			array(
                'id' => 'blog_header_image',
                'type' => 'upload',
                'title' => __('Blog Archives Header Image', wpGrade_txtd),
                'sub_desc' => __('Image that will be used on top of the blog archive page (sometimes as background for the category/tag title and description).', wpGrade_txtd),
            ),
            array(
                'id' => 'blog_archive_template',
                'type' => 'radio_img',
                'title' => __('Archive Layout', wpGrade_txtd),
                'sub_desc' => __('Choose the layout for the blog\'s archive.', wpGrade_txtd),
//                'desc' => __('This uses some of the built in images, you can use them for layout options.', wpGrade_txtd),
                'options' => array(
                    'l-sidebar-left' => array('title' => 'Sidebar Left', 'img' => Redux_OPTIONS_URL . 'img/2cl.png'),
                    'l-sidebar-right' => array('title' => 'Sidebar Right', 'img' => Redux_OPTIONS_URL . 'img/2cr.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => 'l-sidebar-right'
            ),
			array(
                'id' => 'blog_show_featured_image',
                'type' => 'checkbox',
                'title' => __('Show Posts Featured Images in Archives', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the featured images of posts in the archive pages?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_excerpt_length',
                'type' => 'text',
                'title' => __('Excerpt Length', wpGrade_txtd),
                'sub_desc' => __('Set here the excerpt length for the blog archive (number of words).', wpGrade_txtd),
				'std' => '100',
            ),
            array(
                'id' => 'blog_single_template',
                'type' => 'radio_img',
                'title' => __('Single Post Layout', wpGrade_txtd),
                'sub_desc' => __('Choose the layout for the blog\'s single post pages.', wpGrade_txtd),
                'options' => array(
                    'l-sidebar-left' => array('title' => 'Sidebar Left', 'img' => Redux_OPTIONS_URL . 'img/2cl.png'),
                    'l-sidebar-right' => array('title' => 'Sidebar Right', 'img' => Redux_OPTIONS_URL . 'img/2cr.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => 'l-sidebar-right'
            ),
			array(
                'id' => 'blog_single_show_share_links',
                'type' => 'checkbox_hide_below',
                'title' => __('Show Share Links', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the share links bellow the article?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
				"next_to_hide" => 3,
            ),
			array(
                'id' => 'blog_single_share_links_twitter',
                'type' => 'checkbox',
                'title' => __('Twitter Share Link', wpGrade_txtd),
                'sub_desc' => '',
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_share_links_facebook',
                'type' => 'checkbox',
                'title' => __('Facebook Share Link', wpGrade_txtd),
                'sub_desc' => '',
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_share_links_googleplus',
                'type' => 'checkbox',
                'title' => __('Google+ Share Link', wpGrade_txtd),
                'sub_desc' => '',
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_show_author',
                'type' => 'checkbox',
                'title' => __('Show Author Box', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the author info box on the left side of the article?', wpGrade_txtd),
				'std' => '1',
                'switch' => true,
            ),
			array(
                'id' => 'blog_single_show_comments_title',
                'type' => 'checkbox',
                'title' => __('Show Comments Title', wpGrade_txtd),
                'sub_desc' => __('Do you want to show the number of comments above the comments?', wpGrade_txtd),
				'std' => '0',
                'switch' => true,
            ),
        )
    );

    $sections[] = array(
        'icon' => "facebook-sign",
        'icon_class' => '',
        'title' => __('Social and SEO Options', wpGrade_txtd),

        'desc' => __('<p class="description">Social sharing stuff.</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'prepare_for_social_share',
                'type' => 'checkbox_hide_below',
                'title' => __('Add Social Meta Tags', wpGrade_txtd),
                'sub_desc' => __('Let us properly prepare your theme for the social sharing and discovery by adding the needed metatags in the <head> section.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                "next_to_hide" => 4,
            ),
            array(
                'id' => 'facebook_id_app',
                'type' => 'text',
                'title' => __('Facebook Application ID', wpGrade_txtd),
                'sub_desc' => __('Enter the Facebook Application ID of the Fan Page which is associated with this website. You can create one <a href="https://developers.facebook.com/apps">here</a>.', wpGrade_txtd),
            ),
            array(
                'id' => 'facebook_admin_id',
                'type' => 'text',
                'title' => __('Facebook Admin ID', wpGrade_txtd),
                'sub_desc' => __('The id of the user that has administrative privileges to your Facebook App so you can access the <a href="https://www.facebook.com/insights/">Facebook Insights</a>.', wpGrade_txtd),
            ),
            array(
                'id' => 'google_page_url',
                'type' => 'text',
                'title' => __('Google+ Publisher', wpGrade_txtd),
                'sub_desc' => __('Enter your Google Plus page URL (example: https://plus.google.com/105345678532237339285) here if you have set up a "Google+ Page".', wpGrade_txtd),
            ),
			array(
                'id' => 'twitter_card_site',
                'type' => 'text',
                'title' => __('Twitter Site Username', wpGrade_txtd),
                'sub_desc' => __('The Twitter username of the entire site. The username for the author will be taken from the author\'s profile (skip the @)', wpGrade_txtd),
            ),
			array(
                'id' => 'social_share_default_image',
                'type' => 'upload',
                'title' => __('Default Social Share Image', wpGrade_txtd),
                'sub_desc' => __('If an image is uploaded, this will be used for content sharing if you don\'t upload a custom image with your content (at least 200px wide recommended).', wpGrade_txtd),
            ),
			 array(
                'id' => 'use_twitter_widget',
                'type' => 'checkbox_hide_below',
                'title' => __('Use Twitter Widget', wpGrade_txtd),
                'sub_desc' => __('Just a widget to show your latest tweets (Twitter API v1.1 compatible). You can add it in your blog or footer sidebars.<div class="description">', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                "next_to_hide" => 5,
            ),
            array(
                'id' => 'info_about_twitter_app',
                'type' => 'info_box',
                'title' => __('Important Note : ', wpGrade_txtd),
                'desc' => __('In order to use the Twitter widget you will need to create a Twitter application <a href="https://dev.twitter.com/apps/new" >here</a> and get your own key, secrets and access tokens. This is due to the changes that Twitter made to it\'s API (v1.1). Please note that these defaults are used on the '. WPGRADE_THEMENAME .' demo site but they might be disabled at any time, so we <strong>strongly</strong> recommend you to input your own bellow.</div>', wpGrade_txtd),
            ),
            array(
                'id' => 'twitter_consumer_key',
                'type' => 'text',
                'title' => __('Consumer Key', wpGrade_txtd),
                'std' => 'UGciUkPwjDpCRyEqcGsbg'
            ),
            array(
                'id' => 'twitter_consumer_secret',
                'type' => 'text',
                'title' => __('Consumer Secret', wpGrade_txtd),
                'std' => 'nuHkqRLxKTEIsTHuOjr1XX5YZYetER6HF7pKxkV11E'
            ),
            array(
                'id' => 'twitter_oauth_access_token',
                'type' => 'text',
                'title' => __('Oauth Access Token', wpGrade_txtd),
                'std' => '205813011-oLyghRwqRNHbZShOimlGKfA6BI4hk3KRBWqlDYIX'
            ),
            array(
                'id' => 'twitter_oauth_access_token_secret',
                'type' => 'text',
                'title' => __('Oauth Access Token Secret', wpGrade_txtd),
                'std' => '4LqlZjf7jDqmxqXQjc6MyIutHCXPStIa3TvEHX9NEYw'
            ),
			array(
                'id' => 'social_seo_social_widget_title',
                'type' => 'info',
                'desc' => __('<h2>Social Icons Widget Settings</h2>', wpGrade_txtd)
            ),
            array(
                'id' => 'social_icons',
                'type' => 'text_sortable',
                'title' => __('Social Icons', wpGrade_txtd),
                'sub_desc' => __('Define and reorder your social links.<br /><b>Note: </b>These will be displayed in the "'. WPGRADE_THEMENAME .' Social Links" widget so you can put them anywhere on your site. Only those filled will appear.', wpGrade_txtd),
                'desc' => __('Icons provided by <strong>FontAwesome</strong> and <strong>Entypo</strong>.', wpGrade_txtd),
                'options' => array(
                    'twitter' => __('Twitter', wpGrade_txtd),
                    'facebook' => __('Facebook', wpGrade_txtd),
                    'gplus' => __('Google+', wpGrade_txtd),
                    'skype' => __('Skype', wpGrade_txtd),
                    'linkedin' => __('LinkedIn', wpGrade_txtd),
                    'youtube' => __('Youtube', wpGrade_txtd),
                    'vimeo' => __('Vimeo', wpGrade_txtd),
                    'instagram' => __('Instagram', wpGrade_txtd),
                    'flickr' => __('Flickr', wpGrade_txtd),
                    'pinterest' => __('Pinterest', wpGrade_txtd),
                    'tumblr' => __('Tumblr', wpGrade_txtd),
					'lastfm' => __('Last.FM', wpGrade_txtd),
					'appnet' => __('App.net', wpGrade_txtd)
                )
            ),
            array(
                'id' => 'social_icons_target_blank',
                'type' => 'checkbox',
                'title' => __('Open social icons links in new a window?', wpGrade_txtd),
                'sub_desc' => __('Do you want to open social links in a new window ?', wpGrade_txtd),
                'std' => '1',
                'switch' => true
            ),
        )
    );
	
	 $sections[] = array(
        'icon' => "cloud-download",
        'icon_class' => '',
        'title' => __('Theme Auto Update', wpGrade_txtd),

        'desc' => __('<p class="description">Let us notify you when new versions of this theme are live on ThemeForest! Update with just one button click. Forget about manual updates!</p>', wpGrade_txtd),
        'fields' => array(
            array(
                'id' => 'themeforest_upgrade',
                'type' => 'checkbox_hide_below',
                'title' => __('Use Auto Update', wpGrade_txtd),
                'sub_desc' => __('Activate this to enter the info needed for the theme auto update to work.', wpGrade_txtd),
                'std' => '1',
                'switch' => true,
                "next_to_hide" => 4,
            ),
			array(
                'id' => 'info_marketplace_api',
                'type' => 'info_box',
                'title' => __('Important Note : ', wpGrade_txtd),
                'desc' => __('To obtain your API Key, visit your <strong>"My Settings"</strong> page on any of the Envato Marketplaces. Once a valid connection has been made any changes to the API key below for this username will not effect the results for 5 minutes because they\'re cached in the database.', wpGrade_txtd),
            ),
            array(
                'id' => 'marketplace_username',
                'type' => 'text',
                'title' => __('ThemeForest Username', wpGrade_txtd),
                'sub_desc' => __('Enter here your ThemeForest (or Envato) username account (i.e. pixelgrade).', wpGrade_txtd),
            ),
            array(
                'id' => 'marketplace_api_key',
                'type' => 'text',
                'title' => __('ThemeForest Secret API Key', wpGrade_txtd),
                'sub_desc' => __('Enter here the secret api key you\'ve created on ThemeForest. You can create a new one in the Settings > API Keys section of your profile.', wpGrade_txtd),
            ),
			array(
                'id' => 'themeforest_upgrade_backup',
                'type' => 'checkbox',
                'title' => __('Backup Theme Before Upgrade?', wpGrade_txtd),
                'sub_desc' => __('Check this if you want us to automatically save your theme as a ZIP archive before an upgrade. The directory those backups get saved to is <code>wp-content/envato-backups</code>. However, if you\'re experiencing problems while attempting to upgrade, it\'s likely to be a permissions issue and you may want to manually backup your theme before upgrading. Alternatively, if you don\'t want to backup your theme you can uncheck this.', wpGrade_txtd),
				'std' => '0',
                'switch' => true
            ),
        )
    );

    $tabs = array();

    if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $item_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $author_uri = $theme_data->get('AuthorURI');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    }

    $item_info = '<div class="redux-opts-section-desc">';
    $item_info .= '<p class="redux-opts-item-data description item-uri">' . __('<strong>Theme URL:</strong> ', wpGrade_txtd) . '<a href="' . $item_uri . '" target="_blank">' . $item_uri . '</a></p>';
    $item_info .= '<p class="redux-opts-item-data description item-author">' . __('<strong>Author:</strong> ', wpGrade_txtd) . ($author_uri ? '<a href="' . $author_uri . '" target="_blank">' . $author . '</a>' : $author) . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-version">' . __('<strong>Version:</strong> ', wpGrade_txtd) . $version . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-description">' . $description . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-tags">' . __('<strong>Tags:</strong> ', wpGrade_txtd) . implode(', ', $tags) . '</p>';
    $item_info .= '</div>';

    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => '',
        'title' => __('Theme Information', wpGrade_txtd),
        'content' => $item_info
    );

    global $wpGrade_Options;
    $wpGrade_Options = new Redux_Options($sections, $args, $tabs);

}
add_action('after_setup_theme', 'setup_framework_options',0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

//Code regarding the one click import for demo data-----------------------------

/**
* Generate the import button code
*/
function import()
{	
	$output = "";
	$nonce	 = 	wp_create_nonce ('wpGrade_nonce_import_demo_posts_pages');
	$output .= '<input type="hidden" name="wpGrade-nonce-import-posts-pages" value="'.$nonce.'" />';
	$nonce	 = 	wp_create_nonce ('wpGrade_nonce_import_demo_theme_options');
	$output .= '<input type="hidden" name="wpGrade-nonce-import-theme-options" value="'.$nonce.'" />';
	$nonce	 = 	wp_create_nonce ('wpGrade_nonce_import_demo_widgets');
	$output .= '<input type="hidden" name="wpGrade-nonce-import-widgets" value="'.$nonce.'" />';
	$output .= '<input type="hidden" name="wpGrade_import_ajax_url" value="'.admin_url("admin-ajax.php").'" />';
	$output .= '<a href="#" class="button button-primary" id="wpGrade_import_demodata_button">Import demo data</a>';
	$output .= '<div class="wpGrade-loading-wrap hidden"><span class="wpGrade-loading wpGrade-import-loading"></span>';
	$output .= '<div class="wpGrade-import-wait">Please wait a few minutes (between 2 and 5 minutes usually, but depending on your hosting it can take longer) and <strong>don\'t reload the page</strong>. You will be notified as soon as the import has finished!</div></div>';
	$output .= '<div class="wpGrade-import-results hidden"></div>';
	return $output;
}

/**
 * This function imports the demo data from the demo_data.xml file
 */
if(!function_exists('wpGrade_ajax_import_posts_pages'))
{
	function wpGrade_ajax_import_posts_pages()
	{
		//initialize the step importing
		$stepNumber = 1;
		$numberOfSteps = 1;
		//get the data sent by the ajax call regarding the current step and total number of steps
		if (!empty($_REQUEST['step_number'])) {
			$stepNumber = $_REQUEST['step_number'];
		}
		
		if (!empty($_REQUEST['number_of_steps'])) {
			$numberOfSteps = $_REQUEST['number_of_steps'];
		}
		
		$response = array(
			'what' => 'import_posts_pages',
			'action' => 'import_submit',
			'id' => 'true',
			'supplemental' => array (
					'stepNumber' => $stepNumber,
					'numberOfSteps' => $numberOfSteps,
				)
		);
		
		//check if user is allowed to save and if its his intention with a nonce check
		//if(function_exists('check_ajax_referer')) { check_ajax_referer('wpGrade_nonce_import_demo_posts_pages'); }
		
		require_once WPGRADE_LIB_PATH . 'inc/import/import-demo-posts-pages.php';

		$response = new WP_Ajax_Response( $response );
		$response->send();
	}
	
	//hook into wordpress admin.php
	add_action('wp_ajax_wpGrade_ajax_import_posts_pages', 'wpGrade_ajax_import_posts_pages');
}

/**
 * This function imports the theme options from the demo_data.php file
 */
if(!function_exists('wpGrade_ajax_import_theme_options'))
{
	function wpGrade_ajax_import_theme_options()
	{
		$response = array(
			'what' => 'import_theme_options',
			'action' => 'import_submit',
			'id' => 'true',
		);
		
		//check if user is allowed to save and if its his intention with a nonce check
		if(function_exists('check_ajax_referer')) { check_ajax_referer('wpGrade_nonce_import_demo_theme_options'); }
		
		require_once WPGRADE_LIB_PATH . 'inc/import/import-demo-theme-options.php';

		$response = new WP_Ajax_Response( $response );
		$response->send();
	}
	
	//hook into wordpress admin.php
	add_action('wp_ajax_wpGrade_ajax_import_theme_options', 'wpGrade_ajax_import_theme_options');
}

/**
 * This function imports the widgets from the demo_data.php file and the menus
 */
if(!function_exists('wpGrade_ajax_import_widgets'))
{
	function wpGrade_ajax_import_widgets()
	{	
		$response = array(
			'what' => 'import_widgets',
			'action' => 'import_submit',
			'id' => 'true',
		);
		//check if user is allowed to save and if its his intention with a nonce check
		if(function_exists('check_ajax_referer')) { check_ajax_referer('wpGrade_nonce_import_demo_widgets'); }
		
		require_once WPGRADE_LIB_PATH . 'inc/import/import-demo-widgets.php';

		$response = new WP_Ajax_Response( $response );
		$response->send();
	}
	
	//hook into wordpress admin.php
	add_action('wp_ajax_wpGrade_ajax_import_widgets', 'wpGrade_ajax_import_widgets');
}

//End code regarding the one click import for demo data-------------------------
