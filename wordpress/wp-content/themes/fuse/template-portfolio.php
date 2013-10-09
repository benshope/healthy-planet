<?php 
/*
Template Name: Portfolio
*/
get_header();

if (have_posts()) : while (have_posts()) : the_post();

    global $post;
    global $wpGrade_Options;
    $html_title = $wpGrade_Options->get('portfolio_title');

    $header_height = absint($wpGrade_Options->get('nocontent_header_height'));
    $height = '';
    if ($header_height && empty($html_title)) {
        $height = 'data-height="'.$header_height.'"';
    }
	
    if ($wpGrade_Options->get('portfolio_header_image')) {
		$featured_id = wpgrade_get_attachment_id_from_src( $wpGrade_Options->get('portfolio_header_image' ) );
        $featured_image = wp_get_attachment_image_src($featured_id, 'full');
		if (empty($height) && empty($html_title)) {
            $height = 'data-width="'. $featured_image[1] .'" data-height="'. $featured_image[2] .'"';
        }
		?>
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
		<div class="wrapper-featured-image">
			<div class="featured-image-container" style="background-color: <?php echo get_post_meta(get_the_ID(), WPGRADE_PREFIX.'header_background_color', true); ?>">
				<div class="featured-image-container-wrapper content-bigger s-inverse">
					<div class="page-header-wrapper">
						<?php wpgrade_display_content($html_title ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="row">
		<div class="side block-color">
			<div class="block-inner block-inner-thin block-inner_first content-bigger arrow arrow-bottom">
            	<h3><?php echo $wpGrade_Options->get('portfolio_filter_text') ?></h3>
			</div>
		</div>
		<div class="main block-dark">
			<div class="block-inner block-middle block-inner_last" style="width:100%">
				<?php if ($wpGrade_Options->get('portfolio_ajax_loading_pagination')) { ?>
				<ul class="filter-by_list">
                    <li>
                        <a href="#" title="<?php _e('View all projects',wpGrade_txtd) ?>" data-filter="*"><?php _e('Show All', wpGrade_txtd); ?></a>
                    </li>
                    <?php $terms = get_terms(array('portfolio_cat'));

                    foreach ( $terms as $term ) { ?>
                        <li class="filter-by_list-item">
                            <a class="filter-by_link" href="#" title="<?php sprintf( __( "View all projects in %s" ,wpGrade_txtd ), $term->name ); ?>" data-filter="<?php echo $term->slug ?>"><?php echo $term->name ?></a>
                        </li>
                    <?php }?>
				</ul>
				<?php } else { ?>
				<ul class="portfolio_category_list">
                    <li>
                        <a href="<?php echo get_post_type_archive_link('portfolio') ?>" title="<?php _e('View all projects',wpGrade_txtd) ?>"><?php _e('View All', wpGrade_txtd); ?></a>
                    </li>
                    <?php $terms = get_terms(array('portfolio_cat'));

                    foreach ( $terms as $term ) { ?>
                        <li class="filter-by_list-item">
                            <a class="filter-by_link" href="<?php echo get_term_link($term) ?>" title="<?php sprintf( __( "View all projects in %s" ,wpGrade_txtd ), $term->name ); ?>"><?php echo $term->name ?></a>
                        </li>
                    <?php }?>
				</ul>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="portfolio-rows">
        <?php
	        $posts_nr = $wpGrade_Options->get('portfolio_archive_limit') ? absint($wpGrade_Options->get('portfolio_archive_limit')) : -1;
	        wpgrade_display_portfolio( $posts_nr, false, true, false); 
        ?>
	</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
