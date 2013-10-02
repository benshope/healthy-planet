<?php
$themename = "Prestige";

//admin menu
function prestige_contact_form_admin_menu() 
{
	add_options_page(__('Prestige Contact Form', 'prestige'), __('Prestige Contact Form', 'prestige'), 'administrator', 'prestige_contact_form', 'prestige_contact_form_admin_page');
}
add_action('admin_menu', 'prestige_contact_form_admin_menu');

function prestige_contact_form_admin_page() 
{
	global $themename;
	if($_POST["action"]=="save")
	{
		$prestige_contact_form_options = array(
			"name_hint" => $_POST["name_hint"],
			"email_hint" => $_POST["email_hint"],
			"text_hint" => $_POST["text_hint"],
			"email_subject" => $_POST["email_subject"],
			"admin_name" => $_POST["admin_name"],
			"admin_email" => $_POST["admin_email"],
			"template" => $_POST["template"],
			"smtp_host" => $_POST["smtp_host"],
			"smtp_username" => $_POST["smtp_username"],
			"smtp_password" => $_POST["smtp_password"],
			"smtp_port" => $_POST["smtp_port"],
			"smtp_secure" => $_POST["smtp_secure"],
			"name_error" => $_POST["name_error"],
			"email_error" => $_POST["email_error"],
			"text_error" => $_POST["text_error"],
			"message_send_error" => $_POST["message_send_error"],
			"message_send_ok" => $_POST["message_send_ok"]
		);
		update_option("prestige_contact_form_options", $prestige_contact_form_options);
	}
	$prestige_contact_form_options = prestige_stripslashes_deep(get_option("prestige_contact_form_options"));
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php echo $themename . " "; _e('Contact Form Options', 'prestige');?></h2>
	</div>
	<?php 
	if($_POST["action"]=="save")
	{
	?>
	<div class="updated"> 
		<p>
			<strong>
				<?php
					_e('Options saved', 'prestige');
				?>
			</strong>
		</p>
	</div>
	<?php 
	}
	?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="prestige_contact_form_settings">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php
						_e('Admin email config', 'prestige');
						?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="admin_name"><?php _e('Name', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["admin_name"]); ?>" id="admin_name" name="admin_name">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="admin_email"><?php _e('Email', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["admin_email"]); ?>" id="admin_email" name="admin_email">
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php
						_e('Admin SMTP config (optional)', 'prestige');
						?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_host"><?php _e('Host', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["smtp_host"]); ?>" id="smtp_host" name="smtp_host">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_username"><?php _e('Username', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["smtp_username"]); ?>" id="smtp_username" name="smtp_username">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_password"><?php _e('Password', 'prestige'); ?></label>
					</th>
					<td>
						<input type="password" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["smtp_password"]); ?>" id="smtp_password" name="smtp_password">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_port"><?php _e('Port', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["smtp_port"]); ?>" id="smtp_port" name="smtp_port">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_secure"><?php _e('SMTP Secure', 'prestige'); ?></label>
					</th>
					<td>
						<select id="smtp_secure" name="smtp_secure">
							<option value=""<?php echo ($prestige_contact_form_options["smtp_secure"]=="" ? " selected='selected'" : "") ?>>-</option>
							<option value="ssl"<?php echo ($prestige_contact_form_options["smtp_secure"]=="ssl" ? " selected='selected'" : "") ?>><?php _e('ssl', 'prestige'); ?></option>
							<option value="tls"<?php echo ($prestige_contact_form_options["smtp_secure"]=="tls" ? " selected='selected'" : "") ?>><?php _e('tls', 'prestige'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Email config', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="email_subject"><?php _e('Email subject', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["email_subject"]); ?>" id="email_subject" name="email_subject">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="template"><?php _e('Template', 'prestige'); ?></label>
					</th>
					<td>
						<?php the_editor($prestige_contact_form_options["template"], "template");?>
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Fields hints', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="name_hint"><?php _e('Name hint', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["name_hint"]); ?>" id="name_hint" name="name_hint">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="email_hint"><?php _e('Email hint', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["email_hint"]); ?>" id="email_hint" name="email_hint">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="text_hint"><?php _e('Text hint', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["text_hint"]); ?>" id="text_hint" name="text_hint">
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Error messages', 'prestige'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="name_error"><?php _e('Name field', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["name_error"]); ?>" id="name_error" name="name_error">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="email_error"><?php _e('Email field', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["email_error"]); ?>" id="email_error" name="email_error">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="text_error"><?php _e('Text field', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["text_error"]); ?>" id="text_error" name="text_error">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="message_send_ok"><?php _e('Message send ok', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["message_send_ok"]); ?>" id="message_send_ok" name="message_send_ok">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="message_send_error"><?php _e('Message send error', 'prestige'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($prestige_contact_form_options["message_send_error"]); ?>" id="message_send_error" name="message_send_error">
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