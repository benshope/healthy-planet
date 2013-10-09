<?php 
/*
* Search results
*/

get_header();

global $wpGrade_Options; ?>

<div class="row">
	<div class="main main-content <?php if ($wpGrade_Options->get('blog_archive_template') == 'l-sidebar-left') echo 'push4' ?>" role="main">
		<div class="block-inner block-inner_first">
			<?php if (have_posts()): while (have_posts()): the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if (get_post_format() != 'quote'): ?>
		<div class="content-wrap content-wrap-header">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', wpGrade_txtd ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			</header>
			<div class="post-footer">
				<footer class="post-footer_meta">
					<div class="post-footer_meta-group">
						<h5 class="post-footer_meta-name"><?php echo __('Posted on', wpGrade_txtd); ?></h5>
						<div class="post-footer_meta-value">
							<?php wpgrade_posted_on(); ?>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<?php endif; ?>
        <?php get_template_part( 'templates/post-templates/blog-head', get_post_format() ); ?>
        <?php if (get_post_format() != 'quote'): ?>
            <div class="content-wrap">
                <div class="entry-content">
                    <?php echo wpgrade_better_excerpt(get_the_content()); ?>
                </div><!-- .entry-content -->
            </div>
        <?php endif; ?>
        <div class="content-wrap"><b class="pattern"></b></div>
    </article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <div class="content-wrap">
        <?php wpgrade_pagination(); ?>
    </div>
<?php else: ?>
    <?php get_template_part( 'no-results', 'index' ); ?>
<?php endif; ?>
		</div>
	</div>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>