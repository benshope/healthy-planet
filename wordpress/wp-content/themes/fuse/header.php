<!DOCTYPE html>
<?php global $wpGrade_Options; ?>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if (IE 9)]><html <?php language_attributes(); ?> class="no-js ie9"><![endif]-->
<!--[if gt IE 9]><!-->
<?php $main_color = $wpGrade_Options->get('main_color'); ?>
<html <?php language_attributes(); ?> class="no-js <?php if ( $wpGrade_Options->get('bw_portfolio_filter') ){ echo "bw-images"; } else { echo ''; } ?> color1 <?php if ( $wpGrade_Options->get('header_fixed') ){ echo "l-header-fixed"; } else { echo ''; } ?>" data-smooth-scroll="<?php if ( $wpGrade_Options->get('use_smooth_scrool') ){ echo "on"; } else { echo 'off'; } ?>" <?php echo 'data-accentcolor="'.$main_color.'"' ?>>
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php wp_title('|','true','right'); ?><?php bloginfo('name'); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="apple-touch-fullscreen" content="yes" />
	<meta name="MobileOptimized" content="320" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>
<?php
	$template = 'l-sidebar-right';
	$single_template = $wpGrade_Options->get('blog_single_template');
	$archive_template = $wpGrade_Options->get('blog_archive_template');

    if (is_single() && !empty($single_template)):
        $template = $single_template;
    else:
        if (!empty($archive_template))
            $template = $archive_template;
    endif;
?>
<body <?php body_class($template . ' ' .wpgrade_get_class_for_featured_image()); ?>>
	<div id="page">
		<header id="header" class="wrapper wrapper-header wrapper-header-big">
			<div class="site-header">
				<div class="site-branding">
					<?php if ($wpGrade_Options->get('main_logo')): ?>
						<div class="site-logo site-logo_image<?php if ( $wpGrade_Options->get('use_full_size_logo') ) echo " full-sized"; ?>">
							<a class="site-home-link" href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name') ?>">
								<?php
									$data_retina_logo  = $wpGrade_Options->get('use_retina_logo');
									if ($data_retina_logo)
										$data_retina_logo = 'data-retina_logo="'.$wpGrade_Options->get('retina_main_logo').'"';
									else
										$data_retina_logo = '';
								?>
								<img src="<?php echo $wpGrade_Options->get('main_logo'); ?>" <?php echo $data_retina_logo; ?> rel="logo" alt="<?php echo get_bloginfo('name') ?>"/>
							</a>
						</div>
					<?php else: ?>
						<div class="site-logo_text">
							<a class="site-home-link" href="<?php echo home_url() ?>"><?php echo get_bloginfo('name') ?></a>
						</div>
					<?php endif; ?>
				</div>							
				<nav class="site-navigation" role="navigation">
					<h6 class="hidden" hidden>Main navigation</h6>
					<?php wpgrade_main_nav(); ?>
				</nav>
			</div>
		</header>

		<?php
			$header_fixed_class = '';
        	if ( !$wpGrade_Options->get('header_fixed') ) {
        		$header_fixed_class = 'header-fixed-none';
        	}
        ?>
            <div class="wrapper wrapper-header wrapper-header-small <?php echo $header_fixed_class; ?>">
                <div class="site-header">
                    <div class="site-branding">
                        <?php if ($wpGrade_Options->get('main_small_logo') || $wpGrade_Options->get('main_logo')): ?>
                            <div class="site-logo site-logo_image<?php if ( $wpGrade_Options->get('use_full_size_logo') ) echo " full-sized"; ?>">
                                <a class="site-home-link" href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name') ?>">
                                    <?php if ($wpGrade_Options->get('main_small_logo')): ?>
                                        <img src="<?php echo $wpGrade_Options->get('main_small_logo'); ?>" <?php echo $data_retina_logo; ?> alt="<?php echo get_bloginfo('name') ?>"/>
                                    <?php else: ?>
                                        <img src="<?php echo $wpGrade_Options->get('main_logo'); ?>" alt="<?php echo get_bloginfo('name') ?>"/>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="site-logo_text">
                                <a class="site-home-link" href="<?php echo home_url() ?>"><?php echo get_bloginfo('name') ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a class="nav-btn" id="nav-open-btn" href=""><i class="icon-list-ul"></i></a>
                    <nav class="site-navigation" role="navigation">
                        <h6 class="hidden" hidden>Main navigation</h6>
                        <a class="nav-btn" id="nav-close-btn" href=""></a>
                        <?php wpgrade_main_nav(); ?>
                        <?php if ($wpGrade_Options->get('header_searchform')) { ?>
                          <div class="header_search-form"><?php get_search_form(true); ?></div>
                        <?php } ?>
                    </nav>
                </div>
            </div>