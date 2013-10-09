<?php

/*
 * Load defaults theme settings
 */

add_action('after_switch_theme', 'wpgrade_load_theme_defaults');

function wpgrade_load_theme_defaults(){

    $theme_options = get_option(WPGRADE_SHORTNAME.'_options');

    // Remember to encode in base64 if you want to change this default
     $defaults = 'IyMjYTo1ODp7czoxNzoidXNlX3Ntb290aF9zY3Jvb2wiO3M6MToiMSI7czoxMDoibWFpbl9jb2xvciI7czo3OiIjMjhhMGZmIjtzOjE2OiJ1c2VfZ29vZ2xlX2ZvbnRzIjtzOjE6IjAiO3M6MjU6ImRpc3BsYXlfY3VzdG9tX2Nzc19pbmxpbmUiO3M6MToiMCI7czoxMjoiaGVhZGVyX2ZpeGVkIjtzOjE6IjEiO3M6MjM6Im5vY29udGVudF9oZWFkZXJfaGVpZ2h0IjtzOjM6IjQwMCI7czoyMjoidXNlX2Zvb3Rlcl90d2l0dGVyX2JveCI7czoxOiIxIjtzOjE3OiJmb290ZXJfdHdpdHRlcl9pZCI7czo3OiJ0d2l0dGVyIjtzOjIwOiJmb290ZXJfdHdpdHRlcl9jb3VudCI7czoxOiIzIjtzOjIwOiJmb290ZXJfdHdpdHRlcl90aXRsZSI7czo5OiJGb2xsb3cgVXMiO3M6MTQ6ImNvcHlyaWdodF90ZXh0IjtzOjQwOiJDb3B5cmlnaHQgMjAxMyBGdXNlIEFsbCBSaWdodHMgUmVzZXJ2ZWQuIjtzOjIxOiJkb19zb2NpYWxfZm9vdGVyX21lbnUiO3M6MToiMSI7czoxOToiaG9tZXBhZ2VfdXNlX3NsaWRlciI7czoxOiIxIjtzOjE3OiJob21lcGFnZV9jb250ZW50MSI7czozMTM6IjxoMSBzdHlsZT0idGV4dC1hbGlnbjogY2VudGVyOyI+Q29uZ3JhdHVsYXRpb25zITwvaDE+PGgzIHN0eWxlPSJ0ZXh0LWFsaWduOiBjZW50ZXI7Ij5Zb3VyIHNpdGUgaXMganVzdCBhcm91bmQgdGhlIGNvcm5lci48L2gzPiZuYnNwOzxwIHN0eWxlPSJ0ZXh0LWFsaWduOiBjZW50ZXI7Ij5TdGFydCBieSA8c3Ryb25nPjxhIGhyZWY9Imh0dHBzOi8vd3d3LnlvdXR1YmUuY29tL3dhdGNoP3Y9UFh0dGx6enBUVjgiPndhdGNoaW5nIHRoaXMgdmlkZW88L2E+PC9zdHJvbmc+IGFib3V0IGhvdyB0byBJbnN0YWxsIGFuZCBTZXR1cCB0aGlzIHRoZW1lLjwvcD4iO3M6MjI6ImhvbWVwYWdlX3VzZV9wb3J0Zm9saW8iO3M6MToiMSI7czoyNDoiaG9tZXBhZ2VfcG9ydGZvbGlvX3RpdGxlIjtzOjE0OiJGZWF0dXJlZCBXb3JrcyI7czoyMzoiaG9tZXBhZ2VfcG9ydGZvbGlvX21vcmUiO3M6MTQ6IlZpZXcgcG9ydGZvbGlvIjtzOjI0OiJob21lcGFnZV9wb3J0Zm9saW9fbGltaXQiO3M6MToiMyI7czoxNzoiaG9tZXBhZ2VfY29udGVudDIiO3M6NDU6IjxoMz5UaGlzIGlzIHlvdXIgc2Vjb25kYXJ5IGNvbnRlbnQgYXJlYSE8L2gzPiI7czoxODoiY29udGFjdF9mb3JtX3RpdGxlIjtzOjEyOiJHZXQgaW4gVG91Y2giO3M6MjA6ImNvbnRhY3RfY29udGVudF9sZWZ0IjtzOjE4MDoiPHA+SWYgeW91IGhhdmUgcXVlc3Rpb25zIG9yIGNvbW1lbnRzLCBwbGVhc2UgZ2V0IGEgaG9sZCBvZiB1cyBpbiB3aGljaGV2ZXIgd2F5IGlzIG1vc3QgY29udmVuaWVudC48L3A+PHA+QXNrIGF3YXkuIFRoZXJlIGlzIG5vIHJlYXNvbmFibGUgcXVlc3Rpb24gdGhhdCBvdXIgdGVhbSBjYW4gbm90IGFuc3dlci48L3A+IjtzOjE4OiJjb250YWN0X2luZm9fdGl0bGUiO3M6ODoiUmVhY2ggVXMiO3M6MTY6ImNvbnRhY3RfdXNlX2dtYXAiO3M6MToiMCI7czoyNToiY29udGFjdF9nbWFwX2N1c3RvbV9zdHlsZSI7czoxOiIxIjtzOjE1OiJwb3J0Zm9saW9fdGl0bGUiO3M6MTM6Ik91ciBQcm9qZWN0cy4iO3M6MjE6InBvcnRmb2xpb19maWx0ZXJfdGV4dCI7czoxMjoiRmlsdGVyIGJ5Li4uIjtzOjMwOiJwb3J0Zm9saW9fY2F0ZWdvcnlfZGVzY3JpcHRpb24iO3M6MToiMSI7czoyMzoicG9ydGZvbGlvX2FyY2hpdmVfbGltaXQiO3M6MToiNiI7czozMzoicG9ydGZvbGlvX2FqYXhfbG9hZGluZ19wYWdpbmF0aW9uIjtzOjE6IjEiO3M6Mjc6InBvcnRmb2xpb19hamF4X2xvYWRpbmdfdGV4dCI7czozMDoiPHNwYW4+VmlldyBNb3JlPC9zcGFuPiBXb3JrLi4uIjtzOjIyOiJwb3J0Zm9saW9fc2luZ2xlX2xhYmVsIjtzOjk6IlBvcnRmb2xpbyI7czoyMjoicG9ydGZvbGlvX3BsdXJhbF9sYWJlbCI7czo4OiJQcm9qZWN0cyI7czoyMjoicG9ydGZvbGlvX3Jld3JpdGVfc2x1ZyI7czoxOiIxIjtzOjE0OiJwb3J0Zm9saW9fc2x1ZyI7czo5OiJwb3J0Zm9saW8iO3M6MzA6InBvcnRmb2xpb19yZXdyaXRlX2FyY2hpdmVfc2x1ZyI7czoxOiIwIjtzOjMxOiJwb3J0Zm9saW9fY2F0ZWdvcnlfcmV3cml0ZV9zbHVnIjtzOjE6IjEiO3M6MjM6InBvcnRmb2xpb19jYXRlZ29yeV9zbHVnIjtzOjE4OiJwb3J0Zm9saW8tY2F0ZWdvcnkiO3M6MTg6ImJsb2dfYXJjaGl2ZV90aXRsZSI7czoxMjoiQmxvZyAmIE5ld3MuIjtzOjIxOiJibG9nX2FyY2hpdmVfdGVtcGxhdGUiO3M6MTU6Imwtc2lkZWJhci1yaWdodCI7czoyNDoiYmxvZ19zaG93X2ZlYXR1cmVkX2ltYWdlIjtzOjE6IjEiO3M6MTk6ImJsb2dfZXhjZXJwdF9sZW5ndGgiO3M6MzoiMTAwIjtzOjIwOiJibG9nX3NpbmdsZV90ZW1wbGF0ZSI7czoxNToibC1zaWRlYmFyLXJpZ2h0IjtzOjI4OiJibG9nX3NpbmdsZV9zaG93X3NoYXJlX2xpbmtzIjtzOjE6IjEiO3M6MzE6ImJsb2dfc2luZ2xlX3NoYXJlX2xpbmtzX3R3aXR0ZXIiO3M6MToiMSI7czozMjoiYmxvZ19zaW5nbGVfc2hhcmVfbGlua3NfZmFjZWJvb2siO3M6MToiMSI7czozNDoiYmxvZ19zaW5nbGVfc2hhcmVfbGlua3NfZ29vZ2xlcGx1cyI7czoxOiIxIjtzOjIzOiJibG9nX3NpbmdsZV9zaG93X2F1dGhvciI7czoxOiIxIjtzOjMxOiJibG9nX3NpbmdsZV9zaG93X2NvbW1lbnRzX3RpdGxlIjtzOjE6IjAiO3M6MjQ6InByZXBhcmVfZm9yX3NvY2lhbF9zaGFyZSI7czoxOiIxIjtzOjE4OiJ1c2VfdHdpdHRlcl93aWRnZXQiO3M6MToiMSI7czoyMDoidHdpdHRlcl9jb25zdW1lcl9rZXkiO3M6MjE6IlVHY2lVa1B3akRwQ1J5RXFjR3NiZyI7czoyMzoidHdpdHRlcl9jb25zdW1lcl9zZWNyZXQiO3M6NDI6Im51SGtxUkx4S1RFSXNUSHVPanIxWFg1WVpZZXRFUjZIRjdwS3hrVjExRSI7czoyNjoidHdpdHRlcl9vYXV0aF9hY2Nlc3NfdG9rZW4iO3M6NTA6IjIwNTgxMzAxMS1vTHlnaFJ3cVJOSGJaU2hPaW1sR0tmQTZCSTRoazNLUkJXcWxEWUlYIjtzOjMzOiJ0d2l0dGVyX29hdXRoX2FjY2Vzc190b2tlbl9zZWNyZXQiO3M6NDM6IjRMcWxaamY3akRxbXhxWFFqYzZNeUl1dEhDWFBTdElhM1R2RUhYOU5FWXciO3M6MjU6InNvY2lhbF9pY29uc190YXJnZXRfYmxhbmsiO3M6MToiMSI7czoxOToidGhlbWVmb3Jlc3RfdXBncmFkZSI7czoxOiIxIjtzOjk6Im5hdl9tZW51cyI7YToxOntzOjk6Im1haW5fbWVudSI7czoxMToiSGVhZGVyIE1lbnUiO31zOjE3OiJyZWR1eC1vcHRzLWJhY2t1cCI7czoxOiIxIjt9IyMj';

    $imported_options = unserialize(trim(base64_decode( $defaults ),'###'));

    if ( empty($theme_options) || !isset($theme_options["last_tab"] )) { // load options only first time
         update_option(WPGRADE_SHORTNAME.'_options', $imported_options );
    }
}

