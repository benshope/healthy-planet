<?php 
/*
Template Name: Home Page
*/
get_header();
    global $wpGrade_Options;
    if ( $wpGrade_Options->get('homepage_use_slider') ) {

		$hps_query = new WP_Query(array(
			'post_type' => 'homepage_slide',
			'posts_per_page' => '-1',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		));

	    $slider_params = '';
	    $slider_speed = $wpGrade_Options->get('homepage_slider_speed');
	    if ( $slider_speed ) {

		    $slider_params .= ' data-slideshow_speed="'. $slider_speed .'"';
		    echo '<style>';
		    // speed up cause of the animation
		    $slider_speed = $slider_speed - 500;
		    echo '  .nav-filler.s-loading {'.
			     '      -webkit-transition: all '. $slider_speed .'ms linear;'.
			     '      -moz-transition: all '. $slider_speed .'ms linear;'.
			     '      -o-transition: all '. $slider_speed .'ms linear;'.
			     '      transition: all '. $slider_speed .'ms linear; }'.
			     '  .nav-filler.s-fast, .nav-filler {'.
			     '      -webkit-transition: all 0s;'.
                 '      -moz-transition: all 0s;'.
                 '      -o-transition: all 0s;'.
                 '      transition: all 0s; };';
		    echo '</style>';
	    }

	    if ( $wpGrade_Options->get('homepage_slider_animation_speed') ) {
		    $slider_params .= ' data-animation_speed="'. $wpGrade_Options->get('homepage_slider_animation_speed') .'"';
	    }

	    if ( $wpGrade_Options->get('homepage_slider_fullscreen') ) {
		    $slider_params .= ' data-fullscreen="'. $wpGrade_Options->get('homepage_slider_fullscreen') .'"';
	    }

	    if ( $wpGrade_Options->get('homepage_slider_height') ) {
	    	$slider_params .= ' data-height="'. $wpGrade_Options->get('homepage_slider_height') .'"';	
	    }

	    if ( $wpGrade_Options->get('homepage_slider_directionnav') ) {
		    $slider_params .= ' data-direction_nav="true"';
	    } else{
		    $slider_params .= ' data-direction_nav="false"';
	    }

	    if ( $wpGrade_Options->get('homepage_slider_controlnav') ) {
		    $slider_params .= ' data-control_nav="true"';
	    } else{
		    $slider_params .= ' data-control_nav="false"';
	    }

		$slider_control_nav_items = '';
		$slide_number = 0;
		if ($hps_query->have_posts()): ?>
			<div class="homepage-slider flexslider loading" <?php if (!empty($slider_params)) { echo $slider_params;} ?>>
				<div class="nav-filler"></div>
				<div class="preloader"></div>
				<ul class="slides homepage-slider_slides">
					<?php while ($hps_query->have_posts()) : $hps_query->the_post(); ?>
						<li class="slide homepage-slider_slide s-hidden">
							<?php
							    $image = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'homepage_slide_image', true);
								
								if (!empty($image)) {
                  $image = json_decode($image);
                  $image_id = $image->id;
                  $image = wp_get_attachment_image_src( $image_id, 'blog-huge', false);
									echo '<img class="homepage-slider_image" src="'.$image[0].'"/>';
								}
							?>
							<div class="homepage-slider_slide-wrap">
								<?php $slider_control_nav_items[$slide_number] = get_the_title();
								$slide_number++;
								$slide_has_video = false;
								$the_video = '';
								
								//get the ratio
								$video_width = absint(get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_width', true));
								if (empty($video_width) || $video_width == 0) {
									$video_width = 500;
								}
								$video_height = absint(get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_height', true));
								if (empty($video_height) || $video_height == 0) {
									$video_height = 281;
								}
								$video_ratio = $video_width / $video_height;
								
								$videos = wpgrade_post_videos_ids(get_the_ID());
								
								isset( $videos['youtube'] ) ?  $youtube_id = $videos['youtube'] : $youtube_id = '';
								isset( $videos['vimeo'] ) ? $vimeo_id = $videos['vimeo'] : $vimeo_id = '';
								
								if ( !empty($youtube_id) ) {
									$the_video = '<div class="youtube_frame" id="ytplayer_'.get_the_ID().'" data-ytid="'.$youtube_id.'"></div>';
									$slide_has_video = true;
								} elseif ( !empty($vimeo_id) ) {
									$the_video = '<iframe class="vimeo_frame" width="500" height="'.intval(500 / $video_ratio).'" id="video_'.get_the_ID().'" src="http://player.vimeo.com/video/'.$vimeo_id.'?api=1&player_id=video_'.get_the_ID().'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
									$slide_has_video = true;
								} elseif( !empty( $video_embed ) ) {
									$slide_has_video = true;
									$the_video = '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($video_embed)) . '</div>';
								} else {
									$video_m4v = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_m4v', true);
									$video_webm = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_webm', true);
									$video_ogv = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_ogv', true);
									$video_poster = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'video_poster', true);
								
									if ( !empty($video_m4v) || !empty($video_webm) || !empty($video_ogv) || !empty($video_poster) ) {
										$slide_has_video = true;
										ob_start();
										wpGrade_video_selfhosted(get_the_ID());
										$the_video = ob_get_clean();
									}
								} ?>
								<div class="homepage-slider_slide-content <?php if ( $slide_has_video ) echo 's-video'?>">
									<div class="slide-content-wrapper">
										<?php
											if ( $slide_has_video ) {
												echo '<div class="page-header-video-wrap video-wrap">'.$the_video.'</div>';
												echo '<div class="page-header-videohtml-wrap">';
											}
											$caption = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'homepage_slide_caption', true);
								
											if (!empty($caption))
												wpgrade_display_content($caption);
								
											$label = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'homepage_slide_label', true);
											$link = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'homepage_slide_link', true);
											if (!empty($label) && !empty($link)) {
												echo '<div><a href="'.$link.'" class="btn btn-slider">'.$label.'</a></div>';
											}
											if ( $slide_has_video ) {
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
        <?php endif; wp_reset_query();
    }?>

    <div class="wrapper wrapper-body">
	    <div class="container container-body">
	         <?php wpgrade_display_content($wpGrade_Options->get('homepage_content1')); ?>
	    </div>
    </div>

    <?php if ( $wpGrade_Options->get('homepage_use_portfolio') ) { ?>
        <div class="featuredworks-header row">
            <div class="main main-featuredworks block-darkest">
                <div class="block-inner block-inner_first">
                    <h2 class="featuredworks-title"><?php echo $wpGrade_Options->get('homepage_portfolio_title'); ?></h2>
                </div>
            </div>
            <div class="side side-featuredworks">
                <div class="block-inner block-inner_last block-middle">
                    <a href="<?php echo get_portfolio_page_link() ?>" title=""><?php echo $wpGrade_Options->get('homepage_portfolio_more'); ?></a>
                </div>
            </div>
        </div>
        <div class="portfolio-rows">
            <?php
            $wpGrade_Options->get('homepage_portfolio_limit') ? $projects_nr = $wpGrade_Options->get('homepage_portfolio_limit') : $projects_nr = 3;
            wpgrade_display_portfolio( $projects_nr, true, true); ?>
        </div>
    <?php }

	if ( $wpGrade_Options->get('homepage_display_latest_posts') ) { ?>

		<div class="featuredworks-header row">
			<div class="main main-featuredworks block-darkest">
				<div class="block-inner block-inner_first">
					<h2 class="featuredworks-title"><?php echo $wpGrade_Options->get('homepage_latest_posts_title'); ?></h2>
				</div>
			</div>
			<div class="side side-featuredworks">
				<div class="block-inner block-inner_last block-middle">
					<a href="<?php echo get_page_link(get_option( 'page_for_posts' ) ); ?>" title=""><?php echo $wpGrade_Options->get('homepage_more_latest_posts'); ?></a>
				</div>
			</div>
		</div>

		<div class="portfolio-rows">
			<?php
			$posts_count = $wpGrade_Options->get('homepage_latest_posts_limit') ? $wpGrade_Options->get('homepage_latest_posts_limit') : 3;
			$latest_posts_args = array('posts_per_page' => $posts_count);
			$latest_posts = get_posts($latest_posts_args);
			$latest_posts_layout = $wpGrade_Options->get('homepage_latest_posts_layout');
			if (!empty($latest_posts)):
				wpgrade_homepage_latest_posts($latest_posts_layout, $latest_posts);
			endif; ?>
		</div>

	<?php } ?>

    <div class="wrapper wrapper-body">
	    <div class="container container-body">
            <?php wpgrade_display_content($wpGrade_Options->get('homepage_content2')); ?>
    	</div>
    </div>

<?php get_footer(); ?>