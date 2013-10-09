<?php

/*
 * Set the text domain for the theme or plugin.
 */
define('wpGrade_txtd', 'fuse_txtd');

/*
 * Declare some global data that will be used everywhere
 */
$wpGrade_data = new stdClass();

/*
 * Define constants regarding theme info
 */
define("WPGRADE_THEMENAME", 'Fuse');
define("WPGRADE_SHORTNAME", 'fuse');
define("WPGRADE_PREFIX", '_fuse_');

if ( is_child_theme() )  { // if this is a child theme take the theme data from his template
    $theme_name  = get_template(); // get the template name
    $theme_data = wp_get_theme( $theme_name ); // now theme_data has the parent theme data data
} else {
    $theme_data = wp_get_theme();
}

define("WPGRADE_VERSION", $theme_data->Version);

//library main paths and urls
define("WPGRADE_LIB_PATH", get_template_directory() . '/library/');
define("WPGRADE_LIB_URL", get_template_directory_uri().'/library/');
define("WPGRADE_CSS_URL", WPGRADE_LIB_URL.'css/');
define("WPGRADE_SCRIPT_URL", WPGRADE_LIB_URL.'js/');

/*
 * Some utility functions class.
 */
require_once('inc/util.php');

/*
 * Require the theme backend.
 */
require_once('admin-panel/options.php');

if(is_admin() && basename($_SERVER["PHP_SELF"]) != 'update-core.php'){

	require_once('inc/upgrade-notifier.php');
}

/*
 * Here we define our custom post types and taxonomies.
 * Remove this line if you find this boring.
 */
require_once('inc/custom-entities.php');

/*
 * Require the needed plugins & custom theme supports
 */
require_once('inc/required-plugins/required-plugins.php');
require_once('inc/widgets.php');
require_once('inc/custom-admin-login.php');
require_once('inc/menus.php');
require_once('inc/media.php');
require_once('inc/thumbnails.php');
require_once('inc/portfolio-gallery.php');
require_once('inc/template-tags.php');
require_once('inc/theme-defaults.php');
include_once 'inc/metaboxes/metaboxes.php';
include_once 'inc/social.php';
include_once 'inc/admin-help-pointers.php';
include_once 'inc/wpml.php';

//theme activation hooks
add_action( 'after_switch_theme', 'wpgrade_gets_active' );
function wpgrade_gets_active() {
    // Flush permalinks rules on theme activation
    flush_rewrite_rules();
}

// initial thingys
add_action('after_setup_theme','wp_grade_start', 16);
function wp_grade_start() {
    global $wpGrade_Options;
	//load the translations
	load_theme_textdomain( wpGrade_txtd, get_template_directory() .'/library/languages' );
    // clean the head
    add_action('init', 'wpgrade_head_cleanup');
    // no Wordpress version in the RSS feed
    add_filter('the_generator', 'wpgrade_rss_version');
    // remove inline css for the recent comments widget
    add_filter( 'wp_head', 'wpgrade_remove_recent_comments_widget_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'wpgrade_remove_recent_comments_style', 1);
    add_action('wp_head', 'wpgrade_add_desktop_icons');
    // clean up gallery output - remove the inline css
    add_filter('gallery_style', 'wpgrade_gallery_style');
    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'wpgrade_scripts_and_styles', 1);
    // custom javascript
    add_action('wp_head', 'wpgrade_load_custom_js');

    if ( $wpGrade_Options->get('display_custom_css_inline') ) {
        add_action('wp_head', 'wpgrade_load_inline_custom_css');
    }

	// Register theme Features
	add_action( 'after_setup_theme', 'custom_theme_features' );
    // cleaning up <p>s around images
    add_filter('the_content', 'wpgrade_filter_ptags_on_images');
    // cleaning up excerpt - replace [..] with a Read more link
    add_filter('excerpt_more', 'wpgrade_excerpt_more');
	// Add theme support for Post Formats
	$formats = array( 'quote', 'video', 'audio', 'gallery');
	add_theme_support( 'post-formats', $formats );	
}

/*
 * Load theme scripts and styles
 */
