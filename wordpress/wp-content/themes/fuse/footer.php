<?php
global $wpGrade_Options;

    if ( $wpGrade_Options->get('use_footer_twitter_box') ) { ?>
        <footer class="wrapper-footer row">
            <div class="main main-footer_twitter">
                <div class="block-inner-thin block-inner_first">
                    <?php
                    $username = $wpGrade_Options->get('footer_twitter_id');
                    $count = $wpGrade_Options->get('footer_twitter_count');
                    $link = 'https://twitter.com/'.$username; ?>
    	            <div class="twitter-footer twitter-footer_slider">
            			<a href="<?php echo $link ?>"><i class="icon-twitter icon-twitter_footer"></i></a>
	                    <?php the_widget('wpgrade_twitter_widget', 'username='.$username.'&count='.$count); ?>
	                </div>
                </div>
            </div>
            <div class="side side-footer_twitter">
                <div class="block-inner block-inner_last block-middle"><a href="<?php echo $link ?>" target="_blank"><i class="icon-twitter"></i><?php echo $wpGrade_Options->get('footer_twitter_title'); ?></a></div>
            </div>
        </footer>
	<?php }
    get_sidebar('footer'); ?>

    <footer class="wrapper-footer row">
		<div class="main main-footer_siteinfo">
			<div class="block-inner block-inner_first">
				<?php $copyright =  $wpGrade_Options->get( 'copyright_text' );
					if ($copyright) {
						wpgrade_display_content( $copyright );
					}
				?>
			</div>
		</div>
		<div class="side side-footer_siteinfo">
			<div class="block-inner block-inner_last">
				<?php $social_icons = $wpGrade_Options->get('social_icons');
				$target = '';
				if ($wpGrade_Options->get('social_icons_target_blank')) {
					$target = ' target="_blank"';
				}
				if (count($social_icons)): ?>
					<ul class="menu-footer_social">
						<?php foreach ($social_icons as $domain => $value): if ($value): ?>
							<li class="footer-social-link">
								<a href="<?php echo $value ?>"<?php echo $target ?>>
									<?php switch($domain) {
										case 'youtube':
											?><i class="shc icon-e-play"></i>
											<?php break;
										default:
											?><i class="shc icon-e-<?php echo $domain; ?>"></i>
									<?php } ?>
								</a>
							</li>
						<?php endif; endforeach ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</footer>
</div> <!-- close page -->
	<!-- Google Analytics tracking code -->
	<?php if ($wpGrade_Options->get('google_analytics')) {
		echo $wpGrade_Options->get('google_analytics');
	} ?>
	<?php wp_footer();?>
</body>
</html>