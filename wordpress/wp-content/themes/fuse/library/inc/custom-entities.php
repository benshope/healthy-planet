<?php

/*
 * Register custom post types
 */

function wpgrade_register_post_types() {
    global $wpGrade_Options;
    $psg_label = $wpGrade_Options->get('portfolio_single_label');
    if ( $psg_label == '' ) { define('psg_label', 'Project'); } else { define('psg_label', $psg_label); }
    $ppl_label = $wpGrade_Options->get('portfolio_plural_label');
    if ( $ppl_label == '' ) { define('ppl_label', 'Projects'); } else { define('ppl_label', $ppl_label); }
    /*
     * Portfolio
     */

    $pargs = array(
        'labels' => array(
            'name'              => _x( psg_label, 'Post Type General Name', wpGrade_txtd ),
            'singular_name'     => _x( psg_label, 'Post Type General Name', wpGrade_txtd ),
            'add_new'           => __( 'Add New', wpGrade_txtd ),
            'add_new_item'      => __( 'Add New '.psg_label, wpGrade_txtd ),
            'edit_item'         => __( 'Edit '.psg_label, wpGrade_txtd ),
            'new_item'          => __( 'New '.psg_label, wpGrade_txtd ),
            'all_items'         => __( 'All '.ppl_label, wpGrade_txtd ),
            'view_item'         => __( 'View '.psg_label, wpGrade_txtd ),
            'search_items'      => __( 'Search '.ppl_label, wpGrade_txtd ),
            'not_found'         => __( 'No '.psg_label.' found', wpGrade_txtd ),
            'not_found_in_trash'=> __( 'No '.psg_label.' found in Trash', wpGrade_txtd ),
            'parent_item_colon' => '',
            'menu_name'         => __( ppl_label, wpGrade_txtd ),
        ),
        'public'                => true,
//	    'hierarchical'          => true,
        'publicly_queryable'    => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'portfolio-project', 'with_front' => FALSE ),
        'capability_type' => 'post',
        'has_archive' => 'portfolio-archive',
        'menu_icon' => WPGRADE_LIB_URL.'images/admin-menu-icons/report.png',
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
		'yarpp_support' => true
    );

    if ( $wpGrade_Options->get('portfolio_rewrite_slug') && $wpGrade_Options->get('portfolio_rewrite_slug') ) {
        $pargs['rewrite']['slug'] = $wpGrade_Options->get('portfolio_slug');
    }

    if ( $wpGrade_Options->get('portfolio_rewrite_archive_slug') && $wpGrade_Options->get('portfolio_rewrite_archive_slug') ) {
        $pargs['has_archive'] = $wpGrade_Options->get('portfolio_archive_slug');
    }

    register_post_type( 'portfolio', $pargs );
	
//	add_post_type_support( 'portfolio', 'post-formats', array('video') );

    // assign categories