function wpgrade_scripts_and_styles () {
	global $wpGrade_Options;
	
	$myscripts_dep = array();
    wp_register_script('infinite-scroll', get_template_directory_uri() . '/library/js/plugins/jquery.infinitescroll.min.js', array(), "", true);
	$myscripts_dep[] = 'infinite-scroll';
	
	if ($wpGrade_Options->get('deactivate_stock_popup')) {
		//do nothing
	} else {
		wp_register_script('magnific-popup', get_template_directory_uri() . '/library/js/plugins/jquery.magnific-popup.min.js', array(), "", true);
		$myscripts_dep[] = 'magnific-popup';
	}
	
	wp_register_script('froogaloop', get_template_directory_uri() . '/library/js/plugins/froogaloop.min.js', array(), "", true);
	$myscripts_dep[] = 'froogaloop';
	wp_register_script('youtube-api', '//www.youtube.com/iframe_api', array(), "", false);
	$myscripts_dep[] = 'youtube-api';
	wp_register_script('fitvids', get_template_directory_uri() . '/library/js/plugins/jquery.fitvids.js', array('jquery'), "", false);
	$myscripts_dep[] = 'fitvids';

    wp_register_script('mediaelement', get_template_directory_uri() . '/library/js/plugins/mediaelement-and-player.min.js', array('jquery'), "", true);
	$myscripts_dep[] = 'mediaelement';
    
	$cacheBusterJS = date("YmdHi", filemtime( WPGRADE_LIB_PATH. 'js/plugins/flexslider.js'));
    wp_register_script('flexslider', get_template_directory_uri() . '/library/js/plugins/flexslider.js', array('jquery'), $cacheBusterJS, true);
	$myscripts_dep[] = 'flexslider';
	
    wp_register_script('isotope', get_template_directory_uri() . '/library/js/plugins/jquery.isotope.min.js', array('jquery'), "", true);
	$myscripts_dep[] = 'isotope';
    wp_register_script('nice-scroll', get_template_directory_uri() . '/library/js/plugins/jquery.nicescroll.min.js', array('jquery'), "", true);
	$myscripts_dep[] = 'nice-scroll';
    wp_register_script('scroll-monitor', get_template_directory_uri() . '/library/js/scroll-monitor.js', array('jquery'), "", true);
	$myscripts_dep[] = 'scroll-monitor';
    wp_register_script('bootstrap-tab', get_template_directory_uri() . '/library/js/plugins/bootstrap-tab.js', array('jquery'), "", true);
	$myscripts_dep[] = 'bootstrap-tab';
	
	// Google Map for Contact Page
    wp_register_script('gmap-api', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://maps.google.com/maps/api/js?v=3.exp&sensor=false", array(), "", true);
    wp_register_script('gmap-infobox', get_template_directory_uri() . '/library/js/plugins/gmap/infobox.js', array(), "", true);
    wp_register_script('contact-scripts', get_template_directory_uri() . '/library/js/contact.js', array('jquery', 'gmap-api','gmap-infobox'), "", true);
    wp_register_script('modernizr', get_template_directory_uri() . '/library/js/modernizr.js', array('jquery'), "", true);

    if(is_page_template('template-contact.php')) {
        wp_enqueue_script('contact-scripts');
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script( 'comment-reply' );
    }
	$cacheBusterJS = date("YmdHi", filemtime( WPGRADE_LIB_PATH. 'js/scripts.js' ) );
    wp_enqueue_script('my-scripts', get_template_directory_uri() . '/library/js/scripts.js', $myscripts_dep, $cacheBusterJS, true);

	wp_localize_script('my-scripts', 'ajaxurl', admin_url( 'admin-ajax.php' ));

    $cacheBusterCSS = date("YmdHi", filemtime( WPGRADE_LIB_PATH. 'css/style.css'));
    wp_enqueue_style('main-style', get_template_directory_uri() . '/library/css/style.css', array(), $cacheBusterCSS);
    wp_enqueue_style('google-web-fonts', 'http://fonts.googleapis.com/css?family=Raleway:400,500,600,700|Open+Sans:400italic,600italic');

	
     global $wpGrade_Options;

     $style_query_string = '?';
     if ( $wpGrade_Options->get('main_color') ) {
         $main_color = $wpGrade_Options->get('main_color');
         $main_color = str_replace('#', '', $main_color);
         $style_query_string .= 'color='.$main_color;
     }

     if ( $wpGrade_Options->get('use_google_fonts') ) {
         add_action('wp_head', 'wpgrade_load_google_fonts');
         $fonts_array = array('google_main_font', 'google_second_font', 'google_menu_font', 'google_body_font');

         foreach ( $fonts_array as $font) {
             $this_font = get_clean_google_font( $font );
             if (!empty($this_font)) {
                 $key = str_replace('google_', '', $font);
                 if ( $style_query_string != '?' ) {
                     $style_query_string .= '&'. $key .'='.$this_font;
                 } else {
                     $style_query_string .= $key .'='.$this_font;
                 }
             }
         }
     }
	 if ( $wpGrade_Options->get('portfolio_text_color') ) {
         $port_color = $wpGrade_Options->get('portfolio_text_color');
         $port_color = str_replace('#', '', $port_color);
	 	if ( $style_query_string != '?' ) {
	 		$style_query_string .= '&port_color='.$port_color;
	 	} else {
             $style_query_string .= 'port_color='.$port_color;
         }
     }

     $custom_css = $wpGrade_Options->get('custom_css');
     if ( $custom_css ) {
         if ( $style_query_string != '?' ) {
             $style_query_string .= '&custom_css='.urlencode( $custom_css );
         } else {
             $style_query_string .= 'custom_css='.urlencode( $custom_css );
         }
     }

     if ( !$wpGrade_Options->get('display_custom_css_inline') ) {
          wp_register_style('php-style', get_template_directory_uri() . '/library/css/custom.css.php'.$style_query_string );
          wp_enqueue_style('php-style');
     }
}

// return the css value for the font
function get_clean_google_font($font){
    global $wpGrade_Options;
    $this_font = $wpGrade_Options->get($font);
    $this_font = str_replace("+", " ", $this_font);
    $this_font = explode(":", $this_font);
    return $this_font[0];
}

/*
 * Load style options
 */
function wpgrade_load_google_fonts(){
    global $wpGrade_Options;

    // fonts
    if ( $wpGrade_Options->get('use_google_fonts') ) {

        $fonts_array = array('google_main_font', 'google_second_font', 'google_menu_font', 'google_body_font');
        $families = array();
        foreach ( $fonts_array as $key => $font) {

            $this_font = get_clean_google_font( $font );
            if (!empty($this_font)) {
                $families[] = $this_font;
            }
        }
        if ( !empty($families)) {
            ?>
            <script type="text/javascript">
                WebFontConfig = {
                    google: { families: <?php echo json_encode($families); ?> }
                };
                (function() {
                    var wf = document.createElement('script');
                    wf.src = (document.location.protocol == 'https:' ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                    wf.type = 'text/javascript';
                    wf.async = 'true';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(wf, s);
                })();
            </script>
            <?php
        }
    }
}
/*
 * Load custom js set in theme options
 */
function wpgrade_load_custom_js(){
    global $wpGrade_Options;

    $custom_js = $wpGrade_Options->get('custom_js');
    if ( !empty( $custom_js ) ) {  ?>
        <script type="text/javascript">
            <?php echo  $custom_js; ?>
        </script>
    <?php
    }
}

function wpgrade_load_inline_custom_css (){
    global $wpGrade_Options;
    $main_color = $wpGrade_Options->get('main_color');
    $fonts = array();

    if ( $wpGrade_Options->get('use_google_fonts') ) {
        $fonts_array = array('google_main_font', 'google_second_font', 'google_menu_font', 'google_body_font');

        foreach ( $fonts_array as $font) {
            $this_font = get_clean_google_font( $font );
            if (!empty($this_font)) {
                $key = str_replace('google_', '', $font);
                $fonts[$key] = $this_font;
            }
        }
    }

    $port_color = '';
    if ( $wpGrade_Options->get('portfolio_text_color') ) {
        $port_color = $wpGrade_Options->get('portfolio_text_color');
        $port_color = str_replace('#', '', $port_color);
    } ?>
    <style>
        <?php if ( !empty( $main_color ) ){ ?>
		    body .post.sticky .entry-title a, .post.sticky .entry-title body a, body .site-mainmenu li:hover > a, .site-mainmenu body li:hover > a, body .site-mainmenu > li.current-menu-parent > a, body .site-mainmenu > li.current_page_item > a, body .site-mainmenu > li.current-menu-item > a,
		    body .site-mainmenu > li .current-menu-item > a, .wpgrade_pagination a:hover, .wpcf7-arrow:hover .wpcf7-submit,
		    .site-mainmenu > li body .current-menu-item > a, body .site-mainmenu > li.current_page_parent > a, body .icon-twitter_footer, body .widget_categories > ul > li a:hover, .widget_categories > ul > li body a:hover, body .nav-btn i, .nav-btn body i, body .portfolio-item_cat-link:hover, body .previous-project-link a:hover, .previous-project-link body a:hover, body .next-project-link a:hover, .next-project-link body a:hover, body .load_more a:hover, .load_more body a:hover, body .previous-project-link span, .previous-project-link body span, body .next-project-link span, .next-project-link body span, body .load_more span, .load_more body span, body .post-footer_meta a:hover, .post-footer_meta body a:hover, body .comment.bypostauthor .comment-author, .comment.bypostauthor body .comment-author, body .pingback.bypostauthor .comment-author, .pingback.bypostauthor body .comment-author, body .trackback.bypostauthor .comment-author, .trackback.bypostauthor body .comment-author, body .block-dark a, .block-dark body a, body .tab-titles-list li.active a, .tab-titles-list li.active body a, body .tab-titles-list a:hover, .tab-titles-list body a:hover, body i.shc.big:hover, body a,
		    p.radio .wpcf7-radio input[type="radio"]:checked ~ span, a:hover > i.shc, body .tab-titles-list-item.active a,
		    p.radio .wpcf7-radio .wpcf7-list-item-label:hover, body .tab-titles-list-item a:hover {
		      color: <?php echo $main_color; ?>; }
		    body .header_search-form #searchform, .header_search-form body #searchform, body .header_search-form #searchform .field, .header_search-form #searchform body .field, body .side-footer_twitter, body .side-featuredworks, body .homepage-slider_slide-content .btn, .homepage-slider_slide-content body .btn, body .nav-filler, body .homepage-slider .flex-control-paging > li > a.flex-active, .homepage-slider body .flex-control-paging > li > a.flex-active,
		    .blog .gallery_format_slider .flex-direction-nav a:hover, body .block-color, body .progressbar-progress, body .progressbar-tooltip:after, body .btn:hover, body #comment-submit:hover, body .btn-primary.btn, body .btn-primary#comment-submit, body .mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-time-rail body .mejs-time-current,
		    body .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
		    .mejs-container .mejs-controls .mejs-horizontal-volume-slider body .mejs-horizontal-volume-current {
		      background-color: <?php echo $main_color; ?>; }
		    body .site-mainmenu > li.menu-parent-item:hover > a:after, body .contact-info .pin_ring, body .site-mainmenu > li ul.sub-menu li.menu-parent-item:hover a:after, .site-mainmenu > li ul.sub-menu li.menu-parent-item:hover body a:after {
		      border-color: <?php echo $main_color; ?>; }
		    body .side-footer_twitter .block-inner:before, .side-footer_twitter body .block-inner:before, body .side-featuredworks .block-inner:before, .side-featuredworks body .block-inner:before, body .homepage-slider_slide-content .btn:after, .homepage-slider_slide-content body .btn:after, body .block-color .arrow-bottom:before, .block-color body .arrow-bottom:before, body .previous-project-link a:before, .previous-project-link body a:before, body .next-project-link a:after, .next-project-link body a:after, body .team-member-header, body .block-light .shc-arrow:before, .block-light body .shc-arrow:before, body .block-light .shc-arrow:after, .block-light body .shc-arrow:after,
		    .wpcf7-arrow:hover:before, .wpcf7-arrow:hover:after {
		      border-top-color: <?php echo $main_color; ?>; }
		    body .next-project-link a:after, .next-project-link body a:after, body .block-light .shc-arrow:after, .block-light body .shc-arrow:after, body .tab-titles-list li.active:before, .tab-titles-list body li.active:before,
		    .wpcf7-arrow:hover:after, body .tab-titles-list-item.active:before {
		      border-right-color: <?php echo $main_color; ?>; }
		    body a:hover {
		      border-bottom-color: <?php echo $main_color; ?>; }
		    body .previous-project-link a:before, .previous-project-link body a:before, body .type-post .entry-content ul, .type-post .entry-content body ul, body .type-post .entry-content ol, .type-post .entry-content body ol, body .type-post .entry-content blockquote, .type-post .entry-content body blockquote, body .type-post .entry-content q, .type-post .entry-content body q {
		      border-left-color: <?php echo $main_color; ?>; }
		    body .contact-info .pin_ring {
		      box-shadow: 0 0 5px <?php echo $main_color; ?>; }

		    @media only screen and (min-width: 1340px) {
		      .team-member-container.border-none .team-member-header, .team-member-container.border-bottom .team-member-header,
		      .team-member-container.border-bottom {
		        border-bottom-color: <?php echo $main_color; ?>;
		      }
		    }

		    @media only screen and (min-width: 1024px) {
		      .team-member-container:hover {
		        border-bottom-color: <?php echo $main_color; ?>;
		        background-color: <?php echo $main_color; ?>;
		      }
		    }
            <?php
        }

        if ( isset( $fonts['main_font'] ) ){  ?>

            h1, h2, h3, h4, h5, h6, .portfolio_items article li a .title, input.dial, blockquote, blockquote p, .site-branding a {
                font-family: "<?php echo $fonts['main_font']; ?>" !important;
            }

        <?php }

        if ( isset($fonts["menu_font"]) ){
            $menu_font = $fonts["menu_font"]; ?>
            .site-navigation a {
                font-family: "<?php echo $menu_font; ?>" !important;
            }
        <?php }

        if ( isset($fonts["body_font"]) ){
            $body_font = $fonts["body_font"]; ?>
            body {
                font-family: "<?php echo $body_font; ?>" !important;
            }
        <?php }

        if ( !empty( $port_color ) ){
            $port_color = '#'. $port_color; ?>
        .portfolio_items article li.big a div.title, .portfolio_single_gallery li a { color: <?php echo $port_color ?> }
        .portfolio_items article li.big a div.title hr {border-color: <?php echo $port_color ?>}
        .portfolio_items article li a .border span, .portfolio_single_gallery li a .border span {border: 1px solid <?php echo $port_color ?>}
        <?php }

        if ( $wpGrade_Options->get('custom_css') ){
			echo html_entity_decode($wpGrade_Options->get('custom_css'),null,'UTF-8');
        } ?>
    </style>
<?php }

/*
 * COMMENT LAYOUT
 */
function wpgrade_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
            <aside class="comment-author-avatar">
                <!-- custom gravatar call -->
                <?php $bgauthemail = get_comment_author_email(); ?>
                <img src="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=70" class="load-gravatar avatar avatar-48 photo" height="32" width="32" style="background-image: <?php echo get_template_directory_uri(). '/library/images/nothing.gif'; ?>; background-size: 100% 100%" />
            </aside>
            <header class="comment-author vcard">
				<?php printf(__('<cite class="fn">%s</cite>', wpGrade_txtd), get_comment_author_link()) ?>
				<time datetime="<?php comment_time('c'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('j M Y', wpGrade_txtd)); ?> </a></time>
				<?php edit_comment_link(__('Edit', wpGrade_txtd),'  ','') ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="alert info">
				<p><?php _e('Your comment is awaiting moderation.', wpGrade_txtd) ?></p>
			</div>
		<?php endif; ?>
		<section class="comment_content clearfix">
			<?php comment_text() ?>
		</section>
	</article>
	<!-- </li> is added by WordPress automatically -->
	<?php
} // don't remove this bracket!

/*
 *  Set content width value based on the theme's design
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

// Register Theme Features
function custom_theme_features() {
	add_theme_support( 'automatic-feed-links' );
	add_editor_style( get_template_directory_uri() . '/library/css/style.css');
}

function wpgrade_pagination($custom_query = false){
	if ( !$custom_query ) {
        global $wp_query;
        $custom_query = $wp_query;
    }

	$big = 999999999; ///sneed an unlikely integer
	echo '<div class="wpgrade_pagination">';

	$links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $custom_query->max_num_pages,
        'prev_next' => true,
		'prev_text'    => __('Previous Page', wpGrade_txtd ),
		'next_text'    => __('Next Page', wpGrade_txtd ),
		'end_size'	=> 1,
		'mid_size'	=> 1,
        'type' => 'array'
		) );

	if (empty($links)) {
		$links = array();
	}

    // bellow we wrap the page links from the "directions" ones ( 1,2,3 like )
    // we also add the missing prev and next links with the class disabled

    $last_el = count( $links ) - 1;
	if ($last_el < 0) {
		$last_el = 0;
	}
    // seems like we need to create our own array of links
    $wpgrade_links = array();
    if ( !empty($links[0]) && preg_match( '/class="prev/', $links[0]) ) {
        $wpgrade_links[0] = $links[0]. '<div class="pages">';
    } else {
        // there's no prev class so we push one
        $wpgrade_links[0] = '<a class="prev disabled page-numbers" >'. __('Previous Page', wpGrade_txtd ) .'</a><div class="pages">';
    }

    if ( $last_el > 0 && !empty($links[$last_el]) && preg_match( '/class="next/', $links[$last_el]) ) {
        $wpgrade_links[5] = '</div>' . $links[$last_el];
        $last_el--;
    } else {
        array_push($links, '</div><a class="next disabled page-numbers">'. __('Next Page', wpGrade_txtd ) .'</a>');
        $wpgrade_links[5] = '</div><a class="next disabled page-numbers">'. __('Next Page', wpGrade_txtd ) .'</a>';
    }
	
	if ( !empty($links)) {
		// catch the current page
		foreach ($links as $key => $link) {
			if ( preg_match( '/current/', $link) ) {
				$wpgrade_links[1] = '<span class="page">Page</span>';
				$wpgrade_links[2] = $link;
				break;
			}
		}
	}

	if ($last_el > 0) {
		$wpgrade_links[3] = '<span class="dots-of">of</span>';
		$wpgrade_links[4] = $links[$last_el];
	}

    ksort ($wpgrade_links);

    // output the new pagination
    foreach ( $wpgrade_links as $key => $link ) {
        echo $link;
    }

	echo '</div>';
}

//fix the pagination for portfolio
function remove_page_from_query_string($query_string)
{
	global $wpGrade_Options;
	//var_dump($query_string);die;
    if (isset($query_string['name']) && $query_string['name'] == 'page' && isset($query_string['page'])) {
        unset($query_string['name']);
        // 'page' in the query_string looks like '/2', so split it out
        list($delim, $page_index) = split('/', $query_string['page']);
		$query_string['page'] = '';
        $query_string['paged'] = $page_index;
    }
	
	//handle the pagination for the page with the portfolio template
	$portfolio_page_slug = get_portfolio_page_slug();

	if (isset($query_string[$portfolio_page_slug]) && $query_string[$portfolio_page_slug] == 'page') {
		$query_string['pagename'] = $portfolio_page_slug;
		unset($query_string["post_type"]);
		unset($query_string[$portfolio_page_slug]);
	}
	
	//test to see if we actually want a single project but the permalinks are set to /%category%/%postname%/
	if (isset($query_string['category_name']) && $query_string['category_name'] == $wpGrade_Options->get('portfolio_slug')) {
		$query_string['post_type'] = 'portfolio';
		unset($query_string['category_name']);
	}
	
	//if we are showing a portfolio category we need the post type in the query
	if (isset($query_string['portfolio_cat'])) {
		$query_string["post_type"] = 'portfolio';
	}
	//var_dump($query_string);die;
    return $query_string;
}
add_filter('request', 'remove_page_from_query_string');

//make sure there is only one "queried object" in the query
//otherwise wp_title will go south, see here: http://wordpress.stackexchange.com/questions/71157/undefined-property-stdclasslabels-in-general-template-php-post-type-archive
add_action( 'parse_query', 'wpgrade_portfolio_parse_query' );
function wpgrade_portfolio_parse_query( $wp_query )
{
    if ( $wp_query->is_post_type_archive && $wp_query->is_tax )
        $wp_query->is_post_type_archive = false;
}

function get_wpg_excerpt($str, $startPos=0, $maxLength=100) {
	if(strlen($str) > $maxLength) {
		$excerpt   = substr($str, $startPos, $maxLength-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt   = substr($excerpt, 0, $lastSpace);
		$excerpt  .= '...';
	} else {
		$excerpt = $str;
	}
	
	return $excerpt;
}

//function wpgrade_excerpt_length($length) {
//	global $wpGrade_Options;
//	
//	if ($wpGrade_Options->get('blog_excerpt_length'))
//	{
//		return absint($wpGrade_Options->get('blog_excerpt_length'));
//	}
//	return $length;
//}

function wpgrade_better_excerpt($text, $readmore = true) {
	global $wpGrade_Options, $post;
	
	//if the post has a manual excerpt ignore the content given
	if (function_exists('has_excerpt') && has_excerpt()) {
		$text = get_the_excerpt();
		$raw_excerpt = $text;
		
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);

		// Removes any JavaScript in posts (between <script> and </script> tags)
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

		// Enable formatting in excerpts - Add HTML tags that you want to be parsed in excerpts
		$allowed_tags = '<p><a><em><strong><i><br><h1><h2><h3><h4><h5><h6><blockquote><ul><li><ol>';
		$text = strip_tags($text, $allowed_tags);
		if ($readmore) {
			$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
			$text .= $excerpt_more;
		}
	} else {
	
		$raw_excerpt = $text;

		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);

		// Removes any JavaScript in posts (between <script> and </script> tags)
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

		// Enable formatting in excerpts - Add HTML tags that you want to be parsed in excerpts
		$allowed_tags = '<p><a><em><strong><i><br><h1><h2><h3><h4><h5><h6><blockquote><ul><li><ol>';
		$text = strip_tags($text, $allowed_tags);

		// Set custom excerpt length - number of words to be shown in excerpts
		if ($wpGrade_Options->get('blog_excerpt_length'))
		{
			$excerpt_length = absint($wpGrade_Options->get('blog_excerpt_length'));
		}
		else 
		{
			$excerpt_length = 55;
		}

		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = force_balance_tags( $text );
			if ($readmore) {
				$text = $text . $excerpt_more;
			}
		} else {
			$text = implode(' ', $words);		
		}
	}

	// IMPORTANT! Prevents tags cutoff by excerpt (i.e. unclosed tags) from breaking formatting
	$text = force_balance_tags( $text );
	
	$text = apply_filters('the_excerpt', $text);
	
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

function wpgrade_display_content( $content = '' ){
	// since we cannot apply "the_content" filter on some content blocks we should apply at least these bellow
	$content = apply_filters( 'wptexturize', $content);
	$content = apply_filters( 'convert_smilies', $content);
	$content = apply_filters( 'convert_chars', $content);

	$content = wpautop( $content);
	
	if (function_exists('wpgrade_remove_spaces_around_shortcodes')) {
		$content = wpgrade_remove_spaces_around_shortcodes($content);
	}
//	$content = shortcode_unautop ($content);
	$content = apply_filters( 'prepend_attachment', $content);

	// in case there is a shortcode
	echo do_shortcode($content);
}

// remove shity CSS from galleries
function wpgrade_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

// remove inline CSS for the recent comments widget
function wpgrade_remove_recent_comments_widget_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove inline CSS from the recent comments widget
function wpgrade_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

//=====================================
//Head thingys - cleanup
//=====================================

function wpgrade_head_cleanup() {
	// Remove WP version
	remove_action( 'wp_head', 'wp_generator' );
	
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	
	// remove WP version from css - those parameters can prevent caching
	//add_filter( 'style_loader_src', 'wpgrade_noversion_css_js', 9999 );
	// remove WP version from scripts - those parameters can prevent caching
	//add_filter( 'script_loader_src', 'wpgrade_noversion_css_js', 9999 );

}

// remove WP version from RSS
function wpgrade_rss_version() { return ''; }

// remove WP version from scripts
function wpgrade_noversion_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

function wpgrade_add_desktop_icons(){
    /*
     * icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/)
     */
    global $wpGrade_Options;
    $favicon = $wpGrade_Options->get( 'favicon' );
    if ( $favicon ) {
        echo '<link rel="icon" href="'.$favicon.'" />';
    }
    $apple_icon = $wpGrade_Options->get( 'apple_touch_icon' );
    if ( $apple_icon ) {
        echo '<link rel="apple-touch-icon" href="'.$apple_icon.'" />';
    }
    $win8icon = $wpGrade_Options->get( 'metro_icon' );
    if ( $win8icon ) {
        echo '<meta name="msapplication-TileColor" content="#f01d4f" />';
        echo '<meta name="msapplication-TileImage" content="'.$win8icon.'" />';
    }
}

