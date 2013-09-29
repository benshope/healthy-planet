<?php 
global $qode_options_central; 

$title_in_grid = false;
if(isset($qode_options_central['title_in_grid'])){
if ($qode_options_central['title_in_grid'] == "yes") $title_in_grid = true;
}

?>	

<?php get_header(); ?>
			<div class="title">
				<?php if($title_in_grid){ ?>
				<div class="container">
					<div class="container_inner clearfix">
				<?php } ?>
				<h1><?php if($qode_options_central['404_title'] != ""): echo $qode_options_central['404_title']; else: ?> <?php _e('404', 'qode'); ?> <?php endif;?> / <?php if($qode_options_central['404_subtitle'] != ""): echo $qode_options_central['404_subtitle']; else: ?> <?php _e('Something went wrong', 'qode'); ?> <?php endif; ?> </h1>	
				<?php if($title_in_grid){ ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="container">
				<div class="container_inner clearfix">
					<div class="page_not_found">
						<h2><?php if($qode_options_central['404_text'] != ""): echo $qode_options_central['404_text']; else: ?> <?php _e('Page not found', 'qode'); ?> <?php endif;?></h2>
						<div class="separator_small"></div>
						<p><a href="<?php echo home_url(); ?>/"><?php if($qode_options_central['404_backlabel'] != ""): echo $qode_options_central['404_backlabel']; else: ?> <?php _e('Back to homepage', 'qode'); ?> <?php endif;?></a></p>
					</div>
				</div>
			</div>
			
<?php get_footer(); ?>	