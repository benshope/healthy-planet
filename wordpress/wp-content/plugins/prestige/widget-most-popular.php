<?php
class most_popular_widget extends WP_Widget 
{
	/** constructor */
    function most_popular_widget() 
	{
		$widget_options = array(
			'classname' => 'prestige_most_popular',
			'description' => 'Displays most popular posts by read count'
		);
        parent::WP_Widget('most_popular', 'Most Popular Posts', $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$title = apply_filters('widget_title', $instance['title']);
		$post_count = $instance['post_count'];

		echo $before_widget;

		if($title) 
		{
			echo $before_title . $title . $after_title;
		}
		//get posts
		global $blog_page_id, $parent_url;
		$post_categories = array_values(array_filter((array)get_post_meta($blog_page_id, "prestige_blog_categories", true)));
		if(!count($post_categories))
			$post_categories = get_terms("category", "fields=ids");
		$args = array(
			'posts_per_page' => $post_count,
			'post_type' => 'post',
			'post_status' => 'publish',
			'cat' => ((int)$_GET["category_id"]>0 ? (int)$_GET["category_id"] : implode(",", $post_categories)),
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num', 
			'order' => 'DESC',
		);
		query_posts($args);
		if(have_posts()) : 
			?>
			<ul class="prestige_most_popular">
			<?php
			while (have_posts()) : the_post();
			global $post;
			?>
				<li>
					<a class="link" href="<?php echo $parent_url; ?>/<?php echo $post->post_name; ?>" title="<?php the_title();?>">
						<?php the_title();?>
					</a>
					<span class="post_views_count"><?php echo getPostViews(get_the_ID()); ?></span>
				</li>
			<?php
			endwhile; 
			?>
			</ul>
			<?php
		endif;
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_count'] = strip_tags($new_instance['post_count']);
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		$title = esc_attr($instance['title']);
		$post_count = esc_attr($instance['post_count']);
		?>
		 <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'prestige'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		 <p>
			<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e('Post count', 'prestige'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>" type="text" value="<?php echo $post_count; ?>" />
		</p>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("most_popular_widget");'));
?>