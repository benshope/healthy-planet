<?php if ( function_exists('dynamic_sidebar')) {
	global $wpGrade_Options;$post;
	
	$posttype = get_post_type($post);
	
	$template = '';
	if (is_single()) {
		$template = $wpGrade_Options->get('blog_single_template');
	} else {
		$template = $wpGrade_Options->get('blog_archive_template');
	}
?>

<?php
if( (is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag()) || (is_search()) ) {
	if ( is_active_sidebar( 'sidebar1' ) ) : ?>
	<div id="sidebar1" class="side side-content widget-area <?php echo $template; if ($template == 'l-sidebar-left') echo ' pull8'; ?>" role="complementary">
   		<div class="block-inner block-inner_last"><?php dynamic_sidebar( 'sidebar1' ); ?></div>
	</div>
<?php endif;
} else {
	if ( is_page() && is_active_sidebar( 'pagesidebar' )) : ?>
	<div id="pagesidebar" class="side side-content widget-area" role="complementary">
   		<div class="block-inner block-inner_last"><?php dynamic_sidebar( 'pagesidebar' ); ?></div>
	</div>
<?php endif;
	}
} ?>