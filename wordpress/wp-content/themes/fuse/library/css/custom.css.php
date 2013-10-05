<?php header("Content-type: text/css; charset: UTF-8");

if ( isset($_GET["color"]) ){
    $main_color = '#'.$_GET["color"]; ?>
    .post.sticky .entry-title a, .site-mainmenu li:hover > a, .site-mainmenu > li.current-menu-parent > a, .site-mainmenu > li.current_page_item > a, .site-mainmenu > li.current-menu-item > a,
	.site-mainmenu > li .current-menu-item > a, .site-mainmenu > li.current_page_parent > a, .icon-twitter_footer, .widget_categories > ul > li a:hover, .nav-btn i, .portfolio-item_cat-link:hover, .filter-by_list a:hover, .portfolio_category_list a:hover, .previous-project-link a:hover, .next-project-link a:hover, .load_more a:hover, .previous-project-link span, .next-project-link span, .load_more span, .post-footer_meta a:hover, .comment.bypostauthor .comment-author, .pingback.bypostauthor .comment-author, .trackback.bypostauthor .comment-author, .block-dark a, .tab-titles-list-item.active a, .tab-titles-list-item a:hover, i.shc.big:hover, a,
	a:hover > i.shc, .portfolio_category_list li a:hover, .portfolio_category_list li.current-item a, .portfolio-item_title a:hover, .filter-by_list li a:hover, .filter-by_list li.current-item a, p.radio .wpcf7-radio input[type="radio"]:checked ~ span
	{
      color: <?php echo $main_color; ?>; }
    .header_search-form #searchform, .header_search-form #searchform .field, .side-footer_twitter, .side-featuredworks, .homepage-slider .flex-control-paging > li > a.flex-active, .homepage-slider_slide-content .btn, .nav-filler, .gallery_format_slider .flex-direction-nav a:hover, .block-color, .progressbar-progress, .progressbar-tooltip:after, .btn:hover, #comment-submit:hover, .btn-primary.btn, .btn-primary#comment-submit, .mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
      background-color: <?php echo $main_color; ?>; }
    .site-mainmenu > li.menu-parent-item:hover > a:after, .site-mainmenu > li ul.sub-menu li.menu-parent-item:hover a:after {
      border-color: <?php echo $main_color; ?>; }
    .side-footer_twitter .block-inner:before, .side-featuredworks .block-inner:before, .homepage-slider_slide-content .btn:after, .block-color .arrow-bottom:before, .previous-project-link a:before, .next-project-link a:after, .team-member-header, .block-light .shc-arrow:before, .block-light .shc-arrow:after {
      border-top-color: <?php echo $main_color; ?>; }
    .next-project-link a:after, .block-light .shc-arrow:after, .tab-titles-list-item.active:before {
      border-right-color: <?php echo $main_color; ?>; }
    body a:hover {
      border-bottom-color: <?php echo $main_color; ?>; }
    .previous-project-link a:before, .type-post .entry-content ul, .type-post .entry-content ol, .type-post .entry-content blockquote, .type-post .entry-content q {
      border-left-color: <?php echo $main_color; ?>; }
    body .contact-info .pin_ring {
      box-shadow: 0 0 5px <?php echo $main_color; ?>; }

    @media only screen and (min-width: 1340px) {
      .team-member-container.border-none .team-member-header, .team-member-container.border-bottom .team-member-header, .team-member-container.border-bottom {
        border-bottom-color: <?php echo $main_color; ?>;
      }
    }
    @media only screen and (min-width: 1024px) {
      .team-member-container:hover {
        border-bottom-color: <?php echo $main_color; ?>;
        background-color: <?php echo $main_color; ?>;
      }
	  a.side-testimonial:hover {
		background-color: <?php echo $main_color; ?>;
	  }
    }
    <?php
}

if ( isset($_GET["main_font"]) ){
    $main_font = $_GET["main_font"]; ?>

    h1, h2, h3, h4, h5, h6, .portfolio_items article li a .title, input.dial, blockquote, blockquote p, .site-branding a {
        font-family: "<?php echo $main_font; ?>" !important;
    }

<?php }

if ( isset($_GET["menu_font"]) ){
    $menu_font = $_GET["menu_font"]; ?>
    .site-navigation a {
        font-family: "<?php echo $menu_font; ?>" !important;
    }
<?php }

if ( isset($_GET["body_font"]) ){
    $body_font = $_GET["body_font"]; ?>
    body {
        font-family: "<?php echo $body_font; ?>" !important;
    }
<?php }

if ( isset($_GET["port_color"]) ){
    $port_color = '#'.$_GET["port_color"]; ?>
.portfolio_items article li.big a div.title, .portfolio_single_gallery li a { color: <?php echo $port_color ?> }
.portfolio_items article li.big a div.title hr {border-color: <?php echo $port_color ?>}
.portfolio_items article li a .border span, .portfolio_single_gallery li a .border span {border: 1px solid <?php echo $port_color ?>}
<?php }

if ( isset($_GET["custom_css"]) ){
    echo $_GET["custom_css"];
}?>