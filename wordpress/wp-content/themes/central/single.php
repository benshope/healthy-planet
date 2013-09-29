<?php

if(get_post_meta(get_the_ID(), "qode_show-sidebar", true) != ""){
	$sidebar = get_post_meta(get_the_ID(), "qode_show-sidebar", true);
}else{
	$sidebar = $qode_options_central['blog_single_sidebar'];
}

$blog_hide_comments = "";
if (isset($qode_options_central['blog_hide_comments'])) 
	$blog_hide_comments = $qode_options_central['blog_hide_comments'];
	
if(get_post_meta(get_the_ID(), "qode_responsive-title-image", true) != ""){
 $responsive_title_image = get_post_meta(get_the_ID(), "qode_responsive-title-image", true);
}else{
	$responsive_title_image = $qode_options_central['responsive_title_image'];
}

if(get_post_meta(get_the_ID(), "qode_fixed-title-image", true) != ""){
 $fixed_title_image = get_post_meta(get_the_ID(), "qode_fixed-title-image", true);
}else{
	$fixed_title_image = $qode_options_central['fixed_title_image'];
}

if(get_post_meta(get_the_ID(), "qode_title-image", true) != ""){
 $title_image = get_post_meta(get_the_ID(), "qode_title-image", true);
}else{
	$title_image = $qode_options_central['title_image'];
}

if(get_post_meta(get_the_ID(), "qode_title-height", true) != ""){
 $title_height = get_post_meta(get_the_ID(), "qode_title-height", true);
}else{
	$title_height = $qode_options_central['title_height'];
}

$title_in_grid = false;
if(isset($qode_options_central['title_in_grid'])){
if ($qode_options_central['title_in_grid'] == "yes") $title_in_grid = true;
}

if(isset($qode_options_central['twitter_via']) && !empty($qode_options_central['twitter_via'])) {
	$twitter_via = " via " . $qode_options_central['twitter_via'];
} else {
	$twitter_via = 	"";
}

