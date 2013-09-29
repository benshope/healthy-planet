<?php

if (!function_exists('register_button')) {
function register_button( $buttons ) {
   array_push( $buttons, "|", "qode_shortcodes" );
   return $buttons;
}
}

if (!function_exists('add_plugin')) {
function add_plugin( $plugin_array ) {
   $plugin_array['qode_shortcodes'] = get_template_directory_uri() . '/includes/qode_shortcodes.js';
   return $plugin_array;
}
}

if (!function_exists('qode_shortcodes_button')) {
function qode_shortcodes_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_plugin' );
      add_filter( 'mce_buttons', 'register_button' );
   }

}
}

add_action('init', 'qode_shortcodes_button');


if (!function_exists('no_wpautop')) {
function no_wpautop($content) 
{ 
        $content = do_shortcode( shortcode_unautop($content) ); 
        $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
        return $content;
}
}
if (!function_exists('num_shortcodes')) {
function num_shortcodes($content) 
{ 
        $columns = substr_count( $content, '[pricing_cell' );
		return $columns;
}
}

/* Three columns wrap shortcode */

if (!function_exists('three_columns')) {
function three_columns($atts, $content = null) {
    return '<div class="three_columns clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('three_columns', 'three_columns');

/* Four columns wrap shortcode */

if (!function_exists('four_columns')) {
function four_columns($atts, $content = null) {
    return '<div class="four_columns clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('four_columns', 'four_columns');

/* Two columns wrap shortcode */

if (!function_exists('two_columns')) {
function two_columns($atts, $content = null) {
    return '<div class="two_columns_50_50 clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('two_columns', 'two_columns');

/* Two columns 66_33 wrap shortcode */

if (!function_exists('two_columns_66_33')) {
function two_columns_66_33($atts, $content = null) {
    return '<div class="two_columns_66_33 clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('two_columns_66_33', 'two_columns_66_33');

/* Two columns 33_66 wrap shortcode */

if (!function_exists('two_columns_33_66')) {
function two_columns_33_66($atts, $content = null) {
    return '<div class="two_columns_33_66 clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('two_columns_33_66', 'two_columns_33_66');

/* Two columns 75_25 wrap shortcode */

if (!function_exists('two_columns_75_25')) {
function two_columns_75_25($atts, $content = null) {
    return '<div class="two_columns_75_25 clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('two_columns_75_25', 'two_columns_75_25');

/* Two columns 25_75 wrap shortcode */

if (!function_exists('two_columns_25_75')) {
function two_columns_25_75($atts, $content = null) {
    return '<div class="two_columns_25_75 clearfix">' . do_shortcode($content) . '</div>';
}
}
add_shortcode('two_columns_25_75', 'two_columns_25_75');

/* Column one shortcode */

if (!function_exists('column1')) {
function column1($atts, $content = null) {
	return '<div class="column1"><div class="column_inner">' . do_shortcode($content) . '</div></div>';
}
}
add_shortcode('column1', 'column1');

/* Column two shortcode */

if (!function_exists('column2')) {
function column2($atts, $content = null) {
	return '<div class="column2"><div class="column_inner">' . do_shortcode($content) . '</div></div>';
}
}
add_shortcode('column2', 'column2');

/* Column three shortcode */

if (!function_exists('column3')) {
function column3($atts, $content = null) {
   return '<div class="column3"><div class="column_inner">' . do_shortcode($content) . '</div></div>';
}
}
add_shortcode('column3', 'column3');

/* Column four shortcode */

if (!function_exists('column4')) {
function column4($atts, $content = null) {
   return '<div class="column4"><div class="column_inner">' . do_shortcode($content) . '</div></div>';
}
}
add_shortcode('column4', 'column4');

/* Dropcaps shortcode */

if (!function_exists('dropcaps')) {
function dropcaps($atts, $content = null) {
	extract(shortcode_atts(array("style" => "", "background_color" => ""), $atts));
	return "<span class='dropcap $style' style='background-color: $background_color;'>" . no_wpautop($content)  . "</span>";
}
}
add_shortcode('dropcaps', 'dropcaps');

/* Blockquote shortcode */

if (!function_exists('blockquote')) {
function blockquote($atts, $content = null) {
	$html = ""; 
  extract(shortcode_atts(array("width" => ""), $atts));
	$html .= "<blockquote"; 
	if($width > 0){
		$html .= " style=width:$width%;";
	}
	$html .= ">" . no_wpautop($content) . "</blockquote>";
  return $html;
}
}
add_shortcode('blockquote', 'blockquote');

/* Message shortcode */

if (!function_exists('message')) {
function message($atts, $content = null) {
	global $qode_options_central;
  $html = ""; 
	extract(shortcode_atts(array("background_color"=>""), $atts));
	$html .= "<div class='message";
	$html .= "' style='";
	if($background_color != ""){
		$html .= 'background-color: '.$background_color.'; ';
	}
	
	$html .= "'><a href='#' class='close'></a>" .no_wpautop($content) . "</div>";
	
	return $html;
}
}
add_shortcode('message', 'message');

/* Accordion shortcode */

if (!function_exists('accordion')) {
function accordion($atts, $content = null) {
	extract(shortcode_atts(array("accordion_type" => ""), $atts));
	return "<div class='accordion_holder $accordion_type'>" . no_wpautop($content) . "</div>";
}
}
add_shortcode('accordion', 'accordion');

/* Accordion item shortcode */

if (!function_exists('accordion_item')) {
function accordion_item($atts, $content = null) {

	extract(shortcode_atts(array("caption" => ""), $atts));
	return "<h4><span><span class='control-pm'></span></span>".$caption."</h4><div class='accordion_content'><div class='accordion_content_inner'>" . no_wpautop($content) . "</div></div>";
}
}
add_shortcode('accordion_item', 'accordion_item');

/* Unordered List shortcode */

if (!function_exists('unordered_list')) {
function unordered_list($atts, $content = null) {
    extract(shortcode_atts(array("style" => ""), $atts));
    $html =  "<div class='list $style'>" . $content . "</div>";  
    return $html;
}
}
add_shortcode('unordered_list', 'unordered_list');

/* Ordered List shortcode */

if (!function_exists('ordered_list')) {
function ordered_list($atts, $content = null) {
    $html =  "<div class=ordered>" . $content . "</div>";  
    return $html;
}
}
add_shortcode('ordered_list', 'ordered_list');

/* Elements Animation shortcode */

if (!function_exists('elements_animation')) {
function elements_animation($atts, $content = null) {
	extract(shortcode_atts(array("animation_type" => ""), $atts));
	return "<div class='$animation_type'><div>" . no_wpautop($content) . "</div></div>";
}
}
add_shortcode('elements_animation', 'elements_animation');

/* Image With Text Over shortcode */

if (!function_exists('image_with_text_over')) {
function image_with_text_over($atts, $content = null) {
	extract(shortcode_atts(array("title" => "", "image_link" => ""), $atts));
	return "<div class='image_with_text_over'><div class='shader'></div><img src='$image_link' /><div class='text'><table><tr><td style='vertical-align:middle'><div class='caption'><p>$title</p></div></td></tr></table><table><tr><td style='vertical-align:middle'><div class='desc'>".no_wpautop($content)."</div></td></tr></table></div></div>";
}
}
add_shortcode('image_with_text_over', 'image_with_text_over');

/* Accordion Full Width shortcode */

if (!function_exists('accordion_full_width')) {
function accordion_full_width($atts, $content = null) {
	extract(shortcode_atts(array("title" => "", "full_width" => "", "background_color" => ""), $atts));
	return "<div class='accordion full_screen $full_width' style='background-color: $background_color;'><div class='accordion_inner'><h4>$title <span class='arrow'></span></h4><div class='accordion_content'>" . no_wpautop($content) . "</div></div></div>";
}
}
add_shortcode('accordion_full_width', 'accordion_full_width');

/* Top Area Line shortcode */

if (!function_exists('top_area_line')) {
function top_area_line($atts, $content = null) {
	extract(shortcode_atts(array("full_width" => "", "background_color" => ""), $atts));
	return "<div class='top_area_line_holder $full_width' style='background-color: $background_color;'><div class='top_area_line'><div class='top_area_line_text_holder'>" . no_wpautop($content) . "</div></div></div>";
}
}
add_shortcode('top_area_line', 'top_area_line');

/* Buttons shortcode */

if (!function_exists('button')) {
function button($atts, $content = null) {
	global $qode_options_central;
	$html = "";
	extract(shortcode_atts(array("size" => "", "color"=> "", "background_color"=>"", "font_size"=>"", "line_height"=>"", "font_style"=>"", "font_weight"=>"", "text"=> "Button", "link"=> "http://qodeinteractive.com/", "target"=> "_self"), $atts));
    $html .=  '<a href="'.$link.'" target="'.$target.'" class="button '.$size.'" style="';
		if($color != ""){
			$html .= 'color: '.$color.'; ';
		}
		if($background_color != ""){
			$html .= 'background-color: '.$background_color.'; ';
		}
		if($font_size != ""){
			$html .= 'font-size: '.$font_size.'px; ';
		}
		if($line_height != ""){
			$html .= 'line-height: '.$line_height.'px; ';
		}
		if($font_style != ""){
			$html .= 'font-style: '.$font_style.'; ';
		}
		if($font_weight != ""){
			$html .= 'font-weight: '.$font_weight.'; ';
		}
		$html .= '">' . $text . '</a>';  
    return $html;
}
}
add_shortcode('button', 'button');

/* Tabs shortcode */

if (!function_exists('tabs')) {
function tabs( $atts, $content = null ) {
  $html = ""; 
	extract(shortcode_atts(array(
    ), $atts));
	$html .= '<div class="tabs '.(isset($atts['type'])?$atts['type']:'').'">';
	$html .= '<ul class="tabs-nav">';
	$key = array_search((isset($atts['type'])?$atts['type']:''),$atts);
		if($key!==false){
			unset($atts[$key]);
	}
	foreach ($atts as $key => $tab) {
		$html .= '<li><a href="#' . $key . '">' . $tab . '</a></li>';
	}
	$html .= '</ul>';
	$html .= '<div class="tabs-container">';
	$html .= no_wpautop($content) .'</div></div>';
	return $html;
}
}
add_shortcode('tabs', 'tabs');

/* Tab shortcode */

if (!function_exists('tab')) {
function tab( $atts, $content = null ) {
  $html = ""; 
	extract(shortcode_atts(array(
    ), $atts));
	$html .= '<div id="tab' . $atts['id'] . '" class="tab-content">' . no_wpautop($content) .'</div>';
	return $html;
}
}
add_shortcode('tab', 'tab');

/* Pie Chart shortcode */

if (!function_exists('pie_chart')) {
function pie_chart($atts, $content = null) {
	extract(shortcode_atts(array("title" => "", "percent"=> "100"), $atts));
    $html =  "<div class='chart'><div class='percentage' data-percent='".$percent."'><span class='tocounter'>".$percent."</span>%</div>";

    if(empty($title) && (empty($content) || $content == null || $content == "")){
    	$html .= "</div>"; 
    } else {
    	$html .= "<div class='pie_chart_text'><h4>".$title."</h4>" . no_wpautop($content) . "</div></div>";
    } 

    return $html;
}
}
add_shortcode('pie_chart', 'pie_chart');

/* Progress bars shortcode */

if (!function_exists('progress_bars')) {
function progress_bars($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
    $html =  "<div class='progress_bars'>" . no_wpautop($content) . "</div>";  
    return $html;
}
}
add_shortcode('progress_bars', 'progress_bars');

/* Progress bar shortcode */

if (!function_exists('progress_bar')) {
function progress_bar($atts, $content = null) {
	extract(shortcode_atts(array("title" => "Web Design", "percent"=> "100"), $atts));
    $html =  "<div class='progress_bar'><span class='progress_title'><h4>$title</h4></span><span class='progress_number'><em></em></span>	<div class='progress_content_outer'><div data-percentage='$percent' class='progress_content'></div></div></div>";  
    return $html;
}
}
add_shortcode('progress_bar', 'progress_bar');

/* Pricing table shortcode */

if (!function_exists('pricing_table')) {
function pricing_table($atts, $content = null) {
  $html = ""; 
	extract(shortcode_atts(array(), $atts));
    	$html .=  "<div class='price_tables";
		$html .= "'>" . no_wpautop($content) . "</div>";  
    return $html;
}
}
add_shortcode('pricing_table', 'pricing_table');

/* Pricing table column shortcode */

if (!function_exists('pricing_column')) {
function pricing_column($atts, $content = null) {
  $html = ""; 
	extract(shortcode_atts(array("title" => '', "price" => "0", "price_currency" => "$", "price_period" => "mo", "link" => "", "button_text" => "Buy Now", "active"=>"" , "active_text"=>"Most Popular"), $atts));
	$html .=  "<div class='price_table'>";
	if($active == "yes"){
		$html .= "<div class='active_best_price'><p>".$active_text."</p></div>";
	}
	$html .=  "<div class='price_table_inner'>";
	
	$html .= "<ul><li><div class='price_in_table'><sup class='value'>".$price_currency."</sup><span class='price'>".$price."</span><sub class='mark'>/".$price_period."</sub></div></li><li class='cell table_title'>$title</li>" . no_wpautop($content) . "<li><div class='button_price_holder'><a class='button tiny' href='$link'>$button_text</a></div></li></ul></div></div>";
	
    return $html;
}
}
add_shortcode('pricing_column', 'pricing_column');


/* Pricing table cell shortcode */

if (!function_exists('pricing_cell')) {
function pricing_cell($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
    $html =  "<li class='cell'>" . no_wpautop($content) . "</li>"; 
	return $html;
}
}
add_shortcode('pricing_cell', 'pricing_cell');

/* Table shortcode */

if (!function_exists('table')) {
function table($atts, $content = null) {
  $html = ""; 
	extract(shortcode_atts(array(), $atts));
    $html .=  "<table class='standard-table'><tbody>" . no_wpautop($content) . "</tbody></table>";  
    return $html;
}
}
add_shortcode('table', 'table');

/* Table row shortcode */

if (!function_exists('table_row')) {
function table_row($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
    $html =  "<tr>" . no_wpautop($content) . "</tr>";  
    return $html;
}
}
add_shortcode('table_row', 'table_row');

/* Table head cell shortcode */

if (!function_exists('table_cell_head')) {
function table_cell_head($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
    $html =  "<th><h4>" . no_wpautop($content) . "</h4></th>";  
    return $html;
}
}
add_shortcode('table_cell_head', 'table_cell_head');

/* Table body cell shortcode */

if (!function_exists('table_cell_body')) {
function table_cell_body($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
    $html =  "<td>" . no_wpautop($content) . "</td>";  
    return $html;
}
}
add_shortcode('table_cell_body', 'table_cell_body');

/* Testimonial shortcode */

if (!function_exists('testimonial')) {
function testimonial($atts, $content = null) {
	extract(shortcode_atts(array("background_color" => "", "name" => "", "position" => "", "image_link" => ""), $atts));
  	$html = ""; 	
		$html .=  "<div class='testimonial' style='background-color: $background_color;'><div class='testimonial_inner";
		if($image_link == ""): $html .= " no_image"."'>"; endif;
		if($image_link !==""): $html .= "'><div class='image'><img src='$image_link' /></div>"; endif;
		$html .= "<div class='text'><span class='name'>$name</span><p>". no_wpautop($content) ."</p><span class='position'>$position</span></div></div></div>";
										
    	return $html;
}
}
add_shortcode('testimonial', 'testimonial');

/* Highlights shortcode */

if (!function_exists('highlight')) {
function highlight($atts, $content = null) {
	$html =  "<span class='highlight'>" . $content . "</span>";  
    return $html;
}
}
add_shortcode('highlight', 'highlight');

/* H3 With Line shortcode */

if (!function_exists('h3_with_line')) {
function h3_with_line($atts, $content = null) {
	$html =  "<h3 class='title_with_line'>" . $content . "</h3><div class='title_with_line_separator'></div>";  
    return $html;
}
}
add_shortcode('h3_with_line', 'h3_with_line');


/* Action shortcode */

if (!function_exists('action')) {
function action($atts, $content = null) {
	extract(shortcode_atts(array("background_color" => ""), $atts));
	$html =  "<div class='call_to_action' style='background-color: ".$background_color."'>" . no_wpautop($content) . "</div>";  
    return $html;
}
}
add_shortcode('action', 'action');

/* Portfolio shortcode */

if (!function_exists('portfolio_list')) {
function portfolio_list($atts, $content = null) {
	global $wp_query;
	$html = "";
	extract(shortcode_atts(array("type" => "1", "columns" => "3", "order_by" => "menu_order" , "order" => "ASC" , "number"=>"-1", "filter"=>'no', "lightbox"=>'yes', "category"=>"", "selected_projects"=>"", "show_load_more" => "yes"), $atts));
	
	if($filter == "yes"){
		$html .= "<div class='filter_holder'>
						<ul>
						<li class='label'><span data-label='". __('View by Type','qode') ."'>". __('View by Type','qode') ."</span>
						<div class='arrow'></div>
						</li>
						<li class='filter' data-filter='all'><span>". __('All','qode') ."</span></li>";
				if ($category == "") {
					$args = array(
						'parent'  => 0
					);
					$portfolio_categories = get_terms( 'portfolio_category',$args);
				} else {
					$top_category = get_term_by('slug',$category,'portfolio_category');
					$term_id = '';
					if (isset($top_category->term_id)) $term_id = $top_category->term_id;
					$args = array(
						'parent'  => $term_id
					);
					$portfolio_categories = get_terms( 'portfolio_category',$args);
				}
				foreach($portfolio_categories as $portfolio_category) {
					$html .=	"<li class='filter' data-filter='$portfolio_category->slug'><span>$portfolio_category->name</span>";
					$args = array(
						'child_of' => $portfolio_category->term_id
					);
					// $portfolio_categories2 = get_terms( 'portfolio_category',$args);
					
					// if(count($portfolio_categories2) > 0){
						// $html .= '<ul>';
						// foreach($portfolio_categories2 as $portfolio_category2) {
							// $html .=	"<li class='filter' data-filter='.$portfolio_category2->slug'><span>$portfolio_category2->name</span></li>";
						// }
						// $html .= '</ul>';
					// }
					
					$html .= '</li>';
				}
		$html .= "</ul></div>";
	}
	
	
	
	$html .= "<div class='projects_holder_outer'><div class='projects_holder projects_type$type v$columns'>\n";
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	if ($category == "") {
		$args = array(
			'post_type'=> 'portfolio_page',
			'orderby' => $order_by,
			'order' => $order,
			'posts_per_page' => $number,
			'paged' => $paged
		);
	} else {
		$args = array(
			'post_type'=> 'portfolio_page',
			'portfolio_category' => $category,
			'orderby' => $order_by,
			'order' => $order,
			'posts_per_page' => $number,
			'paged' => $paged
		);
	}
	$project_ids = null;
	if ($selected_projects != "") {
		$project_ids = explode(",",$selected_projects);
		$args['post__in'] = $project_ids;
	}
	query_posts( $args );
	if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$terms = wp_get_post_terms(get_the_ID(),'portfolio_category');
	$html .= "<article class='mix ";
	foreach($terms as $term) {
		$html .= "$term->slug ";
	}

    $title = get_the_title();
    $featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' ); //original size  
    $large_image = $featured_image_array[0];
    $slug_list_ = "pretty_photo_gallery";

	$html .="'>";
	$html .= "<div class='image'>";
	if($type == 2) {
		$html .= "<div class='hover-type-text'><div class='hover-inner'>";
			$html .= "<a href='". get_permalink() ."' class='hover-inner-link'>";
			$html .= "<h4 class='portfolio_title'>" . get_the_title() . "</h4><br />";
			$html .= '<p>';
				$k=1;
				foreach($terms as $term) {
					$html .= "$term->name";
					if(count($terms) != $k){
						$html .= ', ';
					}
				$k++;
				}
			$html .= '</p></a>';
				
			if($lightbox == "yes"){
				$html .= "<a class='preview' title='" . $title . "' href='" . $large_image . "' data-rel='prettyPhoto[".$slug_list_."]'></a></div></div>";
			} else {
				$html .= "</div></div>";
			}
	}

	$html .= "<a href='". get_permalink() ."'>".get_the_post_thumbnail()."</a></div>";
	if($type == 2) {
		$html .= "<h4>" . get_the_title() . "</h4>";
	}
	if($type != 2) {
		$html .= "<div class='hover'>";
				
		
		$html .= "<div class='hover-inner'>";
		$html .= "<a href='". get_permalink() ."' class='hover-inner-link'>";
		$html .= "<h4 class='portfolio_title'>" . get_the_title() . "</h4><br />";
		$html .= '<p>';
			$k=1;
			foreach($terms as $term) {
				$html .= "$term->name";
				if(count($terms) != $k){
					$html .= ', ';
				}
			$k++;
			}
		$html .= '</p></a>';
		
		if($lightbox == "yes"){
			$html .= "<a class='preview' title='" . $title . "' href='" . $large_image . "' data-rel='prettyPhoto[".$slug_list_."]'></a></div></div>";
		} else {
			$html .= "</div></div>";
		}
	}
	$html .= "</article>\n";
						
	endwhile; 
	
	$i = 1;
	while ($i <= $columns) {
		$i++;
		$html .= "<div class='filler'></div>\n";
	}
	
	else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.','qode'); ?></p>
	<?php endif; 	
	
	
	$html .= "</div>";
	if(get_next_posts_link()) {
		if($show_load_more == "yes" || $show_load_more == ""){
			$html .= '<div class="portfolio_paging"><span rel="'. $wp_query->max_num_pages .'" class="load_more">'. get_next_posts_link(__('Load More','qode')) . '</span></div>';
		}
	}
	$html .= "</div>";
	wp_reset_query();	
    return $html;
}
}
add_shortcode('portfolio_list', 'portfolio_list');

/* Paralax shortcode */

if (!function_exists('parallax')) {
function parallax($atts, $content = null) {
	extract(shortcode_atts(array("pager" => "no",), $atts));
	$html = "";
	$html .= "<section class='parallax'>";
	if($pager == "yes"){
		$html .= '<div class="link_holder_parallax"></div>';
	}
	$html .= no_wpautop($content);
	$html .= "</section>";
	return $html;
}
}
add_shortcode('parallax', 'parallax');

if (!function_exists('parallax_section')) {
function parallax_section($atts, $content = null) {
	extract(shortcode_atts(array("id" => "", "height"=>"300", "title" => "..."), $atts));
	$parallaxes = get_post_meta(get_the_ID(), "qode_parallaxes", true);
	$html = "";
	
	foreach($parallaxes as $parallax) 
	{	
		if($parallax['imageid'] == $id) 
			{
			$html .= '<section id="'.$parallax['imageid'].'" style="background-image:url('. $parallax['parimg'] .'); background-color:'. $parallax['parcolor'] .';" data-height="' . $height . '" data-title="' . $title . '">';
			$html .= '<div class="parallax_content">';
			$html .= no_wpautop($content);
			$html .= '</div>';
			$html .= '</section>';
		}			
	}
	
	return $html;
}
}
add_shortcode('parallax_section', 'parallax_section');


if (!function_exists('separator')) {
function separator($atts, $content = null) {
    extract(shortcode_atts(array("color" => "", "thickness" => "", "up" => "","down" => ""), $atts));
		$html =  '<div style="';
		if($up != ""){
		$html .= "margin-top:". $up ."px;";
		}
		if($down != ""){
		$html .= "margin-bottom:". $down ."px;"; 
		}
		if($color != ""){
		$html .= "background-color: ". $color .";";
		}
		if($thickness != ""){
		$html .= "height:". $thickness ."px;";
		}
		$html .= '" class="separator"></div>';  
		
    return $html;
}
}
add_shortcode('separator', 'separator');


/* Social Icons shortcode */

if (!function_exists('social_icons')) {
function social_icons($atts, $content = null) {
    extract(shortcode_atts(array("style" => ""), $atts));
    $html = ""; 
    $html .=  "       <ul class='social_menu $style'>";  
    $social_icons_array = explode(",", $content);
    for ($i = 0 ; $i < count($social_icons_array) ; $i = $i + 2)
    {
		$html .=  "<li class='" . trim($social_icons_array[$i]) . "'><a href='" . trim($social_icons_array[$i + 1]) . "' target='_blank'><span class='inner'>" . trim($social_icons_array[$i]) . "</span></a></li>";   
    }
     $html .=  "           </ul>";


    return $html;
}
}
add_shortcode('social_icons', 'social_icons');

/* Services shortcode */

if (!function_exists('service')) {
function service($atts, $content = null) {
    $html = ""; 
	extract(shortcode_atts(array("type"=>"top", "title" => "", "link" => "") , $atts));	
	$html .= '<div class="circle_item circle_'.$type.'">';
	if ($link == "")
		$html .= '<div class="circle"><div style="padding: 107.5px 0px;">'.$title.'</div></div><div class="text">';
	else
		$html .= '<div class="circle"><div style="padding: 107.5px 0px;"><a href="'.$link.'">'.$title.'</a></div></div><div class="text">';
	$html .= no_wpautop($content);
	$html .= '</div></div>';
	
	return $html;
}
}
add_shortcode('service', 'service');


/* Video shortcode */

if (!function_exists('video')) {
function video($atts, $content = null) {
    $html = ""; 
	extract(shortcode_atts(array("type"=>"youtube", "id"=>"", "height"=>"") , $atts));	
	$html .= "<div class='video_holder'>"; 
	if($type == 'youtube'){
		$html .= '<iframe title="YouTube video player" height="' . $height . '" src="http://www.youtube.com/embed/' . $id . '?wmode=transparent" wmode="Opaque" frameborder="0" allowfullscreen></iframe>';
	}elseif($type == 'vimeo'){
		$html .= '<iframe src="http://player.vimeo.com/video/' . $id . '" height="' . $height . '" frameborder="0"></iframe>';
	}
	$html .= "</div>"; 
	return $html;
}
}
add_shortcode('video', 'video');

/* Latest post shortcode */

if (!function_exists('latest_post')) {
function latest_post($atts, $content = null) {
	global $qode_options_magnet;
  	$html = ""; 
		extract(shortcode_atts(array("type" => "","post_number"=>"", "category" => "", "text_length"=>""), $atts));
		
		$q = new WP_Query( 
		   array( 'orderby' => 'date', 'posts_per_page' => $post_number, 'category_name' => $category) 
		);		

		$html .= "<div class='latest_post_holder $type'><ul>";

			while($q->have_posts()) : $q->the_post();
			
				$html .= '<li class="';
				if($post_number == 2){
					$html .= 'two';
				} else if($post_number == 3){
					$html .= 'three';
				} else if($post_number == 4){
					$html .= 'four';
				} else if($post_number == 5){
					$html .= 'five';
				}
				if($type == 'small') {				
					if($text_length > 0){
						$html .= '"><div class="latest_post"><a href="'. get_permalink() .'">' . get_the_post_thumbnail(get_the_id(),'latest_posts') . '</a><div class="latest_post_text"><span>'. get_post_time('d M Y') .'</span><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>' . '<p>' . substr(get_the_excerpt(), 0, intval($text_length)) . '</p></div></div></li>';
					} else {
						$html .= '"><div class="latest_post"><a href="'. get_permalink() .'">' . get_the_post_thumbnail(get_the_id(),'latest_posts') . '</a><div class="latest_post_text"><span>'. get_post_time('d M Y') .'</span><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></div></div></li>';
					}
				}else {
					if($text_length > 0){
						$html .= '"><div class="latest_post"><a href="'. get_permalink() .'">' . get_the_post_thumbnail(get_the_id(),'full') . '</a><div class="latest_post_text"><span>'. get_post_time('d M Y') .'</span><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>' . '<p>' . substr(get_the_excerpt(), 0, intval($text_length)) . '</p></div></div></li>';
					} else {
						$html .= '"><div class="latest_post"><a href="'. get_permalink() .'">' . get_the_post_thumbnail(get_the_id(),'full') . '</a><div class="latest_post_text"><span>'. get_post_time('d M Y') .'</span><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4></div></div></li>';
					}
				}
			
			endwhile;

			wp_reset_query();

		$html .= "</ul></div>";
	return $html;	
}
}
add_shortcode('latest_post', 'latest_post');

/* Counter shortcode */

if (!function_exists('counter')) {
function counter($atts, $content = null) {
		extract(shortcode_atts(array("digit" => "", "font_size" => ""), $atts));
    $html = "";  
		$html .=  '<span class="counter" ';
		if($font_size){
			$html .= 'style="font-size:'.$font_size.'px; height:'.$font_size.'px; line-height:'.$font_size.'px;"';
		}
		$html .= '>'.$digit.'</span>';

    return $html;
}
}
add_shortcode('counter', 'counter');

/* Social Share shortcode */

if (!function_exists('social_share')) {
function social_share($atts, $content = null) {
	global $qode_options_central;
	if(isset($qode_options_central['twitter_via']) && !empty($qode_options_central['twitter_via'])) {
		$twitter_via = " via " . $qode_options_central['twitter_via'];
	} else {
		$twitter_via = 	"";
	}
    $html = "";  
	if(isset($qode_options_central['enable_social_share']) && $qode_options_central['enable_social_share'] == "yes") { 
		$post_type = get_post_type();
		if(isset($qode_options_central["post_types_names_$post_type"])) {
			if($qode_options_central["post_types_names_$post_type"] == $post_type) {
				$html .= '<div class="social-share">';
					$html .= '<ul>';
					if(isset($qode_options_central['enable_facebook_share']) &&  $qode_options_central['enable_facebook_share'] == "yes") { 
						$html .= '<li>';
						$html .= '<a href="#" onclick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . get_the_title() . '&amp;p[summary]=' . get_the_excerpt() . '&amp;p[url]=' . urlencode(get_permalink()) . '&amp;&p[images][0]=';
						if(function_exists('the_post_thumbnail')) {
							$html .=  wp_get_attachment_url(get_post_thumbnail_id());
						}
						$html .='\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');" href="javascript: void(0)">';
						if(!empty($qode_options_central['facebook_icon'])) {
							$html .= '<img src="' . $qode_options_central["facebook_icon"] . '" />';
						} else { 
							$html .= '<img src="' . get_template_directory_uri() . '/img/icon_facebook_like.png" title="" alt="" />';
						} 
						$html .= "<span>" . __('Share','qode') . "</span>";
						$html .= "</a>";
						$html .= "</li>";
						} 
						if($qode_options_central['enable_twitter_share'] == "yes") { 
							$html .= "<li>";
							$html .= '<a href="#" onclick="popUp=window.open(\'http://twitter.com/share?url=' . urlencode(get_permalink()) . '&text=' . urlencode(the_excerpt_max_charlength(mb_strlen(get_permalink())) . $twitter_via) . '&count=horiztonal\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;" target="_blank" rel="nofollow">';
									if(!empty($qode_options_central['twitter_icon'])) { 
										$html .= '<img src="' . $qode_options_central["twitter_icon"] . '" />';
									 } else { 
										$html .= '<img src="' . get_template_directory_uri() . '/img/icon_tweet.png" title="" alt="" />';
									 }
									$html .= "<span>" . __('Tweet','qode') . "</span>";
								$html .= "</a>";
							$html .= "</li>";
						 } 
						if($qode_options_central['enable_google_plus'] == "yes") { 
							$html .= "<li>";
							$html .= '<a href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . urlencode(get_permalink()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
									if(!empty($qode_options_central['google_plus_icon'])) { 
										$html .= '<img src="' . $qode_options_central['google_plus_icon'] . '" />';
									} else { 
										$html .= '<img src="' . get_template_directory_uri() . '/img/icon_g_plus.png" title="" alt="" />';
									 } 
									$html .= "<span>" . __('Share','qode') . "</span>";
								$html .= "</a>";
							$html .= "</li>";
						 }
						$html .= "</ul>";
				$html .= "</div>";
			} 
		}  
	}
    return $html;
}
}
add_shortcode('social_share', 'social_share');