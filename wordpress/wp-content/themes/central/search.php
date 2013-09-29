<?php get_header(); ?>
<?php 
global $wp_query;
$id = $wp_query->get_queried_object_id();

if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

$sidebar = $qode_options_central['category_blog_sidebar'];

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
			
	<?php /*
	<div class="title">	
		<h1><span><?php _e('SEARCH', 'qode'); ?></span><?php if (!empty($s)) : ?> / <?php echo $s; ?><?php endif; ?></h1>
	</div> */ ?>
	
	<div class="title <?php if($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "yes"){ echo 'has_fixed_background '; } if($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "no"){ echo 'has_background'; } if($responsive_title_image == 'yes'){ echo 'with_image'; } ?>" <?php if($responsive_title_image == 'no' && $title_image != ""){ echo 'style="background-image:url('.$title_image.'); height:'.$title_height.'px;"'; }?>>
			<?php if($responsive_title_image == 'yes' && $title_image != ""){ echo '<img src="'.$title_image.'" alt="title" />'; } ?>
			<?php if($title_in_grid){ ?>
			<div class="container">
				<div class="container_inner clearfix">
			<?php } ?>
			<h1><?php _e('SEARCH', 'qode'); ?></h1>
			<?php if($title_in_grid){ ?>
				</div>
			</div>
			<?php } ?>
	</div>
	
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
	
	<?php if(($sidebar == "default")||($sidebar == "")) : ?>
				<?php switch ($qode_options_central['blog_style']) {
					case 1: ?>
						<div class="full_width">
							<div class="blog_holder clearfix">
								<div class="blog_holder_inner">
							
									<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
									<article <?php post_class('mix'); ?>>
										<?php if ( has_post_thumbnail() ) { ?>
										<div class="image">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
												<?php the_post_thumbnail('blog-type-1'); ?>
											</a>
										</div>
										<?php } ?>
										<div class="blog_text_holder">
											 <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
											 <div class="text">
													<div class="text_inner">
														 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
														 <?php the_excerpt(); ?>
													</div>
											 </div>
											 <div class="info">
													<a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a>
											 </div>
										</div>
										</article>
									<?php endwhile; ?>
									<div class="filler"></div>
									<div class="filler"></div>
									<div class="filler"></div>
									<div class="filler"></div>
									<?php else: //If no posts are present ?>
										<div class="entry">                        
												<p><?php _e('No posts were found.', 'qode'); ?></p>    
										</div>
									<?php endif; ?>
									
								</div>
								<?php if($qode_options_central['pagination'] != "0") : ?>
								<?php pagination($wp_query->max_num_pages, $wp_query->max_num_pages, $paged); ?>
								<?php endif; ?>
								<?php wp_reset_query(); ?>
							</div>
						</div>
					 <?php	break;
					case 2: ?>
						<div class="container">
							<div class="container_inner clearfix">
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
														<?php the_excerpt(); ?>
												 </div>

												 <div class="info">
														<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
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
					<?php	break;
					case 3: ?>
						<div class="container">
							<div class="container_inner clearfix">
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
														<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
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
					<?php	break;
				} ?>
		<?php elseif(($sidebar == "1" || $sidebar == "2") &&  $qode_options_central['blog_style'] != "1"): ?>
			<div class="container">
				<div class="container_inner clearfix">
					<div class="<?php if($sidebar == "1"):?>two_columns_66_33<?php elseif($sidebar == "2") : ?>two_columns_75_25<?php endif; ?> background_color_sidebar grid2 clearfix">
						<div class="column1">
							<div class="column_inner">
								<div class="search_form">
									<form id="searchform" action="http://localhost/" method="get" role="search">
										<input id="s" type="text" name="s" value="<?php echo $s; ?>">
										<input id="searchsubmit" type="submit" value="Search">
										<div class="clearfix"></div>
									</form>
								</div>
								<?php switch ($qode_options_central['blog_style']) {
								case 1: ?>
									
								<?php	break;
								case 2: ?>
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
															<?php the_excerpt(); ?>
													 </div>

													 <div class="info">
															<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
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
									
								<?php	break;
								case 3: ?>
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
															<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
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
									
								<?php	break;
							}
							
							?>		
							</div>
						</div>
						<div class="column2">
						<?php get_sidebar(); ?>	
						</div>
					</div>
				</div>
			</div>
		<?php elseif(($sidebar == "3" || $sidebar == "4") &&  $qode_options_central['blog_style'] != "1"): ?>
			<div class="container">
				<div class="container_inner clearfix">
			<div class="<?php if($sidebar == "3"):?>two_columns_33_66<?php elseif($sidebar == "4") : ?>two_columns_25_75<?php endif; ?> background_color_sidebar grid2 clearfix">
						<div class="column1">
						<?php get_sidebar(); ?>	
						</div>
						<div class="column2">
							<div class="column_inner">
									<div class="search_form">
										<form id="searchform" action="http://localhost/" method="get" role="search">
											<input id="s" type="text" name="s" value="<?php echo $s; ?>">
											<input id="searchsubmit" type="submit" value="Search">
											<div class="clearfix"></div>
										</form>
									</div>
									<?php switch ($qode_options_central['blog_style']) {
									case 1: ?>
									 <?php	break;
									case 2: ?>
										
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
																<?php the_excerpt(); ?>
														 </div>

														 <div class="info">
																<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
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
									<?php	break;
									case 3: ?>
										
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
																<span class="left"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
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
									<?php	break;
							}
							
							?>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		<?php elseif(($sidebar == "1" || $sidebar == "2" || $sidebar == "3" || $sidebar == "4") &&  $qode_options_central['blog_style'] == "1"): ?>
			<div class="full_width">
				<div class="blog_holder clearfix">
					<div class="blog_holder_inner">
				
						<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
						<article <?php post_class('mix'); ?>>
							<?php if ( has_post_thumbnail() ) { ?>
							<div class="image">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail('blog-type-1'); ?>
								</a>
							</div>
							<?php } ?>
							<div class="blog_text_holder">
								 <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
								 <div class="text">
										<div class="text_inner">
											 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
											 <?php the_excerpt(); ?>
										</div>
								 </div>
								 <div class="info">
										<a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a>
								 </div>
							</div>
							</article>
						<?php endwhile; ?>
						<div class="filler"></div>
						<div class="filler"></div>
						<div class="filler"></div>
						<div class="filler"></div>
						<?php else: //If no posts are present ?>
							<div class="entry">                        
									<p><?php _e('No posts were found.', 'qode'); ?></p>    
							</div>
						<?php endif; ?>
						
					</div>
					<?php if($qode_options_central['pagination'] != "0") : ?>
					<?php pagination($wp_query->max_num_pages, $wp_query->max_num_pages, $paged); ?>
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div>
			</div>
		<?php endif; ?>
	
<?php get_footer(); ?>