<?php

function lang_post_id($id){
	global $post;

	// make this work with custom post types
	if ( isset($post->post_type) ) {
		$post_type = $post->post_type;
	} else {
		$post_type = 'post';
	}

	if(function_exists('icl_object_id')) {
		return icl_object_id($id, $post_type,true);
	} else {
		return $id;
	}
}

function lang_page_id($id){
	if(function_exists('icl_object_id')) {
		return icl_object_id($id,'page',true);
	} else {
		return $id;
	}
}

function lang_category_id($id){
	if(function_exists('icl_object_id')) {
		return icl_object_id($id,'category',true);
	} else {
		return $id;
	}
}
// a dream
function lang_portfolio_tax_id($id){
	if(function_exists('icl_object_id')) {
		return icl_object_id($id,'portfolio_cat',true);
	} else {
		return $id;
	}
}

function lang_post_tag_id($id){
	if(function_exists('icl_object_id')) {
		return icl_object_id($id,'post_tag',true);
	} else {
		return $id;
	}
}

function lang_original_post_id($id){
	global $post;

	// make this work with custom post types
	if ( isset($post->post_type) ) {
		$post_type = $post->post_type;
	} else {
		$post_type = 'post';
	}

	if(function_exists('icl_object_id')) {
		return icl_object_id($id, $post_type,true, get_short_defaultwp_language());
	} else {
		return $id;
	}
}

function get_short_defaultwp_language() {
	global $sitepress;
	if (isset($sitepress)) {
		return $sitepress->get_default_language();
	} else {
		return substr(get_bloginfo ( 'language' ), 0, 2);
	}
}