// end head cleanup
//=====================================

// remove the <p>s around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function wpgrade_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// change the […] to a Read More link
function wpgrade_excerpt_more($more) {
	global $post;
	return '<div><a class="btn btn-primary excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read more about', wpGrade_txtd) .' '. get_the_title($post->ID).'">'. __('Read more', wpGrade_txtd) .'</a></div>';
}

//modify the read more tag link to look like the excerpt more above
function wpgrade_more_tag_link($more_link, $more_link_text) {
	global $post;
	return '<div><a class="btn btn-primary excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read more about', wpGrade_txtd) .' '. get_the_title($post->ID).'">'. __('Read more', wpGrade_txtd) .'</a></div>';
//	return str_replace($more_link_text, 'Keep reading this post', $more_link);
}
add_filter('the_content_more_link', 'wpgrade_more_tag_link', 10, 2);

function wpgrade_setup_shortcodes_plugin(){

    $current_options = get_option('wpgrade_shortcodes_list');
    $shortcodes = array('ColumnsFuse', 'ProgressBar', 'Tabs', 'TeamMember', 'Icon', 'Button', 'Divider', 'Quote', 'TestimonialsFuse', 'Arrow', 'PortfolioFuse' );
    // create an array with shortcodes which are needed by the current theme

    if ( $current_options ) {
        if ( $shortcodes === $current_options ) {

        } elseif ( is_admin() ) {
            update_option('wpgrade_shortcodes_list', $shortcodes);
        }

    } else { // there's no list ... this is bad
        update_option('wpgrade_shortcodes_list', $shortcodes);
    }
	
	//also we need to remember the prefix of the metaboxes so it can be used by the shortcodes plugin
	$prefix = '_'.WPGRADE_SHORTNAME.'_';
	$current_prefix = get_option('wpgrade_metaboxes_prefix');
	
	if (!$current_prefix || empty($current_prefix)) {
		update_option('wpgrade_metaboxes_prefix', $prefix);
	}

}

