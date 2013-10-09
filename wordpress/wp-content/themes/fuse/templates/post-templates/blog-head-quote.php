<?php
	$quote = get_post_meta($post->ID, WPGRADE_PREFIX.'quote', true);
	$quote_author = get_post_meta($post->ID, WPGRADE_PREFIX.'quote_author', true);
	$quote_author_link = get_post_meta($post->ID, WPGRADE_PREFIX.'quote_author_link', true);
?>
<div class="content-wrap entry-content">
	<div class="testimonial shc">
			<blockquote>
				<?php 
				echo '<a class="quote-post-link" href="'.get_permalink().'" title="'.esc_attr( sprintf( __( 'Read more about %s', wpGrade_txtd ), the_title_attribute( 'echo=0' ) ) ).'" rel="bookmark">';
				echo $quote;
				echo '</a>';
				if (!empty($quote_author)) { ?>
				<div class="testimonial_author">
					<?php if (!empty($quote_author_link)) { echo '<a href="'.$quote_author_link.'" title="'. __('See more about', wpGrade_txtd).' '.$quote_author.'">'; } ?>
					<span class="author_name"><?php echo $quote_author ?></span>
					<?php if (!empty($quote_author_link)) { echo '</a>'; } ?>
				</div>
				<?php } ?>
			</blockquote>
	</div>
</div>