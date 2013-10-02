<?php
//google map
function prestige_map_shortcode($atts)
{
	extract(shortcode_atts(array(
		"id" => "map",
		"width" => "298",
		"height" => "150",
		"lat" => "29.760193",
		"lng" => "-95.36939",
		"marker_lat" => "29.760193",
		"marker_lng" => "-95.36939",
		"zoom" => "10"
	), $atts));
	$output = "
	<div id='$id' style='width: " . $width . "px; height: " . $height . "px;'></div>
	<script type='text/javascript'>
	try
    {
        var coordinate=new google.maps.LatLng($lat, $lng);

        var mapOptions= 
        {
            zoom:$zoom,
            center:coordinate,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById('$id'),mapOptions);";
	if($marker_lat!="" && $marker_lng!="")
	{
	$output .= "
		new google.maps.Marker({
			position: new google.maps.LatLng($marker_lat, $marker_lng),
			map: map
		});";
	}
	$output .= "
    }
    catch(e) {};
	</script>";
	return $output;
}
add_shortcode("prestige_map", "prestige_map_shortcode");

//contact form
function prestige_contact_form_shortcode($atts)
{
	global $prestige_contact_form_options;
	$output = "";
	$output .= '<form name="contact" id="contact" class="prestige_contact_form" action="" method="post">
            <div>
                <div class="form-line block">
                    <input type="text" name="contact-user-name" id="contact-user-name" value="' . $prestige_contact_form_options["name_hint"] . '" onfocus="clearInput(this,\'focus\',\'' . $prestige_contact_form_options["name_hint"] . '\')" onblur="clearInput(this,\'blur\',\'' . $prestige_contact_form_options["name_hint"] . '\')"/>	
                </div>
                <div class="form-line block">
                    <input type="text" name="contact-user-email" id="contact-user-email" value="' . $prestige_contact_form_options["email_hint"] . '" onfocus="clearInput(this,\'focus\',\'' . $prestige_contact_form_options["email_hint"] . '\')" onblur="clearInput(this,\'blur\',\'' . $prestige_contact_form_options["email_hint"] . '\')"/>	
                </div>					
                <div class="form-line block">
                    <textarea rows="0" cols="0" name="contact-message" id="contact-message" onfocus="clearInput(this,\'focus\',\'' . $prestige_contact_form_options["text_hint"] . '\')" onblur="clearInput(this,\'blur\',\'' . $prestige_contact_form_options["text_hint"] . '\')">' . $prestige_contact_form_options["text_hint"] . '</textarea>	
                </div>
                <div class="form-line">
                    <a href="javascript:submitContactForm();" class="button block" id="contact-send">Send</a>
					<input type="hidden" name="action" value="prestige_contact_form" />
                </div>
            </div>	
        </form>';
	return $output;
}
add_shortcode("prestige_contact_form", "prestige_contact_form_shortcode");

//contact form submit
function prestige_contact_form()
{
	global $prestige_contact_form_options;

    require_once("form-functions.php");
    require_once("phpMailer/class.phpmailer.php");

    $response=array('error'=>0,'info'=>null);

    $values=array
    (
        'contact-user-name' => $_POST['contact-user-name'],
        'contact-user-email' => $_POST['contact-user-email'],
        'contact-message' => $_POST['contact-message']
    );

    if(isEmpty($values['contact-user-name']) || strcmp($values['contact-user-name'],$prestige_contact_form_options["name_hint"])==0)
    {
        $response['error']=1;
        $response['info'][]=array('fieldId'=>'contact-user-name','message'=>$prestige_contact_form_options["name_error"]);
    }

    if(!validateEmail($values['contact-user-email']) || strcmp($values['contact-user-email'],$prestige_contact_form_options["email_hint"])==0)
    {
        $response['error']=1;	
        $response['info'][]=array('fieldId'=>'contact-user-email','message'=>$prestige_contact_form_options["email_error"]);
    }

    if(isEmpty($values['contact-message']) || strcmp($values['contact-message'],$prestige_contact_form_options["text_hint"])==0)
    {
        $response['error']=1;
        $response['info'][]=array('fieldId'=>'contact-message','message'=>$prestige_contact_form_options["text_error"]);
    }	

    if($response['error']==1) createResponse($response);

    if(isGPC()) $values=array_map('stripslashes',$values);

    $values=array_map('htmlspecialchars',$values);

    $body=$prestige_contact_form_options["template"];
	$body = str_replace("[name]", $values["contact-user-name"], $body);
	$body = str_replace("[email]", $values["contact-user-email"], $body); 
	$body = str_replace("[message]", $values["contact-message"], $body);

    $mail=new PHPMailer(); 
	$mail->CharSet = "UTF-8";
    $mail->SetFrom($prestige_contact_form_options["admin_email"],$prestige_contact_form_options["admin_name"]); 
    $mail->AddAddress($prestige_contact_form_options["admin_email"],$prestige_contact_form_options["admin_name"]);

    if(!isEmpty($prestige_contact_form_options["smtp_host"]))
    {
		$mail->IsSMTP();
        $mail->SMTPAuth=true; 
        $mail->Host=$prestige_contact_form_options["smtp_host"];
        $mail->Username=$prestige_contact_form_options["smtp_username"];
        $mail->Password=$prestige_contact_form_options["smtp_password"];
    }
    
    $mail->Subject=$prestige_contact_form_options["email_subject"];
    $mail->MsgHTML($body);

    if(!$mail->Send())
    {
        $response['error']=1;	
        $response['info'][]=array('fieldId'=>'contact-send','message'=>$prestige_contact_form_options["message_send_error"]);
        createResponse($response);		
    }

    $response['error']=0;
    $response['info'][]=array('fieldId'=>'contact-send','message'=>$prestige_contact_form_options["message_send_ok"]);

    createResponse($response);
}
add_action("wp_ajax_prestige_contact_form", "prestige_contact_form");
add_action("wp_ajax_nopriv_prestige_contact_form", "prestige_contact_form");