add_action('admin_head', 'wpgrade_setup_shortcodes_plugin');

// remove unnecessary page/post meta boxes
function remove_meta_boxes() {
	// pages
	remove_meta_box( 'wpGrade_formatdiv', 'page', 'normal' );
	remove_meta_box( 'wpGrade_formatdiv', 'page', 'side' );
}
add_action('admin_init','remove_meta_boxes');

function get_gravatar_url($email, $size) {
    $hash = md5(strtolower(trim($email)));
    if (isset($size)) $size = '?s='.$size;
        else $size = '';
    return 'http://gravatar.com/avatar/' . $hash . $size;
}

// add ie conditional html5 shim to header
function add_ie_html5_shim () {
    global $is_IE;
    if ($is_IE) {
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
	}
}
add_action('wp_head', 'add_ie_html5_shim');

function wpgrade_get_attachment_id_from_src ($image_src) {

    $upload_dir = explode('/wp-content/',$image_src);

    if ( isset( $upload_dir[1] ) ) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid LIKE '%/wp-content/" .$upload_dir[1]. "%'";
        $id = $wpdb->get_var($query);
        return $id;
    }

    return false;
}

function wpgrade_get_class_for_featured_image() {
    global $wpGrade_Options;
    $featured_image = false;

    if ( is_singular() && (has_post_thumbnail() || get_post_format() == 'gallery' || get_post_format() == 'image') ) {
        $featured_image = true;
    } elseif( is_page() || is_archive() || is_home() ) {
		
        if ( is_page_template( 'template-portfolio.php' ) && $wpGrade_Options->get('portfolio_header_image') ) {
            $featured_image = true;
        }

        if ( is_tax( 'portfolio_cat' ) && $wpGrade_Options->get('portfolio_header_image') ) {
            $featured_image = true;
        }
		
		if (is_page_template('template-front-page.php') && $wpGrade_Options->get('homepage_use_slider')) {
			$featured_image = true;
		 }
		 
		if ((is_archive() || is_home() || is_page_template( 'template-blog-archive.php' )) && $wpGrade_Options->get('blog_header_image')) {
			$featured_image = true;
		}
    }

    if ( $featured_image ) {
        return 'header-transparent';
    }
    return false;
}