//    if ( $wpGrade_Options->get('portfolio_use_categories' ) ) {
//        register_taxonomy_for_object_type( "category", 'portfolio' );
//    }

    // assign tags
    if ( $wpGrade_Options->get('portfolio_use_tags' ) ) {
        register_taxonomy_for_object_type( "post_tag", 'portfolio' );
    }

    // assign taxonomies to this post type
    register_taxonomy_for_object_type( 'portfolio_categories', 'portfolio' );

    /*
     * Homepage Slider
     */

    $hps_args = array(
        'labels' => array(
            'name'              => __( "Home Slides", wpGrade_txtd ),
            'singular_name'     => __( 'Slide', wpGrade_txtd ),
            'add_new'           => __( 'Add New', wpGrade_txtd ),
            'add_new_item'      => __( 'Add New Slide', wpGrade_txtd ),
            'edit_item'         => __( 'Edit Slide', wpGrade_txtd ),
            'new_item'          => __( 'New Slide', wpGrade_txtd ),
            'all_items'         => __( 'All Slides', wpGrade_txtd ),
            'view_item'         => __( 'View Slide', wpGrade_txtd ),
            'search_items'      => __( 'Search Slides', wpGrade_txtd ),
            'not_found'         => __( 'No slides found', wpGrade_txtd ),
            'not_found_in_trash'=> __( 'No slides found in trash', wpGrade_txtd ),
            'parent_item_colon' => '',
            'menu_name'         => __( 'Home Slider', wpGrade_txtd ),
        ),
        'publicly_queryable'    => true,
//        'hierarchical'          => true,
        'public'                => false,
        'show_ui'               => true,
        'show_in_nav_menus'     => false,
        'show_in_admin_bar'     => false,
        'show_in_menu'          => true,
        'query_var'             => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'capability_type'       => 'page',
        'menu_icon' => WPGRADE_LIB_URL.'images/admin-menu-icons/x_office_presentation.png',
        'menu_position'         => null,
        'supports'              => array('title', 'page-attributes', /*'editor', 'thumbnail' */),
//        'register_meta_box_cb' => 'wpgrade_remove_post_format_panel'
    );
    register_post_type( 'homepage_slide', $hps_args );
    add_post_type_support( 'homepage_slide', 'post-formats', array('video') );

    /*
     * Testimonial
     */

    $targs = array(
        'labels' => array(
            'name'              => __( 'Testimonials', wpGrade_txtd ),
            'singular_name'     => __( 'Testimonial', wpGrade_txtd ),
            'add_new'           => __( 'Add New', wpGrade_txtd ),
            'add_new_item'      => __( 'Add New Testimonial', wpGrade_txtd ),
            'edit_item'         => __( 'Edit Testimonial', wpGrade_txtd ),
            'new_item'          => __( 'New Testimonial' , wpGrade_txtd ),
            'all_items'         => __( 'All Testimonials' , wpGrade_txtd ),
            'view_item'         => __( 'View Testimonial' , wpGrade_txtd ),
            'search_items'      => __( 'Search Testimonials' , wpGrade_txtd ),
            'not_found'         => __( 'No Testimonial found', wpGrade_txtd ),
            'not_found_in_trash'=> __( 'No Testimonial found in Trash', wpGrade_txtd ),
            'parent_item_colon' => '',
            'menu_name'         => __( "Testimonials", wpGrade_txtd ),

        ),
        'public' => true,
        'publicly_queryable' => true,
//        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'exclude_from_search'   => true,
        'capability_type' => 'post',
        'menu_position' => null,
        'menu_icon' => WPGRADE_LIB_URL.'images/admin-menu-icons/user1_edit.png',
        'supports' => array('title', 'editor', 'page-attributes', 'thumbnail'),
        'register_meta_box_cb' => 'wpgrade_remove_post_format_panel'
    );

    register_post_type( 'testimonial', $targs );
}

add_action( 'init', 'wpgrade_register_post_types', 1);

function wpgrade_remove_post_format_panel($post){
    remove_meta_box( 'wpGrade_formatdiv', $post->post_type, 'side' );
}

function wpgrade_register_taxonomies () {
	global $wpGrade_Options;

	$labels = array(
		'name'                => _x( 'Portfolio Categories', 'taxonomy general name', wpGrade_txtd ),
		'singular_name'       => _x( 'Portfolio Category', 'taxonomy singular name', wpGrade_txtd ),
		'search_items'        => __( 'Search Portfolio Category', wpGrade_txtd ),
		'all_items'           => __( 'All Portfolio Categories', wpGrade_txtd ),
		'parent_item'         => __( 'Parent Portfolio Category' , wpGrade_txtd),
		'parent_item_colon'   => __( 'Parent Portfolio Category: ', wpGrade_txtd ),
		'edit_item'           => __( 'Edit Portfolio Category' , wpGrade_txtd),
		'update_item'         => __( 'Update Portfolio Category' , wpGrade_txtd),
		'add_new_item'        => __( 'Add New Portfolio Category' , wpGrade_txtd),
		'new_item_name'       => __( 'New Portfolio Category Name' , wpGrade_txtd),
		'menu_name'           => __( 'Portfolio Categories' , wpGrade_txtd)
	);

	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array('slug' => 'portfolio-category','with_front' => FALSE)
	);

	if ( $wpGrade_Options->get('portfolio_category_rewrite_slug') && $wpGrade_Options->get('portfolio_category_rewrite_slug') ) {
		$args['rewrite']['slug'] = $wpGrade_Options->get('portfolio_category_slug');
	}

	register_taxonomy( 'portfolio_cat', 'portfolio', $args );

}
add_action( 'init', 'wpGrade_register_taxonomies', 2);