//info list
//list
function info_list_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"header" => "Personal info"
	), $atts));
	$output = "";
	if($header!="")
		$output .= '<h3>' . $header . '</h3>';
	$output .= '<ul class="no-list info-list">' . do_shortcode($content) . '</ul>';
	return $output;
}
add_shortcode("info_list", "info_list_shortcode");

//item
function info_list_item_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"label" => "",
		"style" => "",
		"align" => ""
	), $atts));
	$output = '<li' . ($align=="left" ? ' class="info-list-left"':'') . '>';
	if($label!="")
		$output .= '<label>' . $label . '</label>';
	if($style!="simple")
		$output .= '<span class="arrow_right"></span>';
	$output .= '<span' . ($style=="simple" ? ' class="simple"' : '') . '>' . $content . '</span>';
	$output .= '</li>';
	return $output;
}
add_shortcode("info_list_item", "info_list_item_shortcode");

//social icons list
//list
function prestige_social_icon_list_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"header" => "Social profiles"
	), $atts));
	$output = "";
	if($header!="")
		$output .= '<h3 class="margin-bottom-20">' . $header . '</h3>';
	$output .= '<ul class="no-list social-links overflow-fix clear-fix">' . do_shortcode($content) . '</ul>';
	return $output;
}
add_shortcode("prestige_social_icon_list", "prestige_social_icon_list_shortcode");

//item
function prestige_social_icon_list_item_shortcode($atts, $content="")
{
	extract(shortcode_atts(array(
		"type" => "twitter",
		"url" => "",
		"tooltip" => "",
		"target" => ""
	), $atts));
	$output = '<li class="social-links-' . $type . ($content!="" ? ' social-links-margin-bottom' : '') . '">';
	if($content!="")
		$output .= '<span class="social_icon"' . ($tooltip!="" ? ' title="' . esc_attr($tooltip) . '"' : '') . '></span><div><span class="social_icon_text">' . $content . '</span>';
	$output .= '<a' . ($content=="" ? ' class="social_icon"' : '') . ' href="' . esc_attr($url) . '" title="' . ($content=="" ? esc_attr($tooltip) : "") . '"' . ($target!="" ? ' target="' . esc_attr($target) . '"' : '') . '>' . ($content!="" ? $url : "") . '</a>';
	if($content!="")
		$output .= '</div>';
	$output .= '</li>';
	return $output;
}
add_shortcode("prestige_social_icon_list_item", "prestige_social_icon_list_item_shortcode");

//skill list
//list
function skill_list_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"header" => ""
	), $atts));
	$output = "";
	if($header!="")
		$output .= '<h3>' . $header . '</h3>';
	$output .= '<ul class="no-list skill-list">' . do_shortcode($content) . '</ul>';
	return $output;
}
add_shortcode("skill_list", "skill_list_shortcode");

//item
function skill_list_item_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"level" => "10",
		"style" => ""
	), $atts));
	$output = '<li' . ($style=="simple" ? ' class="skill_list_item_simple"' : '') . '><span class="skill_level level-' . $level . '"></span><span class="skill_content">' . $content . '</span>' . ($style!="simple" ? '<span class="skill_level_value_container"><span class="arrow_left"></span><span class="skill_level_value">0</span></span>' : '') . '</li>';
	return $output;
}
add_shortcode("skill_list_item", "skill_list_item_shortcode");
?>