?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
				<?php if(!get_post_meta(get_the_ID(), "qode_show-page-title", true)) { ?>
					<div class="title <?php if($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "yes"){ echo 'has_fixed_background '; } if($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "no"){ echo 'has_background'; } if($responsive_title_image == 'yes'){ echo 'with_image'; } ?>" <?php if($responsive_title_image == 'no' && $title_image != ""){ echo 'style="background-image:url('.$title_image.'); height:'.$title_height.'px;"'; }?>>
						<?php if($responsive_title_image == 'yes' && $title_image != ""){ echo '<img src="'.$title_image.'" alt="title" />'; } ?>
						<?php if($title_in_grid){ ?>
						<div class="container">
							<div class="container_inner clearfix">
						<?php } ?>
						<h1>
							<?php if(get_post_meta(get_the_ID(), "qode_page-title-text", true) != ""){ ?>
								<?php echo get_post_meta(get_the_ID(), "qode_page-title-text", true) ?>
							<?php } else { ?>
								<?php _e('BLOG','qode'); ?>
							<?php } ?>
						</h1>
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
					$revslider = get_post_meta(get_the_ID(), "qode_revolution-slider", true);
					if (!empty($revslider)){
						echo do_shortcode($revslider);
					}
				?>
				<div class="container">
					<div class="container_inner clearfix">
					<?php if(($sidebar == "default")||($sidebar == "")) : ?>
						<div class="blog_single_holder">	
							<article>
							
								<div class="blog_title_holder">
									 <h2><?php the_title(); ?></h2>
									 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
								</div>

								<?php if(get_post_meta(get_the_ID(), "qode_use-slider-instead-of-image", true) == "yes") { ?>	
									<div class="image">
										<?php echo slider_blog(get_the_ID());?>	
									</div>
								<?php } else {
									if(get_post_meta(get_the_ID(), "qode_hide-featured-image", true) != "yes") {
										if ( has_post_thumbnail()) { ?>
											<div class="image">		
											<?php the_post_thumbnail('full'); ?>
											</div>
									<?php }
									}
									?>
								
								<?php	} ?>

								<div class="blog_single_text_holder">
									 <div class="text">
												<?php the_content(); ?>
												<?php if(isset($qode_options_central['enable_social_share']) && $qode_options_central['enable_social_share'] == "yes") { 
													$post_type = get_post_type();
													if(isset($qode_options_central["post_types_names_$post_type"])) {
														if($qode_options_central["post_types_names_$post_type"] == $post_type) { ?>
															<div class="social-share">
																<ul>
																	<?php if(isset($qode_options_central['enable_facebook_share']) &&  $qode_options_central['enable_facebook_share'] == "yes") { ?>
																		<li>
																			<a href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo get_the_title(); ?>&amp;p[summary]=<?php echo htmlspecialchars(get_the_excerpt()); ?>&amp;p[url]=<?php echo urlencode(get_permalink()); ?>&amp;&p[images][0]=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)">
																				<?php if(!empty($qode_options_central['facebook_icon'])) { ?>
																					<img src="<?php echo $qode_options_central['facebook_icon']; ?>" />
																				<?php } else { ?>
																					<img src="<?php echo get_template_directory_uri(); ?>/img/icon_facebook_like.png" title="" alt="" />
																				<?php } ?>
																				<span><?php _e('Share','qode'); ?></span>
																			</a>
																		</li>
																	<?php } ?>
																	<?php if(isset($qode_options_central['enable_twitter_share']) && $qode_options_central['enable_twitter_share'] == "yes") { ?>
																		<li>
																			<a href="#" onclick="popUp=window.open('http://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(the_excerpt_max_charlength(mb_strlen(get_permalink())) . $twitter_via); ?>&count=horiztonal', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;" target="_blank" rel="nofollow">
																				<?php if(!empty($qode_options_central['twitter_icon'])) { ?>
																					<img src="<?php echo $qode_options_central['twitter_icon']; ?>" />
																				<?php } else { ?>
																					<img src="<?php echo get_template_directory_uri(); ?>/img/icon_tweet.png" title="" alt="" />
																				<?php } ?>
																				<span><?php _e('Tweet','qode'); ?></span>
																			</a>
																		</li>
																	<?php } ?>
																	<?php if(isset($qode_options_central['enable_google_plus']) && $qode_options_central['enable_google_plus'] == "yes") { ?>
																		<li>
																			<a href="#" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false">
																				<?php if(!empty($qode_options_central['google_plus_icon'])) { ?>
																					<img src="<?php echo $qode_options_central['google_plus_icon']; ?>" />
																				<?php } else { ?>
																					<img src="<?php echo get_template_directory_uri(); ?>/img/icon_g_plus.png" title="" alt="" />
																				<?php } ?>
																				<span><?php _e('Share','qode'); ?></span>
																			</a>
																		</li>
																	<?php } ?>
																</ul>
															</div>
												<?php } }  } ?>
												
												<?php wp_link_pages(); ?>
									 </div>

									 <div class="info">
											<?php if( has_tag()) { ?>
											<span class="left"><?php the_tags(__('TAGS > ','qode')); ?></span>
											<?php } ?>
											
											<?php if($blog_hide_comments != "yes"){ ?>
												<span class="right"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
											<?php } ?>
									 </div>
								</div>
							</article>
						</div>
						
						<?php
							if($blog_hide_comments != "yes"){
								comments_template('', true); 
							}else{
								echo "<br/><br/>";
							}
						?> 
						
					<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
						<?php if($sidebar == "1") : ?>	
							<div class="two_columns_66_33 background_color_sidebar grid2 clearfix">
							<div class="column1">
						<?php elseif($sidebar == "2") : ?>	
							<div class="two_columns_75_25 background_color_sidebar grid2 clearfix">
								<div class="column1">
						<?php endif; ?>
					
									<div class="column_inner">
										<div class="blog_single_holder">	
											<article>
											
												<div class="blog_title_holder">
													 <h2><?php the_title(); ?></h2>
													 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
												</div>

												<?php if(get_post_meta(get_the_ID(), "qode_use-slider-instead-of-image", true) == "yes") { ?>	
													<div class="image">
														<?php echo slider_blog(get_the_ID());?>	
													</div>
												<?php } else {
													if(get_post_meta(get_the_ID(), "qode_hide-featured-image", true) != "yes") {
														if ( has_post_thumbnail()) { ?>
															<div class="image">		
															<?php the_post_thumbnail('full'); ?>
															</div>
													<?php }
													}
													?>
												
												<?php	} ?>

												<div class="blog_single_text_holder">
													 <div class="text">
																<?php the_content(); ?>
																
																<?php if(isset($qode_options_central['enable_social_share']) && $qode_options_central['enable_social_share'] == "yes") { 
																	$post_type = get_post_type();
																	if(isset($qode_options_central["post_types_names_$post_type"])) {
																		if($qode_options_central["post_types_names_$post_type"] == $post_type) { ?>
																			<div class="social-share">
																				<ul>
																					<?php if(isset($qode_options_central['enable_facebook_share']) &&  $qode_options_central['enable_facebook_share'] == "yes") { ?>
																						<li>
																							<a href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo get_the_title(); ?>&amp;p[summary]=<?php echo htmlspecialchars(get_the_excerpt()); ?>&amp;p[url]=<?php echo urlencode(get_permalink()); ?>&amp;&p[images][0]=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)">
																								<?php if(!empty($qode_options_central['facebook_icon'])) { ?>
																									<img src="<?php echo $qode_options_central['facebook_icon']; ?>" />
																								<?php } else { ?>
																									<img src="<?php echo get_template_directory_uri(); ?>/img/icon_facebook_like.png" title="" alt="" />
																								<?php } ?>
																								<span><?php _e('Share','qode'); ?></span>
																							</a>
																						</li>
																					<?php } ?>
																					<?php if(isset($qode_options_central['enable_twitter_share']) && $qode_options_central['enable_twitter_share'] == "yes") { ?>
																						<li>
																							<a href="#" onclick="popUp=window.open('http://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(the_excerpt_max_charlength(mb_strlen(get_permalink())) . $twitter_via); ?>&count=horiztonal', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;" target="_blank" rel="nofollow">
																								<?php if(!empty($qode_options_central['twitter_icon'])) { ?>
																									<img src="<?php echo $qode_options_central['twitter_icon']; ?>" />
																								<?php } else { ?>
																									<img src="<?php echo get_template_directory_uri(); ?>/img/icon_tweet.png" title="" alt="" />
																								<?php } ?>
																								<span><?php _e('Tweet','qode'); ?></span>
																							</a>
																						</li>
																					<?php } ?>
																					<?php if(isset($qode_options_central['enable_google_plus']) && $qode_options_central['enable_google_plus'] == "yes") { ?>
																						<li>
																							<a href="#" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false">
																								<?php if(!empty($qode_options_central['google_plus_icon'])) { ?>
																									<img src="<?php echo $qode_options_central['google_plus_icon']; ?>" />
																								<?php } else { ?>
																									<img src="<?php echo get_template_directory_uri(); ?>/img/icon_g_plus.png" title="" alt="" />
																								<?php } ?>
																								<span><?php _e('Share','qode'); ?></span>
																							</a>
																						</li>
																					<?php } ?>
																				</ul>
																			</div>
																<?php } }  } ?>
																
																<?php wp_link_pages(); ?>
													 </div>

													 <div class="info">
															<?php if( has_tag()) { ?>
															<span class="left"><?php the_tags(__('TAGS > ','qode')); ?></span>
															<?php } ?>
															
															<?php if($blog_hide_comments != "yes"){ ?>
																<span class="right"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
															<?php } ?>
													 </div>
												</div>
											</article>
										</div>
										
										<?php
											if($blog_hide_comments != "yes"){
												comments_template('', true); 
											}else{
												echo "<br/><br/>";
											}
										?> 
									</div>
								</div>	
								<div class="column2"> 
									<?php get_sidebar(); ?>
								</div>
							</div>
						<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
							<?php if($sidebar == "3") : ?>	
								<div class="two_columns_33_66 background_color_sidebar grid2 clearfix">
								<div class="column1"> 
									<?php get_sidebar(); ?>
								</div>
								<div class="column2">
							<?php elseif($sidebar == "4") : ?>	
								<div class="two_columns_25_75 background_color_sidebar grid2 clearfix">
									<div class="column1"> 
										<?php get_sidebar(); ?>
									</div>
									<div class="column2">
							<?php endif; ?>
							
										<div class="column_inner">
											<div class="blog_single_holder">	
												<article>
												
													<div class="blog_title_holder">
														 <h2><?php the_title(); ?></h2>
														 <span><?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?>, <?php _e('Posted by','qode'); ?> <span class="blog_author"><?php the_author(); ?></span> <?php _e('in','qode'); ?> <?php the_category(', '); ?></span>
													</div>

													<?php if(get_post_meta(get_the_ID(), "qode_use-slider-instead-of-image", true) == "yes") { ?>	
														<div class="image">
															<?php echo slider_blog(get_the_ID());?>	
														</div>
													<?php } else {
														if(get_post_meta(get_the_ID(), "qode_hide-featured-image", true) != "yes") {
															if ( has_post_thumbnail()) { ?>
																<div class="image">		
																<?php the_post_thumbnail('full'); ?>
																</div>
														<?php }
														}
														?>
													
													<?php	} ?>

													<div class="blog_single_text_holder">
														 <div class="text">
																	<?php the_content(); ?>
																	<?php if(isset($qode_options_central['enable_social_share']) && $qode_options_central['enable_social_share'] == "yes") { 
																		$post_type = get_post_type();
																		if(isset($qode_options_central["post_types_names_$post_type"])) {
																			if($qode_options_central["post_types_names_$post_type"] == $post_type) { ?>
																				<div class="social-share">
																					<ul>
																						<?php if(isset($qode_options_central['enable_facebook_share']) &&  $qode_options_central['enable_facebook_share'] == "yes") { ?>
																							<li>
																								<a href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo get_the_title(); ?>&amp;p[summary]=<?php echo htmlspecialchars(get_the_excerpt()); ?>&amp;p[url]=<?php echo urlencode(get_permalink()); ?>&amp;&p[images][0]=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)">
																									<?php if(!empty($qode_options_central['facebook_icon'])) { ?>
																										<img src="<?php echo $qode_options_central['facebook_icon']; ?>" />
																									<?php } else { ?>
																										<img src="<?php echo get_template_directory_uri(); ?>/img/icon_facebook_like.png" title="" alt="" />
																									<?php } ?>
																									<span><?php _e('Share','qode'); ?></span>
																								</a>
																							</li>
																						<?php } ?>
																						<?php if(isset($qode_options_central['enable_twitter_share']) && $qode_options_central['enable_twitter_share'] == "yes") { ?>
																							<li>
																								<a href="#" onclick="popUp=window.open('http://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(the_excerpt_max_charlength(mb_strlen(get_permalink())) . $twitter_via); ?>&count=horiztonal', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;" target="_blank" rel="nofollow">
																									<?php if(!empty($qode_options_central['twitter_icon'])) { ?>
																										<img src="<?php echo $qode_options_central['twitter_icon']; ?>" />
																									<?php } else { ?>
																										<img src="<?php echo get_template_directory_uri(); ?>/img/icon_tweet.png" title="" alt="" />
																									<?php } ?>
																									<span><?php _e('Tweet','qode'); ?></span>
																								</a>
																							</li>
																						<?php } ?>
																						<?php if(isset($qode_options_central['enable_google_plus']) && $qode_options_central['enable_google_plus'] == "yes") { ?>
																							<li>
																								<a href="#" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false">
																									<?php if(!empty($qode_options_central['google_plus_icon'])) { ?>
																										<img src="<?php echo $qode_options_central['google_plus_icon']; ?>" />
																									<?php } else { ?>
																										<img src="<?php echo get_template_directory_uri(); ?>/img/icon_g_plus.png" title="" alt="" />
																									<?php } ?>
																									<span><?php _e('Share','qode'); ?></span>
																								</a>
																							</li>
																						<?php } ?>
																					</ul>
																				</div>
																	<?php } }  } ?>
																	
																	<?php wp_link_pages(); ?>
														 </div>

														 <div class="info">
																<?php if( has_tag()) { ?>
																<span class="left"><?php the_tags(__('TAGS > ','qode')); ?></span>
																<?php } ?>
																
																<?php if($blog_hide_comments != "yes"){ ?>
																	<span class="right"><a href="<?php comments_link(); ?>"><?php comments_number( __('NO COMMENT','qode'), '1 '.__('COMMENT','qode'), '% '.__('COMMENTS','qode') ); ?></a></span>
																<?php } ?>
														 </div>
													</div>
												</article>
											</div>
											
											<?php
												if($blog_hide_comments != "yes"){
													comments_template('', true); 
												}else{
													echo "<br/><br/>";
												}
											?> 
										</div>
									</div>	
									
								</div>
						<?php endif; ?>
				</div>
			</div>						
<?php endwhile; ?>
<?php endif; ?>	


<?php get_footer(); ?>	