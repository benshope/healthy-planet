<?php
/**
 * The template for displaying Archive Portfolio pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */
get_header();

if (have_posts()) : 

    global $post;
    global $wpGrade_Options;

    if ( $wpGrade_Options->get('portfolio_header_image' ) ) :
        $featured_id = wpgrade_get_attachment_id_from_src( $wpGrade_Options->get('portfolio_header_image' ) );
        $featured_image = wp_get_attachment_image_src($featured_id, 'full'); ?>
		<div class="wrapper-featured-image">
			<div class="parallax-container" <?php echo 'data-width="'.$featured_image[1].'" data-height="'.$featured_image[2].'"'?>>
				<?php echo '<img src="'.$featured_image[0].'" class="featured-image parallax-item">' ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="side block-color">
			<div class="block-inner_first content-bigger arrow arrow-bottom">
            	<h3><?php echo $wpGrade_Options->get('portfolio_filter_text') ?></h3>
			</div>
		</div>
		<div class="main block-dark">
			<div class="block-inner block-middle block-inner_last">
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
	        wpgrade_display_portfolio( $posts_nr, false, true, false );
			wp_reset_postdata();
        ?>
	</div>
<?php endif; ?>
<?php get_footer(); ?>