/*
 * Define our custom columns for each custom post type
 */

// testimonials
add_filter( 'manage_edit-testimonial_columns', 'wpgrade_edit_testimonial_columns' ) ;

function wpgrade_edit_testimonial_columns( $columns ) {

    $columns["testimonial_author"] =  __( 'Author', wpGrade_txtd );
    $columns["author_function"] = __( 'Author Function', wpGrade_txtd );
    unset($columns["date"]);
    return $columns;
}

add_action( 'manage_testimonial_posts_custom_column', 'wpgrade_manage_testimonial_columns', 10, 2 );

function wpgrade_manage_testimonial_columns($column, $post_id){
    global $post;
    switch( $column ) {

        case 'testimonial_author' :
            $author = get_post_meta( $post_id, WPGRADE_PREFIX.'testimonial_author', true );
            echo '<a href="' . get_edit_post_link( $post_id) . '">'. $author . '</a>';
            break;

        case 'author_function' :
            echo get_post_meta( $post_id, WPGRADE_PREFIX.'author_function', true );
            break;

        default :
            break;
    }
}

//Customize WordPress messages
function wpgrade_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['portfolio'] = array(
		0 => '', 
		1 => sprintf( __('Project updated. <a href="%s">View project</a>', wpGrade_txtd ), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', wpGrade_txtd ),
		3 => __('Custom field deleted.', wpGrade_txtd ),
		4 => __('Project updated.', wpGrade_txtd ),
		5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s', wpGrade_txtd ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Project published. <a href="%s">View project</a>', wpGrade_txtd ), esc_url( get_permalink($post_ID) ) ),
		7 => __('Project saved.'),
		8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>', wpGrade_txtd ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', wpGrade_txtd ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>', wpGrade_txtd ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	
	$messages['homepage_slide'] = array(
		0 => '', 
		1 => sprintf( __('Slide updated. <a href="%s">View slide</a>', wpGrade_txtd ), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', wpGrade_txtd ),
		3 => __('Custom field deleted.', wpGrade_txtd ),
		4 => __('Slide updated.', wpGrade_txtd ),
		5 => isset($_GET['revision']) ? sprintf( __('Slide restored to revision from %s', wpGrade_txtd ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Slide published. <a href="%s">View slide</a>', wpGrade_txtd ), esc_url( get_permalink($post_ID) ) ),
		7 => __('Slide saved.'),
		8 => sprintf( __('Slide submitted. <a target="_blank" href="%s">Preview slide</a>', wpGrade_txtd ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview slide</a>', wpGrade_txtd ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Slide draft updated. <a target="_blank" href="%s">Preview slide</a>', wpGrade_txtd ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	
	$messages['testimonial'] = array(
		0 => '', 
		1 => sprintf( __('Testimonial updated. <a href="%s">View testimonial</a>', wpGrade_txtd ), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', wpGrade_txtd ),
		3 => __('Custom field deleted.', wpGrade_txtd ),
		4 => __('Testimonial updated.', wpGrade_txtd ),
		5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s', wpGrade_txtd ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Testimonial published. <a href="%s">View testimonial</a>', wpGrade_txtd ), esc_url( get_permalink($post_ID) ) ),
		7 => __('Testimonial saved.'),
		8 => sprintf( __('Testimonial submitted. <a target="_blank" href="%s">Preview testimonial</a>', wpGrade_txtd ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview testimonial</a>', wpGrade_txtd ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Testimonial draft updated. <a target="_blank" href="%s">Preview testimonial</a>', wpGrade_txtd ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'wpgrade_updated_messages' );