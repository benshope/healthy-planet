<?php
//theme options
require_once("theme-options.php");

//contact form options
require_once("contact-form-options.php");

//custom meta box
require_once("meta-box.php");

//portfolio
require_once("portfolio.php");

//resume
require_once("resume.php");

//references
require_once("references.php");

//shortcodes
require_once("shortcodes.php");

//widget
require_once("widget-most-popular.php");

//comments
require_once("comments-functions.php");

//Make theme available for translation
//Translations can be filed in the /languages/ directory
load_theme_textdomain('prestige', get_template_directory() . '/languages');

//register sidebar
if(function_exists("register_sidebar"))
	register_sidebar(array(
		"id" => "blog",
		"name" => "Blog Sidebar",
		"before_widget" => "<div class='prestige_clearfix prestige_blog_widget'>",
		"after_widget" => "</div>",
		"before_title"  => "<h3>",
		"after_title"   => "</h3>"
	));
	
//excerpt
function prestige_excerpt_more($more) 
{
	return '';
}
add_filter('excerpt_more', 'prestige_excerpt_more', 99);

//register blog post thumbnail & portfolio thumbnail
add_theme_support("post-thumbnails");
add_image_size("blog-post-thumb", 415, 160, true);
add_image_size("full-blog-post-thumb", 650, 160, true);
add_image_size("prestige-portfolio-thumb", 240, 160, true);
add_image_size("prestige-references-thumb", 180, 100, true);
function prestige_image_sizes($sizes)
{
	$addsizes = array(
		"blog-post-thumb" => __("Blog post thumbnail", 'prestige'),
		"full-blog-post-thumb" => __("Blog full width post thumbnail", 'prestige'),
		"prestige-portfolio-thumb" => __("Prestige portfolio thumbnail", 'prestige'),
		"prestige-references-thumb" => __("Prestige references thumbnail", 'prestige')
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
add_filter("image_size_names_choose", "prestige_image_sizes");

//register menu
add_theme_support("menus");
if(function_exists("register_nav_menu"))
{
	register_nav_menu("prestige-footer", "Footer Menu");
}

function prestige_after_setup_theme()
{
	if(!get_option("prestige_installed"))
	{		
		$prestige_options = array(
			"main_header" => "Ruth Howell",
			"sub_header" => "Creative Designer & Developer",
			"header_url" => "/",
			"copyright" => "Copyright 2012 Ruth Howell",
			"twitter_login" => "quanticalabs",
			"twitts_number" => 5,
			"ajax" => 0,
			"animation" => "swipe",
			"on_touch" => 1,
			"on_mouse" => 0,
			"threshold" => 10,
			"duration" => 1000,
			"animation_effect" => "scroll",
			"animation_transition" => "easeInOutExpo"
		);
		add_option("prestige_options", $prestige_options);
		
		$prestige_contact_form_options = array(
			"name_hint" => "Your Name",
			"email_hint" => "Your E-mail Address",
			"text_hint" => "Message",
			"email_subject" => "Prestige: Contact from WWW",
			"admin_name" => get_option('admin_email'),
			"admin_email" => get_option('admin_email'),
			"template" => "<html>
	<head>
	</head>
	<body>
		<div><b>Name</b>: [name]</div>
		<div><b>E-mail</b>: [email]</div>
		<div><b>Message</b>: [message]</div>
	</body>
</html>",
			"smtp_host" => "",
			"smtp_username" => "",
			"smtp_password" => "",
			"smtp_port" => "",
			"smtp_secure" => "",
			"name_error" => "Please enter your name.",
			"email_error" => "Please enter valid e-mail.",
			"text_error" => "Please enter your message.",
			"message_send_error" => "Sorry, we can\'t send this message.",
			"message_send_ok" => "Thank you for contacting us."
		);
		add_option("prestige_contact_form_options", $prestige_contact_form_options);
		
		update_option("blogdescription", "Personal vCard WordPress Theme");
		
		add_option("prestige_installed", 1);
	}
}
add_action("after_setup_theme", "prestige_after_setup_theme");

function prestige_switch_theme($theme_template)
{
	delete_option("prestige_installed");
}
add_action("switch_theme", "prestige_switch_theme");

//enable custom background
add_custom_background();

//theme options
global $prestige_options;
$prestige_options = prestige_stripslashes_deep(get_option("prestige_options"));
	
//contact form options
global $prestige_contact_form_options;
$prestige_contact_form_options = prestige_stripslashes_deep(get_option("prestige_contact_form_options"));

//get_links_config
function prestige_get_links_config($params = null)
{
	$result = array();
	//get pages
	$args = array( 
		/*'posts_per_page' => 4,
		'paged' => $params['prestige_page'],*/
		'posts_per_page' => -1,
		'post_type' => 'page',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC' 
	);
	query_posts($args);
	$i = 0;
	if(have_posts()) : while (have_posts()) : the_post(); 
		global $post;
		$result["link"][] = $post->post_name;
		$result["post_id"][] = get_the_ID();
		$result["title"][] = get_the_title();
		$result["custom_url"][] = get_post_meta(get_the_ID(), "prestige_custom_url", true);
		$color = get_post_meta(get_the_ID(), "prestige_color", true);
		if($color=="")
			$color = "D79800";
		$result["color"][] = $color;
		$i++;
	endwhile; endif;
	$result["lastPage"] = ceil($i/4);
	return $result;
}

function prestige_enqueue_scripts()
{
	global $prestige_options;
	//js
	wp_enqueue_script("jquery");
	//wp_enqueue_script("jquery-ba-bqq", get_template_directory_uri() . "/js/jquery.ba-bqq.min.js", array("jquery"));
	wp_enqueue_script("jquery-history", get_template_directory_uri() . "/js/jquery.history.js", array("jquery"));
	//wp_enqueue_script("jquery-mobile", get_template_directory_uri() . "/js/jquery.mobile-1.2.0.min.js", array("jquery"));
	wp_enqueue_script("jquery-mobile", get_template_directory_uri() . "/js/jquery.touchSwipe.min.js", array("jquery"));
	wp_enqueue_script("jquery-caroufredsel", get_template_directory_uri() . "/js/jquery.carouFredSel-6.0.4-packed.js", array("jquery"));
	wp_enqueue_script("jquery-easing", get_template_directory_uri() . "/js/jquery.easing.js", array("jquery"));
	wp_enqueue_script("jquery-block-ui", get_template_directory_uri() . "/js/jquery.blockUI.js", array("jquery"));
	wp_enqueue_script("jquery-bx-slider", get_template_directory_uri() . "/js/jquery.bxSlider.js", array("jquery"));
	wp_enqueue_script("jquery-qtip", get_template_directory_uri() . "/js/jquery.qtip.min.js", array("jquery"));
	wp_enqueue_script("jquery-fancybox", get_template_directory_uri() . "/js/jquery.fancybox.js", array("jquery"));
	wp_enqueue_script("jquery-mousewheel", get_template_directory_uri() . "/js/jquery.mousewheel.js", array("jquery"));
	wp_enqueue_script("jquery-jscrollpane", get_template_directory_uri() . "/js/jquery.jScrollPane.js", array("jquery"));
	wp_enqueue_script("jquery-nivo-slider", get_template_directory_uri() . "/js/jquery.nivo.slider.js", array("jquery"));
	//wp_enqueue_script("Modernizr-js", get_template_directory_uri() . "/js/Modernizr.js", array("jquery"));
	wp_enqueue_script("google-maps-v3", "http://maps.google.com/maps/api/js?sensor=false");
	
	wp_enqueue_script("prestige-script", get_template_directory_uri() . "/js/script.js", array("jquery"));
    wp_enqueue_script("prestige-prestige", get_template_directory_uri() . "/js/prestige.js", array("jquery"));
	wp_enqueue_script("prestige-main", get_template_directory_uri() . "/js/main.js", array("jquery"));
	wp_enqueue_script("prestige-contact-form", get_template_directory_uri() . "/js/prestige_contact_form.js", array("jquery"));
	wp_enqueue_script("prestige-comment-form", get_template_directory_uri() . "/js/prestige_comment_form.js", array("jquery"));
	
	/* Custom ajax loader */
add_filter('wpcf7_ajax_loader', 'my_wpcf7_ajax_loader');
function my_wpcf7_ajax_loader () {
	return  get_bloginfo('stylesheet_directory') . '/images/icon_loading.gif';
}
	
	$data = prestige_get_links_config();
	
	//ajaxurl
	$data["ajax"] = $prestige_options["ajax"];
	$data["ajaxurl"] = get_template_directory_uri() . "/prestige-ajax.php";
	$data["twitter_login"] = $prestige_options["twitter_login"];
	$data["twitts_number"] = $prestige_options["twitts_number"];
	
	//animation type
	$data["animation"] = $prestige_options["animation"];
	$data["on_touch"] = (int)$prestige_options["on_touch"];
	$data["on_mouse"] = (int)$prestige_options["on_mouse"];
	$data["threshold"] = (int)$prestige_options["threshold"];
	$data["duration"] = (int)$prestige_options["duration"];
	$data["animation_effect"] = $prestige_options["animation_effect"];
	$data["animation_transition"] = $prestige_options["animation_transition"];
	
	//home url
	$data["home_url"] = get_home_url();
	//site description
	$data["blog_name"] = get_bloginfo('name');
	$data["blog_desc"] = get_bloginfo('description');
	
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("prestige-main", "config", $params);
	
	//css
	wp_enqueue_style("jquery-jscrollpane", get_template_directory_uri() . "/style/jquery.jScrollPane.css");
	wp_enqueue_style("jquery-qtip", get_template_directory_uri() . "/style/jquery.qtip.css");
	wp_enqueue_style("jquery-nivo-slider", get_template_directory_uri() . "/style/jquery.nivo-slider.css");
	wp_enqueue_style("jquery-fancybox", get_template_directory_uri() . "/style/fancybox/jquery.fancybox.css");
	wp_enqueue_style("google-font-open-sans", "http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700,300,200");
}
add_action("wp_enqueue_scripts", "prestige_enqueue_scripts");

//get prestige
function prestige_get($params)
{
	global $wpdb;
	global $prestige_options;
	$result = array();
	//get number of pages
	$result["count"] = wp_count_posts("page")->publish;
	$result["lastPage"] = ceil($result["count"]/4);

	//get pages
	query_posts(array( 
		'post_type' => 'page',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order', 
		'order' => 'ASC'
	));
	$i = 0;
	$result["html"] = "";
	$result["pages"] = array();
	if(have_posts()) : while (have_posts()) : the_post();
		global $post;
		if(!$prestige_options["ajax"] || $prestige_options["animation"]=="swipe")
		{
			$template = get_post_meta(get_the_ID(), '_wp_page_template', true);
			if($template!="" && $template!="default")
				$result["pages"][$i] = "template-" . $template . "-" . $post->post_name;
			else
			{
				$color = get_post_meta(get_the_ID(), "prestige_color", true);
				if($color=="")
					$color = "D79800";
				$result["pages"][$i] = "<li style='background-color:#". $color . ";' class='prestige-window-background' id='prestige-window-content-" . $post->post_name . "'>" . get_the_content() . "</li>";
			}
		}
		$custom_url = get_post_meta(get_the_ID(), "prestige_custom_url", true);
		/*$icon = get_post_meta(get_the_ID(), "prestige_icon", true);*/
		$custom_url_target = get_post_meta($post->ID, "prestige_custom_url_target", true);
		$result["html"] .= '
		<li id="prestige-menu-element-' .  get_the_ID() . '" class="prestige-menu-element-' . ($i+1) . '">
			<a' . ($custom_url!="" ? ' class="custom_url"' : '') . ($custom_url!="" && $custom_url_target=="new_window" ? " target='_blank'" : "") . ' href="' . ($custom_url!="" ? $custom_url : $post->post_name . "/ ") . '">
				<span class="prestige-title-container"' . ($icon=="" ? ' style="width: auto;"' : '') . '>
					<span class="prestige-title">' . get_the_title() . '</span>';
					if($subtitle = get_post_meta(get_the_ID(), "prestige_subtitle", true))
						$result["html"] .= '<span class="prestige-subtitle">' . $subtitle . '</span>';
		$result["html"] .= '
				</span>';
			if($icon!="")
		$result["html"] .= '		
				<span class="prestige-icon-container">
					<span class="prestige-line-vertical">
					</span>
					<span class="prestige-icon prestige-icon-' . $icon . '">
					</span>
				</span>';
		$result["html"] .= '
			</a>
		</li>';
		$i++;
	endwhile; endif;
	
	if(!$prestige_options["ajax"] || $prestige_options["animation"]=="swipe")
	{
		for($j=0; $j<$i; $j++)
		{
			if(substr($result["pages"][$j], 0, 9)=="template-")
			{
				$explode = explode("-", $result["pages"][$j]);
				query_posts("name=" . $explode[2] . "&post_type=page");
				if(have_posts()) : the_post(); 
					ob_start();
					$color = get_post_meta(get_the_ID(), "prestige_color", true);
					$included = 1;
					include($explode[1]);
					$result["pages"][$j] = "<li style='background-color:#". $color . ";' class='prestige-window-background' id='prestige-window-content-" . $explode[2] . "'>" . ob_get_contents() . "</li>";
					ob_end_clean();
				endif;
			}
			else
				$result["pages"][$j] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $result["pages"][$j]));
		}
	}
	return $result;
}

