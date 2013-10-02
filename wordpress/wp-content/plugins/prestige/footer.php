		<?php global $prestige_options;?> 
		<!-- Footer -->
		<?php
		$locations = get_nav_menu_locations();
		$prestige_menu_object = get_term($locations["prestige-footer"], "nav_menu");
		if($prestige_options["copyright"]!="" || (has_nav_menu("prestige-footer") && $prestige_menu_object->count>0)):?>
        <div class="footer">
            <!-- Menu -->
            <ul class="footer-menu no-list">
				<?php if($prestige_options["copyright"]!=""):?>
				<li><?php echo $prestige_options["copyright"]; ?></li>
				<?php 
				endif;
				if(has_nav_menu("prestige-footer") && $prestige_menu_object->count>0) 
					wp_nav_menu(array(
						"container" => "",
						"items_wrap" => '%3$s'
					));
				?>
            </ul>
            <!-- /Menu -->
		</div>
		<?php endif; ?>
		<!-- /Footer -->
	<?php wp_footer();?>
	</body>
</html>