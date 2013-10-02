<?php
//Adds a box to the main column on the Portfolio edit screens
function prestige_add_references_custom_box() 
{
    add_meta_box( 
        "references_config",
        __("Options", 'prestige'),
        "prestige_inner_references_custom_box",
        "prestige_references",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "prestige_add_references_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "prestige_add_custom_box", 1);

// Prints the box content
function prestige_inner_references_custom_box($post) 
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "prestige_references_noncename");

	//The actual fields for data entry
	$subheader = get_post_meta($post->ID, "subheader", true);
	echo '
	<table>
		<tr>
			<td>
				<label for="portfolio_video_url">' . __('Subheader', 'prestige') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="subheader" name="prestige_subheader" value="' . esc_attr(get_post_meta($post->ID, "subheader", true)) . '" />
			</td>
		</tr>
	</table>
	';
}

//When the post is saved, saves our custom data
function prestige_save_references_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['prestige_references_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "subheader", $_POST["prestige_subheader"]);
}
add_action("save_post", "prestige_save_references_postdata");
//custom post type - references
function prestige_references_init() {  
	$labels = array(
		'name' => _x('References', 'post type general name', 'prestige'),
		'singular_name' => _x('References Item', 'post type singular name', 'prestige'),
		'add_new' => _x('Add New', 'prestige_references', 'prestige'),
		'add_new_item' => __('Add New References Item', 'prestige'),
		'edit_item' => __('Edit References Item', 'prestige'),
		'new_item' => __('New References Item', 'prestige'),
		'all_items' => __('All References Items', 'prestige'),
		'view_item' => __('View References Item', 'prestige'),
		'search_items' => __('Search References Item', 'prestige'),
		'not_found' =>  __('No references items found', 'prestige'),
		'not_found_in_trash' => __('No references items found in Trash', 'prestige'), 
		'parent_item_colon' => '',
		'menu_name' => __("References", 'prestige')
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
	register_post_type("prestige_references", $args);  
	
	register_taxonomy("prestige_references_category", array("prestige_references"), array("label" => "Categories", "singular_label" => "Category", "rewrite" => true)); 
}  
add_action("init", "prestige_references_init"); 

//custom references items list
function prestige_references_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('References Item', 'post type singular name', 'prestige'),
		"subheader" => __('Subheader', 'prestige'),
		"prestige_references_category" => __('Categories', 'prestige'),
		"date" => __('Date', 'prestige') 
	);

	return $columns;  
}  
add_filter("manage_edit-prestige_references_columns", "prestige_references_edit_columns");   

function manage_prestige_references_posts_custom_column($column)
{
	global $post;
	switch ($column)  
	{
		case "subheader":
			echo esc_attr(get_post_meta($post->ID, "subheader", true));
			break;
		case "prestige_references_category":
			echo get_the_term_list($post->ID, "prestige_references_category", '', ', ',''); 
			break;
	}  
}
add_action("manage_prestige_references_posts_custom_column", "manage_prestige_references_posts_custom_column");

//references
function prestige_references_shortcode($atts)
{
	extract(shortcode_atts(array(
		"header" => "Clients references",
		"category" => "",
		"style" => ""
	), $atts));
	
	$output = "";
	if($header!="")
		$output .= '<h3>' . $header . '</h3>';
	$output .= '<div class="no-list references-list layout-33 overflow-fix clear-fix' . ($style!="simple" ? ' references-advanced' : '') . '">';
	//get pages
	query_posts(array( 
		'post_type' => 'prestige_references',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'prestige_references_category' => $category,
		'orderby' => 'menu_order', 
		'order' => 'ASC'
	));
	if($style=="simple")
	{
		$i = 0;
		if(have_posts()) : while (have_posts()) : the_post();
			if($i%3==0)
			{
				if($i!=0)
					$output .= '</ul>';
				$output .= '<ul class="references-list-row prestige_clearfix">';
			}
			$output .= '
			<li>
				<h5>' . get_the_title() . '<br />' . get_post_meta(get_the_ID(), "subheader", true) . '</h5>
				' . get_the_post_thumbnail(get_the_ID(), "prestige-references-thumb", array("alt" => esc_attr(get_the_title()), "title" => "")) . '
				<p>' . do_shortcode(get_the_content()) . '</p>
			</li>';
			$i++;
		endwhile; endif;
		$output .= '</ul>';
	}
	else
	{
		$i = 0;
		global $wp_query;
		$count = $wp_query->post_count;
		$output .= '<ul class="references-list-column references-list-column-first">';
		if(have_posts()) : while (have_posts()) : the_post();
			if($i==ceil($wp_query->post_count/2))
				$output .= '</ul><ul class="references-list-column">';
			$output .= '
			<li>
				<h4>' . get_the_title() . '<span>' . get_post_meta(get_the_ID(), "subheader", true) . '</span></h4>
				<span class="arrow_top"></span>
				<p>' . do_shortcode(get_the_content()) . '</p>
			</li>';
			$i++;
		endwhile; endif;
		$output .= '</ul>';
	}
	$output .= '</div>';
	return $output;
}
add_shortcode("prestige_references", "prestige_references_shortcode");
?>