//ajax
function prestige_get_content()
{
	$result = array();
	if($_GET["name"]!='')
	{
		//post
		query_posts("name=" . $_GET["name"] . "&post_type=post");
		if(have_posts()) : the_post(); 
			if($_GET["parent_name"]!="")
			{
				global $parent;
				$args=array(
				  'name' => $_GET["parent_name"],
				  'post_type' => 'page',
				  'post_status' => 'publish',
				  'showposts' => 1
				);
				$parentArray = get_posts($args);
				$parent = $parentArray[0];
			}
			ob_start();
			if($_GET["type"]=="get_comments")
				comments_template();
			else
				include("single-blog.php");
			$result["html"] = ob_get_contents();
			ob_end_clean();
		else:
			//page
			query_posts("name=" . $_GET["name"] . "&post_type=page");
			if(have_posts()) : the_post(); 
				$template = get_post_meta(get_the_ID(), '_wp_page_template', true);
				if($template!="" && $template!="default")
				{
					ob_start();
					$included = 1;
					include($template);
					$result["html"] = ob_get_contents();
					ob_end_clean();
				}
				else
					$result["html"] = do_shortcode(get_the_content());
			endif;
		endif;
		//contact form 7
		if(defined('WPCF7_PLUGIN_DIR') && WPCF7_LOAD_JS)
			$result["cf7"] = plugins_url('scripts.js', WPCF7_PLUGIN_DIR . "/includes/js/scripts.js");
	}
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_prestige_get_content", "prestige_get_content");
add_action("wp_ajax_nopriv_prestige_get_content", "prestige_get_content");

//function to display number of posts
function getPostViews($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    return (int)$count;
}

//function to count views
function setPostViews($postID) 
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    }
	else
	{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
?>