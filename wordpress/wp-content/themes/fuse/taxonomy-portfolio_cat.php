<?php
/**
 * The template for displaying Archive Portfolio Categories.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */

get_header();

global $wpGrade_Options;

$cat_param = get_query_var('portfolio_cat');

if ( $wpGrade_Options->get('portfolio_header_image' ) ) :
	$header_height = absint($wpGrade_Options->get('nocontent_header_height'));
	$height = ''; 
    $featured_id = wpgrade_get_attachment_id_from_src( $wpGrade_Options->get('portfolio_header_image' ) );
    $featured_image = wp_get_attachment_image_src($featured_id, 'full');
	//we force the header height setting since there is no content in the header
	if ($header_height) {
		$height = 'data-height="'.$header_height.'"';
	} else {
		$height = 'data-width="'.$featured_image[1].'" data-height="'.$featured_image[2].'"';
	}
	?>
    <div class="wrapper-featured-image">
        <div class="parallax-container" <?php echo $height?>>
            <?php echo '<img src="'.$featured_image[0].'" class="featured-image parallax-item" data-imgwidth="'.$featured_image[1].'" data-imgheight="'.$featured_image[2].'">' ?>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="side block-color">
		<?php
		$cat_data = get_term_by('slug', $cat_param, 'portfolio_cat');
		
		if ( $wpGrade_Options->get('portfolio_category_description' ) && !empty($cat_data->description) ): ?>
        <div class="block-inner block-inner_first content-bigger arrow arrow-bottom">
            <h3><?php echo $cat_data->name ?></h3>
			<p class="cat-description"><?php echo $cat_data->description ?></p>
        </div>
		<?php else: ?>
		<div class="block-inner_first content-bigger arrow arrow-bottom">
            <h3><?php echo $cat_data->name ?></h3>
        </div>
		<?php endif; ?>
    </div>
    <div class="main block-dark">
        <div class="block-inner block-middle block-inner_last">
			<ul class="portfolio_category_list">
				<li>
					<a href="<?php echo get_post_type_archive_link('portfolio') ?>" title="<?php _e('View all projects',wpGrade_txtd) ?>"><?php _e('View All', wpGrade_txtd); ?></a>
				</li>
				<?php $terms = get_terms(array('portfolio_cat'));

				foreach ( $terms as $term ) { ?>
					<li class="filter-by_list-item <?php echo ($term->name == $cat_data->name) ? 'current-item' : ''?>">
						<a class="filter-by_link" href="<?php echo get_term_link($term) ?>" title="<?php sprintf( __( "View all projects in %s" ,wpGrade_txtd ), $term->name ); ?>"><?php echo $term->name ?></a>
					</li>
				<?php }?>
			</ul>
        </div>
    </div>
</div>
<div class="portfolio-rows">
    <?php
    $posts_nr = $wpGrade_Options->get('portfolio_archive_limit') ? absint($wpGrade_Options->get('portfolio_archive_limit')) : -1;
    wpgrade_display_portfolio( $posts_nr, false, true );
    ?>
</div>

<?php get_footer(); ?>