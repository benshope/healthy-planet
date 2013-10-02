<?php get_header(); ?>
 <!-- Content -->
<div class="content">
	<div id="prestige">
		<!-- Previous arrow -->
		<!--<a href="#" id="prestige-navigation-prev"></a>
		<!-- /Previous arrow -->
		<!-- Menu -->
		<div class="prestige-scroll-menu">
			<?php
			$params = array();
			$result = prestige_get($params);
			?>
			<?php if($result["count"]>5):?>
			<a href="#" class="prestige-menu-goup prestige-hidden"></a>
			<?php endif; ?>
			<ul id="prestige-menu" style="top: 0px;">
				<?php
				echo $result["html"];
				?>
			</ul>
			<?php if($result["count"]>5):?>
			<a href="#" class="prestige-menu-godown"></a>
			<?php endif; ?>
		</div>
        <!-- /Menu -->
		<!-- Window -->
		<div id="prestige-window"> 
			<div class="prestige-border-top"></div>
			<!-- Background -->
			<?php
			if(!$prestige_options["ajax"] || $prestige_options["animation"]=="swipe")
			{
			$pagesCount = count($result["pages"]);
			echo "<ul class='carousel'" . ($prestige_options["animation"]=="expand" ? " style='display: none;'" : "") . ">";
			for($i=0; $i<$pagesCount; $i++)
				echo $result["pages"][$i];
			echo "</ul>";
			}
			if($prestige_options["animation"]=="expand")
			{
			?>
			<div id="prestige-window-background">
				<!-- Scroll area -->
				<div id="prestige-window-scroll">
					<!-- Content -->
					<div id="prestige-window-content">
					<?php
					$urlExplode = array_values(array_filter(explode("/", $_SERVER["REQUEST_URI"])));
					$name = $urlExplode[count($urlExplode)-1];
					if($name!="")
					{
						query_posts("name=" . $name . "&post_type=page");
						if(have_posts()) : the_post(); 
							$template = get_post_meta(get_the_ID(), '_wp_page_template', true);
							if($template!="" && $template!="default")
								include($template);
							else
								echo do_shortcode(apply_filters("the_content", get_the_content()));
						else:
							query_posts("name=" . $name . "&post_type=post");
							if(have_posts()) : the_post(); 
								include("single-blog.php");
							endif;
						endif;
					}
					?>
					</div>
					<!-- /Content -->
				</div>
				<!-- /Scroll area -->
			</div>
			<?php
			}
			?>
			<!-- /Background -->
		</div>
		<!-- /Window -->
		<!-- Next arrow -->
		<!--<a href="#" id="prestige-navigation-next"></a>
		<!-- /Next arrow -->
	</div>
</div>
<!-- /Content -->
<?php get_footer(); ?>