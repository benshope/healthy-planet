<?php
//custom post type - prestige portfolio
function prestige_portfolio_init() {  
	$labels = array(
		'name' => _x('Portfolio', 'post type general name', 'prestige'),
		'singular_name' => _x('Portfolio Item', 'post type singular name', 'prestige'),
		'add_new' => _x('Add New', 'prestige_portfolio', 'prestige'),
		'add_new_item' => __('Add New Portfolio Item', 'prestige'),
		'edit_item' => __('Edit Portfolio Item', 'prestige'),
		'new_item' => __('New Portfolio Item', 'prestige'),
		'all_items' => __('All Portfolio Items', 'prestige'),
		'view_item' => __('View Portfolio Item', 'prestige'),
		'search_items' => __('Search Portfolio Item', 'prestige'),
		'not_found' =>  __('No portfolio items found', 'prestige'),
		'not_found_in_trash' => __('No portfolio items found in Trash', 'prestige'), 
		'parent_item_colon' => '',
		'menu_name' => __("Portfolio", 'prestige')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "editor", "thumbnail", "page-attributes")  
	);
	register_post_type("prestige_portfolio", $args);  
	
	register_taxonomy("prestige_portfolio_category", array("prestige_portfolio"), array("label" => "Categories", "singular_label" => "Category", "rewrite" => true)); 
}  
add_action("init", "prestige_portfolio_init"); 

//Adds a box to the main column on the Portfolio edit screens
function prestige_add_portfolio_custom_box() 
{
    add_meta_box( 
        "portfolio_config",
        __("Options", 'prestige'),
        "prestige_inner_portfolio_custom_box",
        "prestige_portfolio",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "prestige_add_portfolio_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "prestige_add_custom_box", 1);

// Prints the box content
function prestige_inner_portfolio_custom_box($post) 
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "prestige_portfolio_noncename");

	//The actual fields for data entry
	$external_url_target = get_post_meta($post->ID, "external_url_target", true);
	echo '
	<table>
		<tr>
			<td>
				<label for="portfolio_video_url">' . __('Video URL (optional)', 'prestige') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="portfolio_video_url" name="portfolio_video_url" value="' . esc_attr(get_post_meta($post->ID, "video_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="portfolio_iframe_url">' . __('Ifame URL (optional)', 'prestige') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="portfolio_iframe_url" name="portfolio_iframe_url" value="' . esc_attr(get_post_meta($post->ID, "iframe_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="portfolio_external_url">' . __('External URL (optional)', 'prestige') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="portfolio_external_url" name="portfolio_external_url" value="' . esc_attr(get_post_meta($post->ID, "external_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="portfolio_external_url_target">' . __('External URL target', 'prestige') . ':</label>
			</td>
			<td>
				<select id="portfolio_external_url_target" name="portfolio_external_url_target">
					<option value="same_window"' . ($external_url_target=="same_window" ? ' selected="selected"' : '') . '>' . __('same window', 'prestige') . '</option>
					<option value="new_window"' . ($external_url_target=="new_window" ? ' selected="selected"' : '') . '>' . __('new window', 'prestige') . '</option>
				</select>
			</td>
		</tr>
	</table>
	';
}

//When the post is saved, saves our custom data
function prestige_save_portfolio_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['prestige_portfolio_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "video_url", $_POST["portfolio_video_url"]);
	update_post_meta($post_id, "iframe_url", $_POST["portfolio_iframe_url"]);
	update_post_meta($post_id, "external_url", $_POST["portfolio_external_url"]);
	update_post_meta($post_id, "external_url_target", $_POST["portfolio_external_url_target"]);
}
add_action("save_post", "prestige_save_portfolio_postdata");

//custom portfolio items list
function prestige_portfolio_edit_columns($columns)
{  
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Portfolio Item', 'post type singular name', 'prestige'),   
		"video_url" => __('Video URL', 'prestige'),
		"iframe_url" => __('Iframe URL', 'prestige'),
		"external_url" => __('External URL', 'prestige'),
		"prestige_portfolio_category" => __('Categories', 'prestige'),
		"date" => __('Date', 'prestige') 
	);    

	return $columns;  
}  
add_filter("manage_edit-prestige_portfolio_columns", "prestige_portfolio_edit_columns");   

function manage_prestige_portfolio_posts_custom_column($column)
{
	global $post;
	switch ($column)  
	{
		case "video_url":   
			echo get_post_meta($post->ID, "video_url", true);  
			break;
		case "iframe_url":   
			echo get_post_meta($post->ID, "iframe_url", true);  
			break;
		case "external_url":   
			echo get_post_meta($post->ID, "external_url", true);  
			break;
		case "prestige_portfolio_category":
			echo get_the_term_list($post->ID, "prestige_portfolio_category", '', ', ',''); 
			break;
	}  
}
add_action("manage_prestige_portfolio_posts_custom_column", "manage_prestige_portfolio_posts_custom_column");

//portfolio
function prestige_portfolio_shortcode($atts)
{
	extract(shortcode_atts(array(
		"category" => "",
	), $atts));
	
	$output = "<ul class='no-list portfolio-list'>";
	//get pages
	query_posts(array( 
		'post_type' => 'prestige_portfolio',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'prestige_portfolio_category' => $category,
		'orderby' => 'menu_order', 
		'order' => 'ASC'
	));
	if(have_posts()) : while (have_posts()) : the_post();
		if(has_post_thumbnail()) 
		{
			$video_url = get_post_meta(get_the_ID(), "video_url", true);
			if($video_url!="")
				$large_image_url = $video_url;
			else
			{
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "large");
				$large_image_url = $attachment_image[0];
			}
			$external_url = get_post_meta(get_the_ID(), "external_url", true);
			$external_url_target = get_post_meta(get_the_ID(), "external_url_target", true);
			$iframe_url = get_post_meta(get_the_ID(), "iframe_url", true);
			$output .= "
			<li class='layout-6040 overflow-fix clear-fix portfolio-item'>
				<div class='layout-6040-left'>
					<h5>" . get_the_title() . "</h5>
					" . do_shortcode(apply_filters("the_content", get_the_content())) . "
				</div>
				<div class='layout-6040-right" . ($external_url=="" ? " fancybox-" . ($video_url!="" ? "video" : ($iframe_url!="" ? "iframe" : "image")) : "") . "'>
					<a class='fancybox-overlay' href='" . ($external_url=="" ? ($iframe_url!="" ? $iframe_url : $large_image_url) : $external_url) . "'" . ($external_url!="" && $external_url_target=="new_window" ? " target='_blank'" : "") . " title='" . esc_attr(get_the_title()) . "'>
						<span></span>"
						. get_the_post_thumbnail($post->ID, "prestige-portfolio-thumb", array("alt" => esc_attr(get_the_title()), "title" => "")) .
					"</a>
				</div>
			</li>";
		}
	endwhile; endif;
	$output .= "</ul>";
	return $output;
}
add_shortcode("prestige_portfolio", "prestige_portfolio_shortcode");
?>