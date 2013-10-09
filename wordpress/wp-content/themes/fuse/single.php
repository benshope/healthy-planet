<?php get_header(); ?>
<?php global $wpGrade_Options; ?>

<?php if (have_posts()):
	
	while (have_posts()): the_post();
		$html_title = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'post_html_title', true);
		if (get_post_format() == 'gallery') { ?>
			<div class="wrapper-featured-image">
				<div class="featured-image-container" style="background-color: <?php echo get_post_meta(get_the_ID(), WPGRADE_PREFIX.'header_background_color', true); ?>;">
					<div class="featured-image-container-wrapper content-bigger s-inverse">
							<?php get_template_part( 'templates/post-templates/single-head', get_post_format() ); ?>
					</div>
				</div>
			</div>
		<?php
		} elseif (get_post_format() == 'image') {
			$featured_id = wpgrade_get_attachment_id_from_src(wpgrade_get_post_first_image());
			$featured_image = wp_get_attachment_image_src($featured_id, 'full');
			if (empty($height) && empty($html_title)) {
				$height = 'data-width="'. $featured_image[1] .'" data-height="'. $featured_image[2] .'"';
			} ?>
			<div class="wrapper-featured-image">
				<div class="parallax-container" <?php echo $height ?>>
					<div class="parallax-item">
						<?php echo '<img src="'.$featured_image[0].'" class="featured-image" data-imgwidth="'.$featured_image[1].'" data-imgheight="'.$featured_image[2].'">' ?>
					</div>				
				</div>

			</div>
		<?php
		} elseif (get_post_format() == 'video') { ?>
			<div class="wrapper-featured-image">
				<div class="featured-image-container" style="background-color: <?php echo get_post_meta(get_the_ID(), WPGRADE_PREFIX.'header_background_color', true); ?>;min-height: 500px;">
					<div class="featured-image-container-wrapper content-bigger s-inverse">
							<?php get_template_part( 'templates/post-templates/single-head', get_post_format() ); ?>
					</div>
				</div>
			</div>
		<?php } else {
			$header_height = absint($wpGrade_Options->get('nocontent_header_height'));
			$height = '';
			if ($header_height && empty($html_title) && get_post_format() == false) {
				$height = 'data-height="'.$header_height.'"';
			}

			if (has_post_thumbnail()) {
				$featured_id = get_post_thumbnail_id();
				$featured_image = wp_get_attachment_image_src($featured_id, 'full');
				if (empty($height) && empty($html_title)) {
					$height = 'data-width="'. $featured_image[1] .'" data-height="'. $featured_image[2] .'"';
				} ?>
				<div class="wrapper-featured-image">
					<div class="parallax-container" <?php echo $height ?>>
						<div class="parallax-item">
							<?php echo '<img src="'.$featured_image[0].'" class="featured-image" class="featured-image" data-imgwidth="'.$featured_image[1].'" data-imgheight="'.$featured_image[2].'">' ?>
						</div>				
					</div>
					<div class="page-header">
						<?php if (!empty($html_title) || get_post_format() != false) { ?>
							<?php get_template_part( 'templates/post-templates/single-head', get_post_format() ); ?>
						<?php } ?>
					</div>
				</div>
			<?php } elseif (!empty($html_title) || get_post_format() != false) { ?>
				<div class="wrapper-featured-image">
					<div class="featured-image-container" style="background-color: <?php echo get_post_meta(get_the_ID(), WPGRADE_PREFIX.'header_background_color', true); ?>">
						<div class="featured-image-container-wrapper content-bigger s-inverse">
							<div class="page-header-wrapper">
								<?php get_template_part( 'templates/post-templates/single-head', get_post_format() ); ?>
							</div>
						</div>
					</div>
				</div>
			<?php }
		} ?>
		<div class="row wrapper-content">
			<?php if ($wpGrade_Options->get('blog_single_template') == 'l-sidebar-left') : ?>
            <?php get_sidebar(); ?> 	
            <div class="main main-content" role="main">
                <div class="block-inner block-inner_first">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix content-wrap'); ?> role="article" itemscope itemtype="http://schema.org/Article">
                        <h1 class="entry-title single-title" itemprop="name"><?php echo get_the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        </div>
                        <?php get_template_part('templates/components/blog-single-author-box'); ?>
                        <footer class="post-links">
                            <div class="article-link-title"><?php _e("Share on:", wpGrade_txtd); ?></div>
                            <ul class="post-links_list">
                                <?php if ( $wpGrade_Options->get('blog_single_show_share_links') ): ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_twitter') ): ?>
                                    <li class="post-links_item"><a href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;source=tweetbutton&amp;text=<?php echo urlencode(get_the_title())?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;via=<?php echo $wpGrade_Options->get( 'twitter_card_site' ) ?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Twitter!', wpGrade_txtd) ?>">Twitter</a></li>
                                    <?php endif; ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_facebook') ): ?>
                                    <li class="post-links_item"><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Facebook!', wpGrade_txtd) ?>">Facebook</a></li>
                                    <?php endif; ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_googleplus') ): ?>
                                    <li class="post-links_item"><a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Google+!', wpGrade_txtd) ?>">Google+</a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li class="post-links_item to-top"><a href="#top" title="<?php _e("Jump to the top of the page", wpGrade_txtd); ?>"> &uarr; <?php _e("Back to top", wpGrade_txtd); ?></a></li>
                            </ul>
                        </footer>
                        <?php comments_template(); ?>
                    </article>
                </div>
            </div>		
			<?php else : ?>
            <div class="main main-content" role="main">
                <div class="block-inner block-inner_first">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix content-wrap'); ?> role="article" itemscope itemtype="http://schema.org/Article">
                        <h1 class="entry-title single-title" itemprop="name"><?php echo get_the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        </div>
                        <?php get_template_part('templates/components/blog-single-author-box'); ?>
                        <footer class="post-links">
                            <div class="article-link-title"><?php _e("Share on:", wpGrade_txtd); ?></div>
                            <ul class="post-links_list">
                                <?php if ( $wpGrade_Options->get('blog_single_show_share_links') ): ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_twitter') ): ?>
                                    <li class="post-links_item"><a href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;source=tweetbutton&amp;text=<?php echo urlencode(get_the_title())?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;via=<?php echo $wpGrade_Options->get( 'twitter_card_site' ) ?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Twitter!', wpGrade_txtd) ?>">Twitter</a></li>
                                    <?php endif; ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_facebook') ): ?>
                                    <li class="post-links_item"><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Facebook!', wpGrade_txtd) ?>">Facebook</a></li>
                                    <?php endif; ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_googleplus') ): ?>
                                    <li class="post-links_item"><a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Google+!', wpGrade_txtd) ?>">Google+</a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li class="post-links_item to-top"><a href="#top" title="<?php _e("Jump to the top of the page", wpGrade_txtd); ?>"> &uarr; <?php _e("Back to top", wpGrade_txtd); ?></a></li>
                            </ul>
                        </footer>
                        <?php comments_template(); ?>
                    </article>
                </div>
            </div>
            <?php get_sidebar(); ?> 
			<?php endif; ?>
		</div>
	<?php endwhile; 
else: ?>
	<div class="row">
		<div class="main main-content" role="main">
			<div class="block-inner block-inner_first">
				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h1><?php _e("Oops, Post Not Found!", wpGrade_txtd); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Try double checking things.", wpGrade_txtd); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e("This is the error message in the single.php template.", wpGrade_txtd); ?></p>
					</footer>
				</article>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>