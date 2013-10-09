<?php global $wpGrade_Options; ?>
<div class="post-footer">
	<?php if ( $wpGrade_Options->get('blog_single_show_author') ) { ?>
	<aside class="authorbox" itemscope itemtype="http://schema.org/Person">
		<div class="authorbox-avatar">
			<?php if (function_exists('get_gravatar_url')):
				echo '<img src="'. get_gravatar_url(get_the_author_meta('email'), '240') . '" itemprop="image"/>';
			elseif (function_exists('get_avatar')):
				echo get_avatar(get_the_author_meta('email'), '240');
			endif; ?>
		</div>
		<div class="authorbox-info">
			<h4 class="authorbox-title"><span itemprop="name"><?php the_author_posts_link(); ?></span></h4>
			<p class="authorbox-bio" itemprop="description"><?php the_author_meta('description'); ?></p>
			<div class="authorbox-footer">
				<ul class="team-member-social-links">
					<?php if ( get_the_author_meta('user_tw') ): ?>
					<li class="team-member-social-link"><a class="social-link" href="https://twitter.com/<?php echo get_the_author_meta('user_tw') ?>" target="_blank"><i class="icon-twitter"></i></a></li>
					<?php endif; ?>
					<?php if ( get_the_author_meta('user_fb') ): ?>
					<li class="team-member-social-link"><a class="social-link" href="https://www.facebook.com/<?php echo get_the_author_meta('user_fb') ?>" target="_blank"><i class="icon-facebook"></i></a></li>
					<?php endif; ?>
					<?php if ( get_the_author_meta('google_profile') ): ?>
					<li class="team-member-social-link"><a class="social-link" href="<?php echo get_the_author_meta('google_profile') ?>" target="_blank"><i class="icon-google-plus"></i></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</aside>
	<?php } ?>
	<footer class="post-footer_meta">
		<div class="post-footer_meta-group">
			<h5 class="post-footer_meta-name"><?php echo __('Published', wpGrade_txtd); ?></h5>
			<div class="post-footer_meta-value">
				<?php wpgrade_posted_on(); ?>
			</div>
		</div>
		<div class="post-footer_meta-group">
			<h5 class="post-footer_meta-name"><?php echo __('Categories', wpGrade_txtd); ?></h5>
			<div class="post-footer_meta-value">
				<?php
					$categories = get_the_category();
					$separator = ', ';
					$output = '';
					if ($categories):
						foreach($categories as $category):
							$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", wpGrade_txtd ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
						endforeach;
						echo trim($output, $separator);
					endif;
				?>
			</div>
		</div>
		<div class="post-footer_meta-group">
			<h5 class="post-footer_meta-name"><?php echo __('Tags', wpGrade_txtd); ?></h5>
			<div class="post-footer_meta-value">
				<?php
					$tags = get_the_tags();
					$separator = ', ';
					$output = '';
					if ($tags):
						foreach($tags as $tag):
							$output .= '<a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", wpGrade_txtd ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator;
						endforeach;
						echo trim($output, $separator);
					endif;
				?>
			</div>
		</div>
	</footer>
</div>