function wpgrade_get_latest_post($pattern_type, $attachments) {
    global $wpGrade_Options;
    switch($pattern_type) {

        case 1: ?>
            <div class="block block1 block-white lap-push4">
                <div class="block-inner block-inner_last arrow arrow-left">
                    <h4 class="portfolio-item_title" ><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                    <hr class="portfolio-item_title-separator">
                    <div class="portfolio-item_desc"><?php echo wpgrade_better_excerpt(get_the_content(),false); ?></div>
                    <?php wpgrade_display_blog_terms(); 
                    if ($wpGrade_Options->get('homepage_latest_posts_readmore')) {
                        echo apply_filters('excerpt_more', ' ' . '[...]');
                    } ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="portfolio-image-wrapper image-wrapper_small">
                    <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[1]->ID, 'project-small' ); ?>" alt="<?php echo $attachments[1]->post_content; ?>">
                </a>
            </div>
            <a href="<?php the_permalink() ?>" class="block block1 block-dark lap-pull4" style="background-image: url('<?php echo wpgrade_get_attachment_image_src( $attachments[0]->ID, 'project-half' ); ?>');">
                <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[0]->ID, 'project-half' ); ?>" alt="<?php echo $attachments[0]->post_content; ?>">
            </a>
            <a href="<?php the_permalink() ?>" class="block block1 block-dark" style="background-image: url('<?php echo wpgrade_get_attachment_image_src( $attachments[2]->ID, 'project-half' ); ?>');">
                <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[2]->ID, 'project-half' ); ?>" alt="<?php echo $attachments[2]->post_content; ?>">
            </a>
            <?php break;

        case 2: ?>
            <div class="block block1 block-white lap-push8">
                <div class="block-inner arrow arrow-bottom">
                    <h4 class="portfolio-item_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                    <hr class="portfolio-item_title-separator">
                    <div class="portfolio-item_desc"><?php echo wpgrade_better_excerpt(get_the_content(),false); ?></div>
                    <?php wpgrade_display_blog_terms(); 
                    if ($wpGrade_Options->get('homepage_latest_posts_readmore')) {
                        echo apply_filters('excerpt_more', ' ' . '[...]');
                    } ?>
                </div>
                <a href="<?php the_permalink() ?>" class="portfolio-image-wrapper image-wrapper_small">
                    <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[1]->ID, 'project-small' ); ?>" alt="<?php echo $attachments[0]->post_content; ?>">
                </a>
            </div>
            <a href="<?php the_permalink() ?>" class="block block2 block-darker lap-pull4 " style="background-image: url('<?php echo wpgrade_get_attachment_image_src( $attachments[0]->ID, 'project-half' ); ?>');">
                <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[0]->ID, 'project-half' ); ?>" alt="<?php echo $attachments[1]->post_content; ?>">
            </a>
            <?php break;

        case 3: ?>
            <div class="block block1 block-white lap-push4">
                <div class="block-inner block-inner_last arrow arrow-bottom">
                    <h4 class="portfolio-item_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                    <hr class="portfolio-item_title-separator">
                    <div class="portfolio-item_desc"><?php echo wpgrade_better_excerpt(get_the_content(),false); ?></div>
                    <?php wpgrade_display_blog_terms(); 
                    if ($wpGrade_Options->get('homepage_latest_posts_readmore')) {
                        echo apply_filters('excerpt_more', ' ' . '[...]');
                    } ?>
                </div>
            </div>
            <a href="<?php the_permalink() ?>" class="block block1 block-darker lap-pull4" style="background-image: url('<?php echo wpgrade_get_attachment_image_src( $attachments[0]->ID, 'project-half' ); ?>');">
                <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[0]->ID, 'project-half' ); ?>" alt="<?php echo $attachments[0]->post_content; ?>">
            </a>
            <a href="<?php the_permalink() ?>" class="block block1 block-darker" style="background-image: url('<?php echo wpgrade_get_attachment_image_src( $attachments[1]->ID, 'project-half' ); ?>');">
                <img src="<?php echo wpgrade_get_attachment_image_src( $attachments[1]->ID, 'project-half' ); ?>" alt="<?php echo $attachments[1]->post_content; ?>">
            </a>
            <?php break;

        case 4: ?>
            <div class="block block1 block-white lap-push8">
                <div class="block-inner arrow arrow-left">
                    <h4 class="portfolio-item_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                    <hr class="portfolio-item_title-separator">
                    <div class="portfolio-item_desc"><?php echo wpgrade_better_excerpt(get_the_content(),false); ?></div>
                    <?php wpgrade_display_blog_terms(); 
                    if ($wpGrade_Options->get('homepage_latest_posts_readmore')) {
                        echo apply_filters('excerpt_more', ' ' . '[...]');
                    } ?>
                </div>
            </div>
            <a href="<?php the_permalink() ?>" class="block block2 block-darker lap-pull4 " style="background-image: url('<?php echo wpgrade_get_attachment_image_src(  $attachments[0]->ID, 'project-half' ); ?>');">
                <img src="<?php echo wpgrade_get_attachment_image_src(  $attachments[0]->ID, 'project-half' ); ?>" alt="<?php echo $attachments[0]->post_content; ?>">
            </a>
            <?php break;

        default:
            break;
    }
}

