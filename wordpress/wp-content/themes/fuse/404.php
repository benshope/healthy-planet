<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */
?>

<?php get_header(); ?>

<div class="row wrapper-content">
	<div class="main main-content" role="main">
		<div class="block-inner block-inner_first">
			<h1 class="heading-404">404</h1>

			<article id="post-0" class="post error404 not-found">
				<h2 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', wpGrade_txtd ); ?></h2>

				<p><?php _e( 'This may be because of a mistyped URL, faulty referral or out-of-date search engine listing. <br />
							   You should try the <a href="'.home_url().'">homepage</a> instead or maybe do a search?', wpGrade_txtd ); ?></p>

				<div class="search-form">
					<?php get_search_form(); ?>
				</div> 	
			</article>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>