<?php
$themename = "Prestige";

//admin menu
function prestige_admin_menu() 
{
	global $themename;
	add_theme_page($themename, "Theme Options", "edit_theme_options", "ThemeOptions", "prestige_options");
}
add_action("admin_menu", "prestige_admin_menu");

function prestige_stripslashes_deep($value)
{
	$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

	return $value;
}

function prestige_options() 
{
	global $themename;
	if($_POST["action"]=="save")
	{
		$prestige_options = array(
			"main_header" => $_POST["main_header"],
			"sub_header" => $_POST["sub_header"],
			"header_url" => $_POST["header_url"],
			"copyright" => $_POST["copyright"],
			"twitter_login" => $_POST["twitter_login"],
			"twitts_number" => (int)$_POST["twitts_number"],
			"consumer_key" => $_POST["consumer_key"],
			"consumer_secret" => $_POST["consumer_secret"],
			"access_token" => $_POST["access_token"],
			"access_token_secret" => $_POST["access_token_secret"],
			"ajax" => $_POST["ajax"],
			"animation" => $_POST["animation"],
			"on_touch" => $_POST["on_touch"],
			"on_mouse" => $_POST["on_mouse"],
			"threshold" => $_POST["threshold"],
			"duration" => $_POST["duration"],
			"animation_effect" => $_POST["animation_effect"],
			"animation_transition" => $_POST["animation_transition"]
		);
		update_option("prestige_options", $prestige_options);
	}
	$prestige_options = prestige_stripslashes_deep(get_option("prestige_options"));
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php echo $themename;?> <?php _e('Options', 'prestige'); ?></h2>
	</div>
	<?php 
	if($_POST["action"]=="save")
	{
	?>
	<div class="updated"> 
		<p>
			<strong>
				<?php _e('Options saved', 'prestige'); ?>
			</strong>
		</p>
	</div>
	<?php 
	}
	?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="prestige_theme_settings">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Header', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="main_header"><?php _e('Main header content', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["main_header"]); ?>" id="main_header" name="main_header">
						<span class="description"><?php _e('Can be text or any html', 'prestige'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="sub_header"><?php _e('Sub header content', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["sub_header"]); ?>" id="sub_header" name="sub_header">
						<span class="description"><?php _e('Can be text or any html', 'prestige'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="header_url"><?php _e('Header URL', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["header_url"]); ?>" id="header_url" name="header_url">
						<span class="description"><?php _e('Leave empty for no link.', 'prestige'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Footer', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="copyright"><?php _e('Copyright text', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["copyright"]); ?>" id="copyright" name="copyright">
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						Social icons
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="twitter_login"><?php _e('Twitter login', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["twitter_login"]); ?>" id="twitter_login" name="twitter_login">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="twitts_number"><?php _e('Twitts number', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["twitts_number"]); ?>" id="twitts_number" name="twitts_number">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="consumer_key"><?php _e('Twitter consumer key', 'cascade'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["consumer_key"]); ?>" id="consumer_key" name="consumer_key">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="consumer_secret"><?php _e('Twitter consumer secret', 'cascade'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["consumer_secret"]); ?>" id="consumer_secret" name="consumer_secret">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="access_token"><?php _e('Twitter access token', 'cascade'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["access_token"]); ?>" id="access_token" name="access_token">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="access_token_secret"><?php _e('Twitter access token secret', 'cascade'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["access_token_secret"]); ?>" id="access_token_secret" name="access_token_secret">
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2">
						Directions to get the Consumer key, Consumer secret, Access token and Access token secret:<br>
						1. <a href="https://dev.twitter.com/apps/new" target="_blank">Add a new Twitter application</a><br>
						2. Fill in Name, Description, Website, and Callback URL (don't leave any blank) with anything you want<br>
						3. Agree to rules, fill out captcha, and submit your application<br>
						4. Copy the Consumer key, Consumer secret, Access token and Access token secret into the fields above<br>
						5. Click the Save Options button at the bottom
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Animation', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="animation"><?php _e('Animation while changing pages', 'prestige'); ?></label>
					</th>
					<td>
						<select id="animation" name="animation">
							<option value="expand"<?php echo ($prestige_options["animation"]=="expand" ? " selected='selected'" : "") ?>><?php _e('expand', 'prestige'); ?></option>
							<option value="swipe"<?php echo ($prestige_options["animation"]=="swipe" ? " selected='selected'" : "") ?>><?php _e('swipe', 'prestige'); ?></option>	
						</select>
					</td>
				</tr>
				<tr valign="top" class="animation_expand" style="display: none;">
					<th scope="row">
						<label for="on_touch"><?php _e('Switch page on touch', 'prestige'); ?></label>
					</th>
					<td>
						<select id="on_touch" name="on_touch">
							<option value="1"<?php echo ($prestige_options["on_touch"]=="1" ? " selected='selected'" : "") ?>><?php _e('yes', 'prestige'); ?></option>
							<option value="0"<?php echo ($prestige_options["on_touch"]=="0" ? " selected='selected'" : "") ?>><?php _e('no', 'prestige'); ?></option>	
						</select>
					</td>
				</tr>
				<tr valign="top" class="animation_expand" style="display: none;">
					<th scope="row">
						<label for="on_mouse"><?php _e('Switch page on mouse', 'prestige'); ?></label>
					</th>
					<td>
						<select id="on_mouse" name="on_mouse">
							<option value="1"<?php echo ($prestige_options["on_mouse"]=="1" ? " selected='selected'" : "") ?>><?php _e('yes', 'prestige'); ?></option>
							<option value="0"<?php echo ($prestige_options["on_mouse"]=="0" ? " selected='selected'" : "") ?>><?php _e('no', 'prestige'); ?></option>	
						</select>
					</td>
				</tr>
				<tr valign="top" class="animation_expand" style="display: none;">
					<th scope="row">
						<label for="threshold"><?php _e('Threshold (swipe distance in px before run the animation)', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["threshold"]); ?>" id="threshold" name="threshold">
					</td>
				</tr>
				<tr valign="top" class="animation_expand" style="display: none;">
					<th scope="row">
						<label for="duration"><?php _e('Duration', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_options["duration"]); ?>" id="duration" name="duration">
					</td>
				</tr>
				<tr valign="top" class="animation_expand" style="display: none;">
					<td>
						<label for="animation_effect"><?php _e('Effect:', 'prestige'); ?></label>
					</td>
					<td>
						<select id="animation_effect" name="animation_effect">
							<option value="scroll"<?php echo ($prestige_options["animation_effect"]=="scroll" ? " selected='selected'" : "") ?>><?php _e('scroll', 'prestige'); ?></option>
							<option value="none"<?php echo ($prestige_options["animation_effect"]=="none" ? " selected='selected'" : "") ?>><?php _e('none', 'prestige'); ?></option>
							<option value="directscroll"<?php echo ($prestige_options["animation_effect"]=="directscroll" ? " selected='selected'" : "") ?>><?php _e('directscroll', 'prestige'); ?></option>
							<option value="fade"<?php echo ($prestige_options["animation_effect"]=="fade" ? " selected='selected'" : "") ?>><?php _e('fade', 'prestige'); ?></option>
							<option value="crossfade"<?php echo ($prestige_options["animation_effect"]=="crossfade" ? " selected='selected'" : "") ?>><?php _e('crossfade', 'prestige'); ?></option>
							<option value="cover"<?php echo ($prestige_options["animation_effect"]=="cover" ? " selected='selected'" : "") ?>><?php _e('cover', 'prestige'); ?></option>
							<option value="uncover"<?php echo ($prestige_options["animation_effect"]=="uncover" ? " selected='selected'" : "") ?>><?php _e('uncover', 'prestige'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top" class="animation_expand" style="display: none;">
					<td>
						<label for="animation_transition"><?php _e('Transition:', 'prestige'); ?></label>
					</td>
					<td>
						<select id="animation_transition" name="animation_transition">
							<option value="swing"<?php echo ($prestige_options["animation_transition"]=="swing" ? " selected='selected'" : "") ?>><?php _e('swing', 'prestige'); ?></option>
							<option value="linear"<?php echo ($prestige_options["animation_transition"]=="linear" ? " selected='selected'" : "") ?>><?php _e('linear', 'prestige'); ?></option>
							<option value="easeInQuad"<?php echo ($prestige_options["animation_transition"]=="easeInQuad" ? " selected='selected'" : "") ?>><?php _e('easeInQuad', 'prestige'); ?></option>
							<option value="easeOutQuad"<?php echo ($prestige_options["animation_transition"]=="easeOutQuad" ? " selected='selected'" : "") ?>><?php _e('easeOutQuad', 'prestige'); ?></option>
							<option value="easeInOutQuad"<?php echo ($prestige_options["animation_transition"]=="easeInOutQuad" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuad', 'prestige'); ?></option>
							<option value="easeInCubic"<?php echo ($prestige_options["animation_transition"]=="easeInCubic" ? " selected='selected'" : "") ?>><?php _e('easeInCubic', 'prestige'); ?></option>
							<option value="easeOutCubic"<?php echo ($prestige_options["animation_transition"]=="easeOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeOutCubic', 'prestige'); ?></option>
							<option value="easeInOutCubic"<?php echo ($prestige_options["animation_transition"]=="easeInOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeInOutCubic', 'prestige'); ?></option>
							<option value="easeInOutCubic"<?php echo ($prestige_options["animation_transition"]=="easeInOutCubic" ? " selected='selected'" : "") ?>><?php _e('easeInOutCubic', 'prestige'); ?></option>
							<option value="easeInQuart"<?php echo ($prestige_options["animation_transition"]=="easeInQuart" ? " selected='selected'" : "") ?>><?php _e('easeInQuart', 'prestige'); ?></option>
							<option value="easeOutQuart"<?php echo ($prestige_options["animation_transition"]=="easeOutQuart" ? " selected='selected'" : "") ?>><?php _e('easeOutQuart', 'prestige'); ?></option>
							<option value="easeInOutQuart"<?php echo ($prestige_options["animation_transition"]=="easeInOutQuart" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuart', 'prestige'); ?></option>
							<option value="easeInSine"<?php echo ($prestige_options["animation_transition"]=="easeInSine" ? " selected='selected'" : "") ?>><?php _e('easeInSine', 'prestige'); ?></option>
							<option value="easeOutSine"<?php echo ($prestige_options["animation_transition"]=="easeOutSine" ? " selected='selected'" : "") ?>><?php _e('easeOutSine', 'prestige'); ?></option>
							<option value="easeInOutSine"<?php echo ($prestige_options["animation_transition"]=="easeInOutSine" ? " selected='selected'" : "") ?>><?php _e('easeInOutSine', 'prestige'); ?></option>
							<option value="easeInExpo"<?php echo ($prestige_options["animation_transition"]=="easeInExpo" ? " selected='selected'" : "") ?>><?php _e('easeInExpo', 'prestige'); ?></option>
							<option value="easeOutExpo"<?php echo ($prestige_options["animation_transition"]=="easeOutExpo" ? " selected='selected'" : "") ?>><?php _e('easeOutExpo', 'prestige'); ?></option>
							<option value="easeInOutExpo"<?php echo ($prestige_options["animation_transition"]=="easeInOutExpo" ? " selected='selected'" : "") ?>><?php _e('easeInOutExpo', 'prestige'); ?></option>
							<option value="easeInQuint"<?php echo ($prestige_options["animation_transition"]=="easeInQuint" ? " selected='selected'" : "") ?>><?php _e('easeInQuint', 'prestige'); ?></option>
							<option value="easeOutQuint"<?php echo ($prestige_options["animation_transition"]=="easeOutQuint" ? " selected='selected'" : "") ?>><?php _e('easeOutQuint', 'prestige'); ?></option>
							<option value="easeInOutQuint"<?php echo ($prestige_options["animation_transition"]=="easeInOutQuint" ? " selected='selected'" : "") ?>><?php _e('easeInOutQuint', 'prestige'); ?></option>
							<option value="easeInCirc"<?php echo ($prestige_options["animation_transition"]=="easeInCirc" ? " selected='selected'" : "") ?>><?php _e('easeInCirc', 'prestige'); ?></option>
							<option value="easeOutCirc"<?php echo ($prestige_options["animation_transition"]=="easeOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeOutCirc', 'prestige'); ?></option>
							<option value="easeInOutCirc"<?php echo ($prestige_options["animation_transition"]=="easeInOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeInOutCirc', 'prestige'); ?></option>
							<option value="easeInElastic"<?php echo ($prestige_options["animation_transition"]=="easeInElastic" ? " selected='selected'" : "") ?>><?php _e('easeInElastic', 'prestige'); ?></option>
							<option value="easeOutElastic"<?php echo ($prestige_options["animation_transition"]=="easeOutElastic" ? " selected='selected'" : "") ?>><?php _e('easeOutElastic', 'prestige'); ?></option>
							<option value="easeInOutElastic"<?php echo ($prestige_options["animation_transition"]=="easeInOutElastic" ? " selected='selected'" : "") ?>><?php _e('easeInOutElastic', 'prestige'); ?></option>
							<option value="easeInBack"<?php echo ($prestige_options["animation_transition"]=="easeInBack" ? " selected='selected'" : "") ?>><?php _e('easeInBack', 'prestige'); ?></option>
							<option value="easeOutBack"<?php echo ($prestige_options["animation_transition"]=="easeOutBack" ? " selected='selected'" : "") ?>><?php _e('easeOutBack', 'prestige'); ?></option>
							<option value="easeInOutBack"<?php echo ($prestige_options["animation_transition"]=="easeOutCirc" ? " selected='selected'" : "") ?>><?php _e('easeInOutBack', 'prestige'); ?></option>
							<option value="easeInBounce"<?php echo ($prestige_options["animation_transition"]=="easeInBounce" ? " selected='selected'" : "") ?>><?php _e('easeInBounce', 'prestige'); ?></option>
							<option value="easeOutBounce"<?php echo ($prestige_options["animation_transition"]=="easeOutBounce" ? " selected='selected'" : "") ?>><?php _e('easeOutBounce', 'prestige'); ?></option>
							<option value="easeInOutBounce"<?php echo ($prestige_options["animation_transition"]=="easeInOutBounce" ? " selected='selected'" : "") ?>><?php _e('easeInOutBounce', 'prestige'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top" class="ajax_row" style="display: none;">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Ajax', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top" class="ajax_row" style="display: none;">
					<th scope="row">
						<label for="ajax"><?php _e('Load pages via ajax', 'prestige'); ?></label>
					</th>
					<td>
						<select id="ajax" name="ajax">
							<option value="1"<?php echo ($prestige_options["ajax"]=="1" ? " selected='selected'" : "") ?>><?php _e('yes', 'prestige'); ?></option>
							<option value="0"<?php echo ($prestige_options["ajax"]=="0" ? " selected='selected'" : "") ?>><?php _e('no', 'prestige'); ?></option>	
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<p>
			<input type="hidden" name="action" value="save" />
			<input type="submit" value="Save Options" class="button-primary" name="Submit">
		</p>
	</form>
<?php
}
?>