function wpgrade_homepage_latest_posts($layout, $latest_posts) {
	global $wpGrade_Options;
    global $post;
    
    switch ($layout) {

        case 'rows': ?>
            <div class="portfolio-archive latest-posts-homepage">
                <?php $index = 1; ?>
                <div class="portfolio-row row">

                    <?php
                    foreach ($latest_posts as $key => $post) : setup_postdata($post);
                        
                        switch($index % 3) {
                            case 1:
                                $block_class = 'block block1 block-light';
                                $block_inner_class = 'block-inner block-inner_first';
                                $block_image_class = 'block-dark';
                                break;
                            case 2:
                                $block_class = 'block block1 block-white';
                                $block_inner_class = 'block-inner';
                                $block_image_class = 'block-darkest';
                                break;
                            default:
                                $block_class = 'block block1 block-white';
                                $block_inner_class = 'block-inner block-inner_last';
                                $block_image_class = 'block-color';
                                break;
                        } ?>

                        <div class="<?php echo $block_class; ?> arrow arrow-bottom">
                            <div class="<?php echo $block_inner_class; ?>">
                                <h4 class="portfolio-item_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                                <hr class="portfolio-item_title-separator">
                                <div class="portfolio-item_desc"><?php echo wpgrade_better_excerpt(get_the_content(),false); ?></div>
                                <?php wpgrade_display_blog_terms(); 
                                if ($wpGrade_Options->get('homepage_latest_posts_readmore')) {
                                    echo apply_filters('excerpt_more', ' ' . '[...]');
                                } ?>
                            </div>
                            <?php $featured_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog-big'); ?>
                            <a class="lp-image-link block <?php echo $block_image_class ?>" href="<?php the_permalink(); ?>" style="background-image: url('<?php echo $featured_image_src[0] ?>'); background-position: 49.9% 49.9%;">
                                <img class="lp-image" src="<?php echo $featured_image_src[0] ?>" alt="<?php the_title(); ?>">
                                <div class="lp-image-dummy"></div>
                            </a>
                        </div>

                        <?php $index++;
                        if ($index % 3 == 0 && $index < count($latest_posts)) { ?>
                            </div><div class="row portfolio-row">
                        <?php }

                    endforeach; wp_reset_query(); ?>

                </div>
            </div>
            <?php break;

        case 'patchwork':
            $middle_content = 1;
            if (!empty($latest_posts)) : ?>
                <div class="portfolio-archive">
                    <?php foreach($latest_posts as $post): setup_postdata($post);

                        // get all the attachments except the featured image
                        $args = array(
                            'order'          => 'ASC',
                            'orderby'        => 'menu_order',
                            'post_type'      => 'attachment',
                            'post_parent'    => lang_original_post_id(get_the_ID()),
                            'post_mime_type' => 'image',
                            'post_status'    => null,
                            'posts_per_page'    => 3,
                            'exclude' => get_post_thumbnail_id(lang_original_post_id(get_the_ID()))
                        );

                        $attachments = get_posts($args);
                    
                        // if there is a feature image put it first
                        if (has_post_thumbnail()) {
                            $feature_image = get_posts(array(
                                'post_type'     => 'attachment',
                                'include'       => get_post_thumbnail_id(lang_original_post_id(get_the_ID())),
                                'posts_per_page'   => 1
                            ));
                            array_unshift($attachments, $feature_image[0]);
                        }

                        // choose a layout if there are enough images and reverse the position of the content
                        $attach_count = count($attachments);
                        if ($attach_count > 2 && $middle_content) {
                            $pattern_type = 1;
                            $middle_content = 0;
                        }
                        elseif ($attach_count > 2 && !$middle_content) {
                            $pattern_type = 2;
                            $middle_content = 1;
                        }
                        elseif ($attach_count > 1) {
                            $pattern_type = 3;
                            ($middle_content == 0) ? $middle_content = 1 : $middle_content = 0;
                        }
                        else {
                            $pattern_type = 4;
                            ($middle_content == 0) ? $middle_content = 1 : $middle_content = 0;
                        } ?>

                        <div class="portfolio-row row">
                            <?php wpgrade_get_latest_post($pattern_type, $attachments); ?>
                        </div>
                    <?php endforeach; wp_reset_query();?>
                </div>
            <?php endif;
            break;

        default:
            break;
    }
}

//prevent read more tag from scrolling down oin single post
function wpgrade_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'wpgrade_remove_more_link_scroll' );
