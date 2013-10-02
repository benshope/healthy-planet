<?php
/*
Template Name: Blog
*/
if(!(int)$included)
{
?>
<?php get_header(); ?>
 <!-- Content -->
<div class="content">
	<div id="prestige">
		<!-- Previous arrow -->
		<!--<a href="#" id="prestige-navigation-prev"></a>
		<!-- /Previous arrow -->
		<!-- Menu -->
		<div class="prestige-scroll-menu">
			<?php
			$params = array();
			$result = prestige_get($params);
			?>
			<?php if($result["count"]>5):?>
			<a href="#" class="prestige-menu-goup prestige-hidden"></a>
			<?php endif; ?>
			<ul id="prestige-menu" style="top: 0px;">
				<?php
				echo $result["html"];
				?>
			</ul>
			<?php if($result["count"]>5):?>
			<a href="#" class="prestige-menu-godown"></a>
			<?php endif; ?>
		</div>
        <!-- /Menu -->
		<!-- Window -->
		<div id="prestige-window"> 
			<div class="prestige-border-top"></div>
			<!-- Background -->
			<?php
			}
			global $prestige_options;
			if((!$prestige_options["ajax"] || $prestige_options["animation"]=="swipe") && !(int)$included)
			{
			$pagesCount = count($result["pages"]);
			echo "<ul class='carousel'" . ($prestige_options["animation"]=="expand" ? " style='display: none;'" : "") . ">";
			for($i=0; $i<$pagesCount; $i++)
				echo $result["pages"][$i];
			echo "</ul>";
			}
			if(!(int)$included)
			{
			?>
			<div id="prestige-window-background">
				<!-- Scroll area -->
				<div id="prestige-window-scroll">
					<!-- Content -->
					<div id="prestige-window-content">
					<?php
					}
					?>
						<div class="layout-blog overflow-fix clear-fix">
							<ul class="no-list<?php if(is_active_sidebar('blog')): ?> layout-blog-left<?php endif; ?> overflow-fix clear-fix">
						<?php
						global $blog_page_id, $parent_url, $post;
						$blog_page_id = get_the_ID();

						$parent_url = $post->post_name;
						$post_categories = array_values(array_filter((array)get_post_meta(get_the_ID(), "prestige_blog_categories", true)));
						if(!count($post_categories))
							$post_categories = get_terms("category", "fields=ids");
						query_posts(array( 
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => 5,
							'cat' => ((int)$_GET["category_id"]>0 ? (int)$_GET["category_id"] : implode(",", $post_categories)),
							'paged' => (int)$_GET["paged"],
							'order' => 'ASC'
						));
						if(have_posts()) : while (have_posts()) : the_post();
						global $post;
						?>
								<li <?php post_class("prestige_post prestige_clearfix"); ?>>
									<div class="prestige_post_title_header_container prestige_clearfix">
										<h3 class="prestige_post_title_header">
											<a style="color:#000;" class="prestige_post_title link" href="<?php echo $parent_url; ?>/<?php echo $post->post_name; ?>" title="<?php the_title();?>">
												<?php the_title(); ?>
											</a>
										</h3>
										<div class="prestige_comments_number">
											<a class="link" href="<?php echo $parent_url; ?>/<?php echo $post->post_name; ?>#prestige_comments" title="<?php comments_number('0', '1', '%'); ?>"><?php comments_number('0', '1', '%'); ?></a>
											<span class="arrow_bottom_right"></span>
										</div>
									</div>
									<?php if(has_post_thumbnail()): ?>
									<a href="<?php echo $parent_url; ?>/<?php echo $post->post_name; ?>" title="" class="link prestige_post_thumb<?php if(!is_active_sidebar('blog')): ?> long<?php endif; ?>">
									<?php the_post_thumbnail((!is_active_sidebar('blog') ? "full-" : "") . "blog-post-thumb", array("alt" => get_the_title(), "title" => "")); ?>
									</a>
									<?php endif; ?>
									<ul class="prestige_post_details prestige_clearfix">
										<li class="prestige_post_date"><?php the_time('F j, Y');?><span class="arrow_bottom"></span></li>
										<li class="prestige_post_category">
											<?php
											$categories = get_the_category();
											foreach($categories as $key=>$category)
											{
												echo '<a class="link" href="' . $parent_url . '/category-' . $category->term_id . '/" ';
												if(empty($category->description))
													echo 'title="' . sprintf(__('View all posts filed under %s', 'prestige'), $category->name) . '"';
												else
													echo 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
												echo '>' .$category->name . '</a>';
											}
											?>
										</li>
									</ul>
									<div class="prestige_post_excerpt">
										<?php the_excerpt_rss(); ?>
									</div>
									<a class="link prestige_post_more" href="<?php echo $parent_url; ?>/<?php echo $post->post_name; ?>" title="<?php _e("Read more", 'prestige');?>">
										<?php _e("Read more", 'prestige');?>
									</a>
								</li>
						<?php
						endwhile; endif;
						require_once("pagination.php");
						kriesi_pagination('', 2, $parent_url);
						//Reset Query
						wp_reset_query();
						?>
							</ul>
							<?php //if(is_active_sidebar('blog')):?>
							<!--<div class="layout-blog-right">
							   <?php //get_sidebar('blog');?>    
							</div>-->
							<?php //endif; ?>
						</div>
					<?php
					if(!(int)$included)
					{?>
					</div>
					<!-- /Content -->
				</div>
				<!-- /Scroll area -->
			</div>
			<?php
					}
			if(!(int)$included)
			{
			?>
			<!-- /Background -->
		</div>
        <div style="margin-bottom:100px;"> </div>
		<!-- /Window -->
		<!-- Next arrow -->
		<!--<a href="#" id="prestige-navigation-next"></a>
		<!-- /Next arrow -->
	</div>
</div>
<!-- /Content -->
<?php get_footer();
}?>