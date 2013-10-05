<?php
/*
Template Name: Contact Page
*/
get_header();

if (have_posts()) : while (have_posts()) : the_post();

        global $post;
        // The user can choose to hide the wordpress title and put his own with visual editor
        $html_title = get_post_meta(get_the_ID(), WPGRADE_PREFIX.'page_html_title', true);

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
						<?php echo '<img src="'.$featured_image[0].'" class="featured-image" data-imgwidth="'.$featured_image[1].'" data-imgheight="'.$featured_image[2].'"/>' ?>
					</div>				
				</div>
				<div class="page-header content-bigger s-inverse">
					<?php if (!empty($html_title)) { ?>
						<?php wpgrade_display_content($html_title ); ?>
					<?php } ?>
				</div>
			</div>
		<?php } elseif (!empty($html_title)) { ?>
			<div class="wrapper-featured-image"  style="background-color: <?php echo get_post_meta(get_the_ID(), WPGRADE_PREFIX.'header_background_color', true); ?>">
				<div class="featured-image-container">
					<div class="featured-image-container-wrapper content-bigger s-inverse">
						<?php wpgrade_display_content($html_title ); ?>
					</div>				
				</div>
			</div>
		<?php } ?>
    <div class="row">
        <div class="block block1 block-light">
            <div class="block-inner block-inner_first headings-bigger content-bigger">
                <?php if($wpGrade_Options->get('contact_form_title')) 
                        { echo '<h2 itemprop="name">'.$wpGrade_Options->get('contact_form_title').'</h2>'; } 
                        else { ?>
                        <h2 itemprop="name"><?php echo get_the_title(); ?></h2>
                <?php } echo apply_filters('the_content', $wpGrade_Options->get('contact_content_left') ) ?>
            </div>
        </div>
        <div class="block block2">
            <div class="block-inner">
                <?php if ( $wpGrade_Options->get('contact_form_7') ) {
                    echo do_shortcode( '[contact-form-7 id="'.$wpGrade_Options->get('contact_form_7').'"]' );
                } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="block block1 block-color">
            <div class="block-inner block-inner_first content-bigger">
                <?php if($wpGrade_Options->get('contact_info_title')){ echo '<h2>'.$wpGrade_Options->get('contact_info_title').'</h2>'; } ?>
                <?php if($wpGrade_Options->get('contact_phone')){ echo '<p>'.$wpGrade_Options->get('contact_phone').'</p>'; } ?>
                <?php if($wpGrade_Options->get('contact_email')){ echo '<p>'.$wpGrade_Options->get('contact_email').'</p>'; } ?>
                <?php if($wpGrade_Options->get('contact_address')){ echo '<p>'.$wpGrade_Options->get('contact_address').'</p>'; } ?>
                <?php if($wpGrade_Options->get('contact_gmap_link')){ echo '<p><a target="_blank" href="'.$wpGrade_Options->get('contact_gmap_link').'">Get Directions &raquo;</a></p>'; } ?>
            </div>
        </div>
        <div class="block block2">
            <div id="gmap">
                    <div class="row contact-info-wrapper" data-gmap-url="<?php echo $wpGrade_Options->get('contact_gmap_link'); ?>" data-custom-style="<?php echo $wpGrade_Options->get('contact_gmap_custom_style'); ?>">
                        <div class="contact-info accent-background" >
                            <img src="<?php echo WPGRADE_LIB_URL ?>images/map_pin.png" />
                            <div class="pin_ring pin_1"></div>
                            <div class="pin_ring pin_2"></div>
                        </div>
                    </div>
                <div id="map_canvas" style="width: 100%; height: 100%"></div>
                <div class="container" style="display: none">
                    <div class="row contact-info-wrapper" data-gmap-url="<?php echo $wpGrade_Options->get('contact_gmap_link'); ?>" data-custom-style="<?php echo $wpGrade_Options->get('contact_gmap_custom_style'); ?>"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper the-content-contact">
        <div class="container">
            <?php the_content(); ?>
        </div>
    </div>

    <?php
//comments_template();
endwhile; endif;
get_footer(); ?>