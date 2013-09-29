<?php 
/*
Template Name: Blog Template 3
*/ 
?>
<?php get_header(); ?>
<?php 
global $wp_query;
$id = $wp_query->get_queried_object_id();
$category = get_post_meta($id, "qode_choose-blog-category", true);
$post_number = get_post_meta($id, "qode_show-posts-per-page", true);
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
query_posts('post_type=post&paged='. $paged . '&cat=' . $category .'&posts_per_page=' . $post_number );
$sidebar = get_post_meta($id, "qode_show-sidebar", true); 

$blog_hide_comments = "";
if (isset($qode_options_central['blog_hide_comments'])) 
	$blog_hide_comments = $qode_options_central['blog_hide_comments'];

if(get_post_meta($id, "qode_responsive-title-image", true) != ""){
 $responsive_title_image = get_post_meta($id, "qode_responsive-title-image", true);
}else{
	$responsive_title_image = $qode_options_central['responsive_title_image'];
}

if(get_post_meta($id, "qode_fixed-title-image", true) != ""){
 $fixed_title_image = get_post_meta($id, "qode_fixed-title-image", true);
}else{
	$fixed_title_image = $qode_options_central['fixed_title_image'];
}

if(get_post_meta($id, "qode_title-image", true) != ""){
 $title_image = get_post_meta($id, "qode_title-image", true);
}else{
	$title_image = $qode_options_central['title_image'];
}

if(get_post_meta($id, "qode_title-height", true) != ""){
 $title_height = get_post_meta($id, "qode_title-height", true);
}else{
	$title_height = $qode_options_central['title_height'];
}

$title_in_grid = false;
if(isset($qode_options_central['title_in_grid'])){
if ($qode_options_central['title_in_grid'] == "yes") $title_in_grid = true;
}
?>
			
	<?php if(!get_post_meta($id, "qode_show-page-title", true)) { ?>
	<div class="title <?php if($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "yes"){ echo 'has_fixed_background '; } if($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "no"){ echo 'has_background'; } if($responsive_title_image == 'yes'){ echo 'with_image'; } ?>" <?php if($responsive_title_image == 'no' && $title_image != ""){ echo 'style="background-image:url('.$title_image.'); height:'.$title_height.'px;"'; }?>>
		<?php if($responsive_title_image == 'yes' && $title_image != ""){ echo '<img src="'.$title_image.'" alt="title" />'; } ?>
		<?php if($title_in_grid){ ?>
		<div class="container">
			<div class="container_inner clearfix">
		<?php } ?>
		<h1><?php echo get_the_title($id); ?></h1>
		<?php if($title_in_grid){ ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	
	<?php if($qode_options_central['show_back_button'] == "yes") { ?>
		<a id='back_to_top' href='#'>
			<span class='back_to_top_inner'>
				<span>&nbsp;</span>
			</span>
		</a>
	<?php } ?>
	
	<?php
		$revslider = get_post_meta($id, "qode_revolution-slider", true);
		if (!empty($revslider)){
			echo do_shortcode($revslider);
		}
	?>
	<div class="container">
		<div class="container_inner clearfix">
		<?php if(($sidebar == "default")||($sidebar == "")) : ?>
				<div class="blog_holder1 clearfix">
					<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
						<article <?php post_class(); ?>>
							<div class="blog_title_holder">
								 <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
								 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
							</div>
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="image">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php	the_post_thumbnail('full'); ?>
									</a>
								</div>
							<?php } ?>

							<div class="blog1_text_holder">
								 <div class="text">
										<?php the_content(); ?>
								 </div>

								 <div class="info">
								 	<?php if($blog_hide_comments != "yes"){ ?>
										<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
									<?php } ?>	
										<span class="right"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('READ MORE', 'qode'); ?></a></span>
								 </div>
							</div>
						</article>
					<?php endwhile; ?>
					<?php if($qode_options_central['pagination'] != "0") : ?>
					<?php pagination($wp_query->max_num_pages, $wp_query->max_num_pages, $paged); ?>
					<?php endif; ?>
				<?php else: //If no posts are present ?>
					<div class="entry">                        
							<p><?php _e('No posts were found.', 'qode'); ?></p>    
					</div>
				<?php endif; ?>
			</div>			
		<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
			<div class="<?php if($sidebar == "1"):?>two_columns_66_33<?php elseif($sidebar == "2") : ?>two_columns_75_25<?php endif; ?> background_color_sidebar grid2 clearfix">
						<div class="column1">
							<div class="column_inner">
							
									<div class="blog_holder1 clearfix">
										<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
											<article <?php post_class(); ?>>
												<div class="blog_title_holder">
													 <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
													 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
												</div>
												<?php if ( has_post_thumbnail() ) { ?>
													<div class="image">
														<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
															<?php	the_post_thumbnail('full'); ?>
														</a>
													</div>
												<?php } ?>

												<div class="blog1_text_holder">
													 <div class="text">
															<?php the_content(); ?>
													 </div>

													 <div class="info">
													 	<?php if($blog_hide_comments != "yes"){ ?>
															<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
														<?php } ?>	
															<span class="right"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('READ MORE', 'qode'); ?></a></span>
													 </div>
												</div>
											</article>
										<?php endwhile; ?>
										<?php if($qode_options_central['pagination'] != "0") : ?>
										<?php pagination($wp_query->max_num_pages, $wp_query->max_num_pages, $paged); ?>
										<?php endif; ?>
									<?php else: //If no posts are present ?>
										<div class="entry">                        
												<p><?php _e('No posts were found.', 'qode'); ?></p>    
										</div>
									<?php endif; ?>
								</div>
										
							</div>
						</div>
						<div class="column2">
						<?php get_sidebar(); ?>	
						</div>
					</div>
		<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
			<div class="<?php if($sidebar == "3"):?>two_columns_33_66<?php elseif($sidebar == "4") : ?>two_columns_25_75<?php endif; ?> background_color_sidebar grid2 clearfix">
						<div class="column1">
						<?php get_sidebar(); ?>	
						</div>
						<div class="column2">
							<div class="column_inner">
									
								<div class="blog_holder1 clearfix">
									<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
										<article <?php post_class(); ?>>
											<div class="blog_title_holder">
												 <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
												 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
											</div>
											<?php if ( has_post_thumbnail() ) { ?>
												<div class="image">
													<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
														<?php	the_post_thumbnail('full'); ?>
													</a>
												</div>
											<?php } ?>

											<div class="blog1_text_holder">
												 <div class="text">
														<?php the_content(); ?>
												 </div>

												 <div class="info">
												 	<?php if($blog_hide_comments != "yes"){ ?>
														<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENT','qode') ); ?></a></span>
													<?php } ?>	
														<span class="right"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('READ MORE', 'qode'); ?></a></span>
												 </div>
											</div>
										</article>
									<?php endwhile; ?>
									<?php if($qode_options_central['pagination'] != "0") : ?>
									<?php pagination($wp_query->max_num_pages, $wp_query->max_num_pages, $paged); ?>
									<?php endif; ?>
								<?php else: //If no posts are present ?>
									<div class="entry">                        
											<p><?php _e('No posts were found.', 'qode'); ?></p>    
									</div>
								<?php endif; ?>
							</div>
											
							</div>
						</div>
						
					</div>
		<?php endif; ?>
	
	</div>
</div>
<?php get_footer(); ?>