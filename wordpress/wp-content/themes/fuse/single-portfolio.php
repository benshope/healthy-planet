<?php get_header(); ?>
    <?php
		global $wpGrade_Options;
		
		if (have_posts()) : while (have_posts()) : the_post();
			
			$html_title = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'project_html_title', true);
			$header_height = absint($wpGrade_Options->get('nocontent_header_height'));
			$height = '';
			if ($header_height && empty($html_title)) {
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
							<?php echo '<img src="'.$featured_image[0].'" class="featured-image" data-imgwidth="'.$featured_image[1].'" data-imgheight="'.$featured_image[2].'">' ?>
						</div>				
					</div>
					<div class="page-header content-bigger s-inverse">
		                <?php if (!empty($html_title)) { ?>
		                    <?php wpgrade_display_content($html_title ); ?>
		                <?php } ?>
		            </div>
				</div>
			<?php } elseif (!empty($html_title)) { ?>
				<div class="wrapper-featured-image">
					<div class="featured-image-container" style="background-color: <?php echo get_post_meta(get_the_ID(), WPGRADE_PREFIX.'header_background_color', true); ?>">
						<div class="featured-image-container-wrapper content-bigger s-inverse">
							<div class="page-header-wrapper">
								<?php wpgrade_display_content($html_title ); ?>
							</div>
						</div>
					</div>
				</div>
			<?php }
			
			$rows = get_post_meta( get_the_ID(), WPGRADE_PREFIX .'portfolio_rows', true);
			$rows = json_decode($rows);
			$is_first = 1;
			if (count($rows)): ?>
				<div class="portfolio-rows">
					<?php foreach ($rows as $key => $row): ?>
						<div class="portfolio-row row">
							<?php wpgrade_get_portfolio_row( (array)$row, $is_first); ?>
						</div>
					<?php $is_first = 0; endforeach ?>
				</div>
			<?php endif;?>
            <?php the_content(); ?>
            
            <div class="block-inner block-inner_first block-inner_last portfolio-navigation block-white">
                <?php previous_post_link('<div class="previous-project-link">%link</div>',  __('Previous', wpGrade_txtd)); ?>
                <?php next_post_link('<div class="next-project-link">%link</div>',  __('Next', wpGrade_txtd)); ?>
            </div>
        <?php //comments_template();
    endwhile; endif; ?>
<?php get_footer(); ?>