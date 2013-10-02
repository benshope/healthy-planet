<?php
setPostViews(get_the_ID());
?>
<div class="layout-blog overflow-fix clear-fix">
	<div <?php if(is_active_sidebar('blog')): ?> class="layout-blog-left" <?php endif; ?>>
		<?php 
		if($parent)
		{	
			global $parent_url;
			$parent_url = $parent->post_name;
		?>
		<ul class="prestige_bread_crum prestige_clearfix">
			<li>
				<a class="link" href="<?php echo $parent_url;?>" title="<?php echo $parent->post_title;?>"><?php echo $parent->post_title;?></a>
			</li>
			<li class="prestige_separator">&nbsp;</li>
			<li>
				<span><?php the_title();?></span>
			</li>
			<li class="prestige_comments_number">
				<a class="link" href="<?php echo $parent_url; ?>/<?php global $post; echo $post->post_name;?>#prestige_comments" title="<?php comments_number('0', '1', '%'); ?>"><?php comments_number('0', '1', '%'); ?></a>
				<span class="arrow_bottom_right"></span>
			</li>
		</ul>
		<?php
		}
		if(has_post_thumbnail()):
			$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "large");
		?>
		<div class="fancybox-image">
			<a href="<?php echo $attachment_image[0]; ?>" title="" class="prestige_post_thumb<?php if(!is_active_sidebar('blog')): ?> long<?php endif; ?>">
				<?php the_post_thumbnail((!is_active_sidebar('blog') ? "full-" : "") . "blog-post-thumb", array("alt" => get_the_title(), "title" => "")); ?>
			</a>
		</div>
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
		<div class="prestige_post_content">
			<?php the_content(); ?>
		</div>
		<?php
		if(comments_open()):
		?>
		<div id="prestige_comments">
		<?php
		comments_template();
		?>
		</div>
		<?php
		require_once("comments-form.php");
		endif; ?>
	</div>
	<?php if(is_active_sidebar('blog')):?>
	<div class="layout-blog-right">
	   <?php get_sidebar('blog');?>    
	</div>
	<?php endif; ?>
</div>