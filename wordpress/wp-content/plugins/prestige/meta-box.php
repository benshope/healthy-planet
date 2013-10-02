<?php
//add colorpicker only for page
function prestige_admin_init()
{
	wp_register_script("prestige-colorpicker", get_template_directory_uri() . "/js/colorpicker.js", array("jquery"));
	wp_register_script("prestige-admin", get_template_directory_uri() . "/js/prestige_admin.js", array("jquery", "colorpicker"));
	wp_register_style("prestige-colorpicker", get_template_directory_uri() . "/style/colorpicker.css");
}
add_action("admin_init", "prestige_admin_init");

function prestige_admin_print_scripts()
{
	wp_enqueue_script("jquery");
	wp_enqueue_script("prestige-colorpicker");
	wp_enqueue_script("prestige-admin");
	wp_enqueue_style("prestige-colorpicker");
}

//admin menu
function prestige_admin_menu_add_post() 
{
	add_action("admin_print_scripts-post-new.php", "prestige_admin_print_scripts");
	add_action("admin_print_scripts-post.php", "prestige_admin_print_scripts");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "prestige_admin_print_scripts");
}
add_action("admin_menu", "prestige_admin_menu_add_post");
//Adds a box to the main column on the Page edit screens
function prestige_add_custom_box() 
{
    add_meta_box( 
        "page_config",
        "Page configuration",
        "prestige_inner_custom_box",
        "page",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "prestige_add_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "prestige_add_custom_box", 1);

// Prints the box content
function prestige_inner_custom_box($post) 
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "prestige_noncename");

	//The actual fields for data entry
	$icon = get_post_meta($post->ID, "prestige_icon", true);
	$blog_categories = get_post_meta($post->ID, "prestige_blog_categories", true);
	$post_categories = get_terms("category");
	$custom_url_target = get_post_meta($post->ID, "prestige_custom_url_target", true);
	echo '
	<table>
		<tr>
			<td>
				<label for="prestige_subtitle">Subtitle:</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="prestige_subtitle" name="prestige_subtitle" value="' . esc_attr(get_post_meta($post->ID, "prestige_subtitle", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="prestige_color">Color:</label>
			</td>
			<td>
				<input type="text" class="regular-text" id="prestige_color" name="prestige_color" value="' . esc_attr(get_post_meta($post->ID, "prestige_color", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="prestige_icon">Icon:</label>
			</td>
			<td>
				<select style="width: 120px;" id="prestige_icon" name="prestige_icon">
					<option value="">-</option>
					<option value="application"' . ($icon=="application" ? ' selected="selected"' : '') . '>application</option>
					<option value="basket"' . ($icon=="basket" ? ' selected="selected"' : '') . '>basket</option>
					<option value="briefcase"' . ($icon=="briefcase" ? ' selected="selected"' : '') . '>briefcase</option>
					<option value="camera"' . ($icon=="camera" ? ' selected="selected"' : '') . '>camera</option>
					<option value="cart"' . ($icon=="cart" ? ' selected="selected"' : '') . '>cart</option>
					<option value="chat"' . ($icon=="chat" ? ' selected="selected"' : '') . '>chat</option>
					<option value="clock"' . ($icon=="clock" ? ' selected="selected"' : '') . '>clock</option>
					<option value="database"' . ($icon=="database" ? ' selected="selected"' : '') . '>database</option>
					<option value="document"' . ($icon=="document" ? ' selected="selected"' : '') . '>document</option>
					<option value="folder"' . ($icon=="folder" ? ' selected="selected"' : '') . '>folder</option>
					<option value="graph"' . ($icon=="graph" ? ' selected="selected"' : '') . '>graph</option>
					<option value="image"' . ($icon=="image" ? ' selected="selected"' : '') . '>image</option>
					<option value="list"' . ($icon=="list" ? ' selected="selected"' : '') . '>list</option>
					<option value="mail"' . ($icon=="mail" ? ' selected="selected"' : '') . '>mail</option>
					<option value="mobile"' . ($icon=="mobile" ? ' selected="selected"' : '') . '>mobile</option>
					<option value="people"' . ($icon=="people" ? ' selected="selected"' : '') . '>people</option>
					<option value="printer"' . ($icon=="printer" ? ' selected="selected"' : '') . '>printer</option>
					<option value="screen"' . ($icon=="screen" ? ' selected="selected"' : '') . '>screen</option>
					<option value="sound"' . ($icon=="sound" ? ' selected="selected"' : '') . '>sound</option>
					<option value="video"' . ($icon=="video" ? ' selected="selected"' : '') . '>video</option>				
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="prestige_custom_url">Custom URL:</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="prestige_custom_url" name="prestige_custom_url" value="' . esc_attr(get_post_meta($post->ID, "prestige_custom_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="prestige_custom_url_target">' . __('Custom URL target', 'cascade') . ':</label>
			</td>
			<td>
				<select id="prestige_custom_url_target" name="prestige_custom_url_target">
					<option value="same_window"' . ($custom_url_target=="same_window" ? ' selected="selected"' : '') . '>' . __('same window', 'cascade') . '</option>
					<option value="new_window"' . ($custom_url_target=="new_window" ? ' selected="selected"' : '') . '>' . __('new window', 'cascade') . '</option>
				</select>
			</td>
		</tr>
		';
		if(count($post_categories))
		{
			echo '
		<tr>
			<td>
				<label for="prestige_blog_categories">Blog categories:</label>
			</td>
			<td>
				<select id="prestige_blog_categories" name="prestige_blog_categories[]" multiple="multiple">';
					foreach($post_categories as $post_category)
						echo '<option value="' . $post_category->term_id . '"' . (is_array($blog_categories) && in_array($post_category->term_id, $blog_categories) ? ' selected="selected"' : '') . '>' . $post_category->name . '</option>';
			echo '
				</select>
			</td>
		</tr>';
		}
		echo '
	</table>
	';
}

//When the post is saved, saves our custom data
function prestige_save_postdata($post_id) 
{
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['prestige_noncename'], plugin_basename( __FILE__ )))
		return;


	// Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "prestige_subtitle", $_POST["prestige_subtitle"]);
	update_post_meta($post_id, "prestige_color", $_POST["prestige_color"]);
	update_post_meta($post_id, "prestige_icon", $_POST["prestige_icon"]);
	update_post_meta($post_id, "prestige_custom_url", $_POST["prestige_custom_url"]);
	update_post_meta($post_id, "prestige_custom_url_target", $_POST["prestige_custom_url_target"]);
	update_post_meta($post_id, "prestige_blog_categories", $_POST["prestige_blog_categories"]);
}
add_action("save_post", "prestige_save_postdata");
?>