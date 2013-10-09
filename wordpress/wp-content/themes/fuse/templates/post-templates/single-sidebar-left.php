            <?php get_sidebar(); ?> 
            <div class="main main-content" role="main">
                <div class="block-inner block-inner_first">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix content-wrap'); ?> role="article" itemscope itemtype="http://schema.org/Article">
                        <h1 class="entry-title single-title" itemprop="name"><?php echo get_the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        </div>
                        <?php get_template_part('templates/components/blog-single-author-box'); ?>
                        <footer class="post-links">
                            <div class="article-link-title"><?php _e("Share on:", wpGrade_txtd); ?></div>
                            <ul class="post-links_list">
                                <?php if ( $wpGrade_Options->get('blog_single_show_share_links') ): ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_twitter') ): ?>
                                    <li class="post-links_item"><a href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;source=tweetbutton&amp;text=<?php echo urlencode(get_the_title())?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;via=<?php echo $wpGrade_Options->get( 'twitter_card_site' ) ?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Twitter!', wpGrade_txtd) ?>">Twitter</a></li>
                                    <?php endif; ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_facebook') ): ?>
                                    <li class="post-links_item"><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Facebook!', wpGrade_txtd) ?>">Facebook</a></li>
                                    <?php endif; ?>
                                    <?php if ( $wpGrade_Options->get('blog_single_share_links_googleplus') ): ?>
                                    <li class="post-links_item"><a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)" title="<?php _e('Share on Google+!', wpGrade_txtd) ?>">Google+</a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li class="post-links_item to-top"><a href="#top" title="<?php _e("Jump to the top of the page", wpGrade_txtd); ?>"> &uarr; <?php _e("Back to top", wpGrade_txtd); ?></a></li>
                            </ul>
                        </footer>
                        <?php comments_template(); ?>
                    </article>
                </div>
            </div>