//add_action('after_switch_theme', 'wpgrade_import_footer_widgets');
function wpgrade_import_footer_widgets(){

    /*
    * Footer widgets
    */

    $sidebars_widgets = get_option("sidebars_widgets");

    if (  isset( $sidebars_widgets["sidebar-footer"] ) && empty( $sidebars_widgets["sidebar-footer"] ) ) {
		$sidebars_widgets["sidebar-footer"] = generate_default_footer_widgets();
        update_option("sidebars_widgets", $sidebars_widgets);
    }
}

function generate_default_footer_widgets(){

    $text_widgets = get_option( "widget_text" );
    $text_widget_count = count($text_widgets);

    $recent_posts_widgets = get_option("widget_recent-posts");
    $recent_count = count($recent_posts_widgets);

    $recent_posts = '';

    $new_recent_posts_widget[(int)$recent_count+1] = array (
            'title' => 'From the Blog',
            'number' => 4,
            'show_date' => true,
        );

    if ( update_option("widget_recent-posts", $new_recent_posts_widget) ) {
        $recent_posts = 'recent-posts-'.(string)((int)$recent_count+1);

    }

    $wtext1 = '';
    $the_widget_text1 = array(
        'title' => "Widget Area",
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae felis eu diam ullamcorper hendrerit. Aliquam tempus ultrices enim, ac consectetur nibh lacinia eu.',
        'filter' => false,
    );
    $wtext2 = '';
    $the_widget_text2 = array(
         'title' => "Widget Area",
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae felis eu diam ullamcorper hendrerit. Aliquam tempus ultrices enim, ac consectetur nibh lacinia eu.',
        'filter' => false,
    );

    if ( empty( $text_widgets ) ) {

        $new_widget[2] = $the_widget_text1;
        $new_widget[3] = $the_widget_text2;

        if ( update_option( "widget_text", $new_widget ) ){

            $wtext1 = 'text-2';
            $wtext2 = 'text-3';
        }

    } else {

        $text_widgets[ $text_widget_count+1 ] = $the_widget_text1;
        $text_widgets[ $text_widget_count+2 ] = $the_widget_text2;

        if ( update_option( "widget_text", $text_widgets ) ){
            $wtext1 = 'text-'.(string)($text_widget_count+1);
            $wtext2 = 'text-'.(string)($text_widget_count+2);
        }
    }

    $new_social_links_widget[2] = array (
            'title' => ''
    );
    $ks_socials = '';
    if ( update_option("widget_wpgrade_social_links", $new_social_links_widget) ) {
        $ks_socials = 'ks_social_links-2';
    }

    if ( !empty( $wtext1 ) && !empty( $wtext2 ) && !empty( $recent_posts ) && !empty( $ks_socials ) ){
        return array( $wtext1, $recent_posts,$wtext2,$ks_socials );
    } else {
        return false;
    }

}