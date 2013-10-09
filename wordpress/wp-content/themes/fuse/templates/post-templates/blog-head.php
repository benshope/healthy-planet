<?php global $wpGrade_Options; ?>
<?php if ($wpGrade_Options->get('blog_show_featured_image') && !is_single() && has_post_thumbnail()) { 
	echo '<a class="featured-image-blog" href="'.get_permalink().'" title="'.esc_attr( sprintf( __( 'Read more about %s', wpGrade_txtd ), the_title_attribute( 'echo=0' ) ) ).'" rel="bookmark">'; wpgrade_get_thumbnail( 'blog-big', 'entry-featured-image' ); echo '</a>';
} ?>