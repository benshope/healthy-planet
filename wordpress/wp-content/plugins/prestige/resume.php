<?php
//custom post type - resume
function prestige_resume_init() {  
	$labels = array(
		'name' => _x('Resume', 'post type general name', 'prestige'),
		'singular_name' => _x('Resume Item', 'post type singular name', 'prestige'),
		'add_new' => _x('Add New', 'prestige_resume', 'prestige'),
		'add_new_item' => __('Add New Resume Item', 'prestige'),
		'edit_item' => __('Edit Resume Item', 'prestige'),
		'new_item' => __('New Resume Item', 'prestige'),
		'all_items' => __('All Resume Items', 'prestige'),
		'view_item' => __('View Resume Item', 'prestige'),
		'search_items' => __('Search Resume Item', 'prestige'),
		'not_found' =>  __('No resume items found', 'prestige'),
		'not_found_in_trash' => __('No resume items found in Trash', 'prestige'), 
		'parent_item_colon' => '',
		'menu_name' => __("Resume", 'prestige')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "editor", "page-attributes")  
	);
	register_post_type("prestige_resume", $args);  
	
	register_taxonomy("prestige_resume_category", array("prestige_resume"), array("label" => "Categories", "singular_label" => "Category", "rewrite" => true)); 
}  
add_action("init", "prestige_resume_init"); 

//Adds a box to the main column on the Resume edit screens
function prestige_add_resume_custom_box() 
{
    add_meta_box( 
        "resume_config",
        __("Options", 'prestige'),
        "prestige_inner_resume_custom_box",
        "prestige_resume",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "prestige_add_resume_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "prestige_add_custom_box", 1);

//Prints the box content
function prestige_inner_resume_custom_box($post) 
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "prestige_resume_noncename");

	echo '
	<table>
		<tr>
			<td>
				<label for="resume_years">' . __('Resume years', 'prestige') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="resume_years" name="resume_years" value="' . esc_attr(get_post_meta($post->ID, "years", true)) . '" />
			</td>
		</tr>
	</table>
	';
}

//When the post is saved, saves our custom data
function prestige_save_resume_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['prestige_resume_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "years", $_POST["resume_years"]);
}
add_action("save_post", "prestige_save_resume_postdata");

//custom resume items list
function prestige_resume_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Resume Item', 'post type singular name', 'prestige'),   
		"years" => __('Years', 'prestige'),
		"prestige_resume_category" => __('Categories', 'prestige'),
		"date" => __('Date', 'prestige') 
	);

	return $columns;  
}  
add_filter("manage_edit-prestige_resume_columns", "prestige_resume_edit_columns");   

function manage_prestige_resume_posts_custom_column($column)
{
	global $post;
	switch ($column)  
	{
		case "years":   
			echo get_post_meta($post->ID, "years", true);  
			break;
		case "prestige_resume_category":
			echo get_the_term_list($post->ID, "prestige_resume_category", '', ', ',''); 
			break;
	}  
}
add_action("manage_prestige_resume_posts_custom_column", "manage_prestige_resume_posts_custom_column");

//resume
function prestige_resume_shortcode($atts)
{
	extract(shortcode_atts(array(
		"header" => "Work Experience",
		"style" => "",
		"category" => "",
	), $atts));
	
	$output = "";
	if($header!="")
		$output .= '<h3>' . $header . '</h3>';
	$output .= '<ul class="no-list experience-list">';
	//get pages
	query_posts(array( 
		'post_type' => 'prestige_resume',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'prestige_resume_category' => $category,
		'orderby' => 'menu_order', 
		'order' => 'ASC'
	));
	if(have_posts()) : while (have_posts()) : the_post();
		$years = get_post_meta(get_the_ID(), "years", true);
		$output .= '
		<li>
			<div class="prestige_clearfix">';
		if($years!="")
			$output .= '<span class="resume_years">' . $years . '</span><span class="arrow_bottom"></span>';
		$output .= '
			<h4>' . get_the_title() . '</h4>';
		$output .= '
			</div>
			<p>' . do_shortcode(apply_filters("the_content", get_the_content())) . '</p>
		</li>';
	endwhile; endif;
	$output .= '</ul>';
	return $output;
}
add_shortcode("prestige_resume", "prestige_resume_shortcode");
?>