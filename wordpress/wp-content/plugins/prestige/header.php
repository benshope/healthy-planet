<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo("html_type"); ?>; charset=<?php bloginfo("charset"); ?>" />
		<meta name="generator" content="WordPress <?php bloginfo("version"); ?>" />
		<title><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() || is_404() ? bloginfo('description') : wp_title(''); ?></title>
		<link rel="stylesheet" href="<?php bloginfo("stylesheet_url"); ?>" type="text/css" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo("rss2_url"); ?>" />
		<link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />
		<?php
		wp_head(); 
		?>
		<link rel="shortcut icon" href="<?php bloginfo("template_directory"); ?>/images/favicon.ico" />
        
        <style>
		.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('http://bshope.com/as/wp-content/themes/prestige/images/icon_loading.gif') 50% 50% no-repeat rgb(249,249,249);
}
		</style>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>
        
	</head>
	<?php global $prestige_options;?>
	<body <?php body_class($prestige_options["background"]); ?>>
    <div class="loader"></div>
    <div id="vertical"> </div>
	 <!-- Main -->
	<div class="main box-center">
		<!-- Header -->
		<div class="header layout-50 overflow-fix">
			<!-- Logo -->
			<div class="layout-50-left">
				<?php if($prestige_options["header_url"]!=""):?>
				<a href="<?php echo $prestige_options["header_url"];?>" class="header-logo-link"></a>
				<?php endif; ?>
				<h1><?php echo $prestige_options["main_header"];?></h1>
				<h4 ><?php echo $prestige_options["sub_header"];?></h4>
			</div>
			<!-- /Logo -->
			<!-- Latest tweets -->
			<?php if($prestige_options["twitter_login"]!="" && $prestige_options["twitts_number"]>0):?>
			<div class="layout-50-right">
			<?php
			require_once(get_template_directory() . '/libraries/tmhOAuth/tmhOAuth.php');
			require_once(get_template_directory() . '/libraries/tmhOAuth/tmhUtilities.php');

			$tmhOAuth = new tmhOAuth(array(
				'consumer_key'    => $prestige_options["consumer_key"],
				'consumer_secret' => $prestige_options["consumer_secret"],
				'user_token'      => $prestige_options["access_token"],
				'user_secret'     => $prestige_options["access_token_secret"]
			));
			$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), array(
				'screen_name' => $prestige_options["twitter_login"],
				'count' => $prestige_options["twitts_number"],
				'include_rts' => 'true'
			));
			$response = $tmhOAuth->response;
			?>
				<div id="latest-tweets"><ul>
				<?php
				require_once(get_template_directory() . "/libraries/lib_autolink.php");
				$tweets = json_decode($response['response']);
				if(count($tweets->errors))
					echo '<li><p>' . $tweets->errors[0]->message . '! Please check your config under Appearance->Theme Options!</p></li>';
				else
					foreach($tweets as $tweet)
						echo '<li><p>' .  autolink($tweet->text, 20, ' target="_blank"') . '</p></li>';
				?>
				</ul></div>
			</div>
			<?php endif; ?>
			<!-- /Latest tweets -->
		</div>
		<!-- /Header -->
        
        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_loading.gif" id="loader"></img>