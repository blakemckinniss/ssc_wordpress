<?php
/*-----------------------------------------------------------------------------------*/
/*	Do not remove these lines, sky will fall on your head.
/*-----------------------------------------------------------------------------------*/
define( 'MTS_THEME_NAME', 'schema' );
require_once( dirname( __FILE__ ) . '/theme-options.php' );
if ( ! isset( $content_width ) ) $content_width = 1060;

/*-----------------------------------------------------------------------------------*/
/*	Load Options
/*-----------------------------------------------------------------------------------*/
$mts_options = get_option( MTS_THEME_NAME );

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/
load_theme_textdomain( 'mythemeshop', get_template_directory().'/lang' );

// Custom translations
if ( !empty( $mts_options['translate'] )) {
    $mts_translations = get_option( 'mts_translations_'.MTS_THEME_NAME );//$mts_options['translations'];
    function mts_custom_translate( $translated_text, $text, $domain ) {
        if ( $domain == 'mythemeshop' || $domain == 'nhp-opts' ) {
            global $mts_translations;
            if ( !empty( $mts_translations[$text] )) {
                $translated_text = $mts_translations[$text];
            }
        }
    	return $translated_text;
        
    }
    add_filter( 'gettext', 'mts_custom_translate', 20, 3 );
}

if ( function_exists( 'add_theme_support' ) ) add_theme_support( 'automatic-feed-links' );

/*-----------------------------------------------------------------------------------*/
/*	Disable theme updates from WordPress.org theme repository
/*-----------------------------------------------------------------------------------*/
function mts_disable_theme_update( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}
add_filter( 'http_request_args', 'mts_disable_theme_update', 5, 2 );
add_filter( 'auto_update_theme', '__return_false' );


// a shortcut function
function mts_isWooCommerce() {
    return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/*-----------------------------------------------------------------------------------*/
/*	Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 223, 137, true );
	add_image_size( 'featured', 680, 350, true ); //featured
	add_image_size( 'related', 211, 150, true ); //related
	add_image_size( 'widgetthumb', 70, 60, true ); //widget
    add_image_size( 'widgetfull', 300, 200, true ); //sidebar full width
	add_image_size( 'slider', 772, 350, true ); //slider
}

function mts_get_thumbnail_url( $size = 'full' ) {
    global $post;
    if (has_post_thumbnail( $post->ID ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
        return $image[0];
    }
    
    // use first attached image
    $images =& get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
    if (!empty($images)) {
        $image = reset($images);
        $image_data = wp_get_attachment_image_src( $image->ID, $size );
        return $image_data[0];
    }
        
    // use no preview fallback
    if ( file_exists( get_template_directory().'/images/nothumb-'.$size.'.png' ) )
        return get_template_directory_uri().'/images/nothumb-'.$size.'.png';
    else
        return '';
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Menu Support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'primary-menu' => __( 'Primary Menu', 'mythemeshop' ),
		  'secondary-menu' => __( 'Secondary Menu', 'mythemeshop' )
		 )
	 );
}

/* Add Mobile Navigation Pull button in Primary Menu */
add_filter( 'wp_nav_menu_items', 'mobile_nav_pull_button', 10, 2 );
function mobile_nav_pull_button( $items, $args ) {
    if( $args->theme_location == 'secondary-menu' )
    return '<li class="menu-item pull"><a href="#" id="pull" class="toggle-mobile-menu">'.__('Menu','mythemeshop').'</a></li>'.$items;
    return $items;
}

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar and Footer
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'register_sidebar' ) ) {   
    function mts_register_sidebars() {
        $mts_options = get_option( MTS_THEME_NAME );
        
        // Default sidebar
        register_sidebar( array(
            'name' => 'Sidebar',
            'description'   => __( 'Default sidebar.', 'mythemeshop' ),
            'id' => 'sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        // Top level footer widget areas
        if ( !empty( $mts_options['mts_top_footer'] )) {
            if ( empty( $mts_options['mts_top_footer_num'] )) $mts_options['mts_top_footer_num'] = 4;
            register_sidebars( $mts_options['mts_top_footer_num'], array(
                'name' => __( 'Top Footer %d', 'mythemeshop' ),
                'description'   => __( 'Appears at the top of the footer.', 'mythemeshop' ),
                'id' => 'footer-top',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }
        
        // Custom sidebars
        if ( !empty( $mts_options['mts_custom_sidebars'] ) && is_array( $mts_options['mts_custom_sidebars'] )) {
            foreach( $mts_options['mts_custom_sidebars'] as $sidebar ) {
                if ( !empty( $sidebar['mts_custom_sidebar_id'] ) && !empty( $sidebar['mts_custom_sidebar_id'] ) && $sidebar['mts_custom_sidebar_id'] != 'sidebar-' ) {
                    register_sidebar( array( 'name' => ''.$sidebar['mts_custom_sidebar_name'].'', 'id' => ''.sanitize_title( strtolower( $sidebar['mts_custom_sidebar_id'] )).'', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ));
                }
            }
        }

        if ( mts_isWooCommerce() ) {
            // Register WooCommerce Shop and Single Product Sidebar
            register_sidebar( array(
                'name' => __('Shop Page Sidebar', 'mythemeshop'),
                'description'   => __( 'Appears on Shop main page and product archive pages.', 'mythemeshop' ),
                'id' => 'shop-sidebar',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
            register_sidebar( array(
                'name' => __('Single Product Sidebar', 'mythemeshop'),
                'description'   => __( 'Appears on single product pages.', 'mythemeshop' ),
                'id' => 'product-sidebar',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ) );
        }
    }
    
    add_action( 'widgets_init', 'mts_register_sidebars' );
}

function mts_custom_sidebar() {
    $mts_options = get_option( MTS_THEME_NAME );
    
	// Default sidebar
	$sidebar = 'Sidebar';

	if ( is_home() && !empty( $mts_options['mts_sidebar_for_home'] )) $sidebar = $mts_options['mts_sidebar_for_home'];	
    if ( is_single() && !empty( $mts_options['mts_sidebar_for_post'] )) $sidebar = $mts_options['mts_sidebar_for_post'];
    if ( is_page() && !empty( $mts_options['mts_sidebar_for_page'] )) $sidebar = $mts_options['mts_sidebar_for_page'];
    
    // Archives
	if ( is_archive() && !empty( $mts_options['mts_sidebar_for_archive'] )) $sidebar = $mts_options['mts_sidebar_for_archive'];
	if ( is_category() && !empty( $mts_options['mts_sidebar_for_category'] )) $sidebar = $mts_options['mts_sidebar_for_category'];
    if ( is_tag() && !empty( $mts_options['mts_sidebar_for_tag'] )) $sidebar = $mts_options['mts_sidebar_for_tag'];
    if ( is_date() && !empty( $mts_options['mts_sidebar_for_date'] )) $sidebar = $mts_options['mts_sidebar_for_date'];
	if ( is_author() && !empty( $mts_options['mts_sidebar_for_author'] )) $sidebar = $mts_options['mts_sidebar_for_author'];
    
    // Other
    if ( is_search() && !empty( $mts_options['mts_sidebar_for_search'] )) $sidebar = $mts_options['mts_sidebar_for_search'];
	if ( is_404() && !empty( $mts_options['mts_sidebar_for_notfound'] )) $sidebar = $mts_options['mts_sidebar_for_notfound'];
	
    // Woo
    if ( mts_isWooCommerce() ) {
        if ( is_shop() || is_product_category() ) {
            if ( !empty( $mts_options['mts_sidebar_for_shop'] ))
                $sidebar = $mts_options['mts_sidebar_for_shop'];
            else
                $sidebar = 'shop-sidebar'; // default
        }
	    if ( is_product() ) {
            if ( !empty( $mts_options['mts_sidebar_for_product'] ))
                $sidebar = $mts_options['mts_sidebar_for_product'];
            else
                $sidebar = 'product-sidebar'; // default
	    }
    }
    
	// Page/post specific custom sidebar
	if ( is_page() || is_single() ) {
		wp_reset_postdata();
		global $post;
        $custom = get_post_meta( $post->ID, '_mts_custom_sidebar', true );
		if ( !empty( $custom )) $sidebar = $custom;
	}

	return $sidebar;
}

/*-----------------------------------------------------------------------------------*/
/*  Load Widgets, Actions and Libraries
/*-----------------------------------------------------------------------------------*/

// Add the 125x125 Ad Block Custom Widget
include( "functions/widget-ad125.php" );

// Add the 300x250 Ad Block Custom Widget
include( "functions/widget-ad300.php" );

// Add the Latest Tweets Custom Widget
include( "functions/widget-tweets.php" );

// Add Recent Posts Widget
include( "functions/widget-recentposts.php" );

// Add Related Posts Widget
include( "functions/widget-relatedposts.php" );

// Add Author Posts Widget
include( "functions/widget-authorposts.php" );

// Add Popular Posts Widget
include( "functions/widget-popular.php" );

// Add Facebook Like box Widget
include( "functions/widget-fblikebox.php" );

// Add Google Plus box Widget
include( "functions/widget-googleplus.php" );

// Add Subscribe Widget
include( "functions/widget-subscribe.php" );

// Add Social Profile Widget
include( "functions/widget-social.php" );

// Add Category Posts Widget
include( "functions/widget-catposts.php" );

// Add Category Posts Widget
include( "functions/widget-postslider.php" );

// Add Welcome message
include( "functions/welcome-message.php" );

// Template Functions
include( "functions/theme-actions.php" );

// Post/page editor meta boxes
include( "functions/metaboxes.php" );

// TGM Plugin Activation
include( "functions/plugin-activation.php" );

// AJAX Contact Form - mts_contact_form()
include( 'functions/contact-form.php' );

// Custom menu walker
include( 'functions/nav-menu.php' );

/*-----------------------------------------------------------------------------------*/
/*	RTL language support - also in mts_load_footer_scripts()
/*-----------------------------------------------------------------------------------*/
if ( ! empty( $mts_options['mts_rtl'] ) ) {
    function mts_rtl() {
        global $wp_locale, $wp_styles;
        $wp_locale->text_direction = 'rtl';
    	if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
    		$wp_styles = new WP_Styles();
    		$wp_styles->text_direction = 'rtl';
    	}
    }
    add_action( 'init', 'mts_rtl' );
}

/*-----------------------------------------------------------------------------------*/
/*	Filters customize wp_title
/*-----------------------------------------------------------------------------------*/
function mts_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'mythemeshop' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'mts_wp_title', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*	Javascript
/*-----------------------------------------------------------------------------------*/
function mts_nojs_js_class() {
    echo '<script type="text/javascript">document.documentElement.className = document.documentElement.className.replace( /\bno-js\b/,\'js\' );</script>';
}
add_action( 'wp_head', 'mts_nojs_js_class', 1 );

function mts_add_scripts() {
	$mts_options = get_option( MTS_THEME_NAME );

	wp_enqueue_script( 'jquery' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_register_script( 'customscript', get_template_directory_uri() . '/js/customscript.js', true );
    if ( ! empty( $mts_options['mts_show_primary_nav'] ) && ! empty( $mts_options['mts_show_secondary_nav'] ) ) {
        $nav_menu = 'both';
    } else {
        if ( ! empty( $mts_options['mts_show_primary_nav'] ) ) {
            $nav_menu = 'primary';
        } elseif ( ! empty( $mts_options['mts_show_secondary_nav'] ) ) {
            $nav_menu = 'secondary';
        } else {
            $nav_menu = 'none';
        }
    }
    wp_localize_script(
    	'customscript',
    	'mts_customscript',
    	array(
			'responsive' => ( empty( $mts_options['mts_responsive'] ) ? false : true ),
            'nav_menu' => $nav_menu
    	 )
    );
	wp_enqueue_script( 'customscript' );	

	global $is_IE;
    if ( $is_IE ) {
        wp_register_script ( 'html5shim', "http://html5shim.googlecode.com/svn/trunk/html5.js" );
        wp_enqueue_script ( 'html5shim' );
	}
    
    // Slider enqueued for footer
    wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), null, true );
    if ( ! empty( $mts_options['mts_featured_slider'] ) && !is_singular() ) {
        wp_enqueue_script ( 'flexslider' );
    }
}
add_action( 'wp_enqueue_scripts', 'mts_add_scripts' );
   
function mts_load_footer_scripts() {  
	$mts_options = get_option( MTS_THEME_NAME );
    
    // Parallax pages and posts
    if (is_singular()) {
        if ( basename( mts_get_post_template() ) == 'singlepost-parallax.php' || basename( get_page_template() ) == 'page-parallax.php' ) {
            wp_register_script ( 'jquery-parallax', get_template_directory_uri() . '/js/parallax.js' );
            wp_enqueue_script ( 'jquery-parallax' );
        }
    }
	
	//Lightbox
	if ( ! empty( $mts_options['mts_lightbox'] ) ) {
		wp_register_script( 'prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', true );
		wp_enqueue_script( 'prettyPhoto' );
	}
	
    //Sticky Nav
    if( $mts_options['mts_sticky_nav'] == '1' ) { // &&  $mts_options['mts_show_secondary_nav'] == '1' ) {
        wp_register_script('StickyNav', get_template_directory_uri() . '/js/sticky.js', true);
        wp_enqueue_script('StickyNav');
    }
    
	//Font Awesome
	wp_register_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', 'style' );
	wp_enqueue_style( 'fontawesome' );

    // RTL
    if ( ! empty( $mts_options['mts_rtl'] ) ) {
		wp_register_style( 'mts_rtl', get_template_directory_uri() . '/css/rtl.css', 'style', true );
		wp_enqueue_style( 'mts_rtl' );
	}
    
    // Ajax Load More and Search Results
    wp_register_script( 'mts_ajax', get_template_directory_uri() . '/js/ajax.js', true );
	if( ! empty( $mts_options['mts_pagenavigation_type'] ) && $mts_options['mts_pagenavigation_type'] >= 2 && !is_singular() ) {
		wp_enqueue_script( 'mts_ajax' );
        
        wp_register_script( 'historyjs', get_template_directory_uri() . '/js/history.js', true );
        wp_enqueue_script( 'historyjs' );
        
        // Add parameters for the JS
        global $wp_query;
        $max = $wp_query->max_num_pages;
        $paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : 1;
        $autoload = ( $mts_options['mts_pagenavigation_type'] == 3 );
        wp_localize_script(
        	'mts_ajax',
        	'mts_ajax_loadposts',
        	array(
        		'startPage' => $paged,
        		'maxPages' => $max,
        		'nextLink' => next_posts( $max, false ),
        		'autoLoad' => $autoload,
        		'i18n_loadmore' => __( 'Load More Posts', 'mythemeshop' ),
        		'i18n_nomore' => __( 'No more posts', 'mythemeshop' ),
        		'i18n_loading' => __('Loading posts ...', 'mythemeshop')
        	 )
        );
	}
    if ( ! empty( $mts_options['mts_ajax_search'] ) ) {
        wp_enqueue_script( 'mts_ajax' );
        wp_localize_script(
        	'mts_ajax',
        	'mts_ajax_search',
        	array(
				'url' => admin_url( 'admin-ajax.php' ),
        		'ajax_search' => '1'
        	 )
        );
    }
    
}  
add_action( 'wp_footer', 'mts_load_footer_scripts' );  

if( !empty( $mts_options['mts_ajax_search'] )) {
    add_action( 'wp_ajax_mts_search', 'ajax_mts_search' );
    add_action( 'wp_ajax_nopriv_mts_search', 'ajax_mts_search' );
}

/*-----------------------------------------------------------------------------------*/
/* Enqueue CSS
/*-----------------------------------------------------------------------------------*/
function mts_enqueue_css() {
	$mts_options = get_option( MTS_THEME_NAME );

	// Slider
    wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', 'style' );
	if ( ! empty( $mts_options['mts_featured_slider'] ) && !is_singular() ) {
		wp_enqueue_style( 'flexslider' );
	}
    // also enqueued in slider widget
    
    // WooCommerce
	if ( mts_isWooCommerce() && (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) ) {
		wp_register_style( 'woocommerce', get_template_directory_uri() . '/css/woocommerce2.css', 'style' );
		wp_enqueue_style( 'woocommerce' );
	}
	
	// Lightbox
	if ( ! empty( $mts_options['mts_lightbox'] ) && is_singular() ) {
		wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', 'style' );
		wp_enqueue_style( 'prettyPhoto' );
	}
	
	wp_enqueue_style( 'stylesheet', get_stylesheet_directory_uri() . '/style.css', 'style' );
	
	//Responsive
	if ( ! empty( $mts_options['mts_responsive'] ) ) {
        wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', 'style' );
	}
	
    $mts_bg = '';
	if ( $mts_options['mts_bg_pattern_upload'] != '' ) {
		$mts_bg = $mts_options['mts_bg_pattern_upload'];
	} else {
		if( !empty( $mts_options['mts_bg_pattern'] )) {
			$mts_bg = get_template_directory_uri().'/images/'.$mts_options['mts_bg_pattern'].'.png';
		}
	}
    $mts_footer_bg = '';
	if ( $mts_options['mts_footer_bg_pattern_upload'] != '' ) {
		$mts_footer_bg = $mts_options['mts_footer_bg_pattern_upload'];
	} else {
		if( !empty( $mts_options['mts_footer_bg_pattern'] )) {
			$mts_footer_bg = get_template_directory_uri().'/images/'.$mts_options['mts_footer_bg_pattern'].'.png';
		}
	}
	$mts_sclayout = '';
	$mts_shareit_left = '';
	$mts_shareit_right = '';
	$mts_author = '';
	$mts_header_section = '';
    if ( is_page() || is_single() ) {
        $mts_sidebar_location = get_post_meta( get_the_ID(), '_mts_sidebar_location', true );
    } else {
        $mts_sidebar_location = '';
    }
	if ( $mts_sidebar_location != 'right' && ( $mts_options['mts_layout'] == 'sclayout' || $mts_sidebar_location == 'left' )) {
		$mts_sclayout = '.article { float: right;}
		.sidebar.c-4-12 { float: left; padding-right: 0; }';
		if( isset( $mts_options['mts_social_button_position'] ) && $mts_options['mts_social_button_position'] == 'floating' ) {
			$mts_shareit_right = '.shareit { margin: 0 735px 0; border-left: 0; }';
		}
	}
	if ( empty( $mts_options['mts_header_section2'] ) ) {
		$mts_header_section = '#regular-header, .logo-wrap { display: none; } .secondary-navigation { float: left; }';
	}
	if ( isset( $mts_options['mts_social_button_position'] ) && $mts_options['mts_social_button_position'] == 'floating' ) {
		$mts_shareit_left = '.shareit { top: 285px; left: auto; z-index: 0; margin: 0 0 0 -155px; width: 90px; position: fixed; overflow: hidden; padding: 5px; border:none; border-right: 0; background: #fff; -webkit-box-shadow: 0px 0px 1px 0px rgba(50, 50, 50, 0.1); -moz-box-shadow: 0px 0px 1px 0px rgba(50, 50, 50, 0.1); box-shadow: 0px 0px 1px 0px rgba(50, 50, 50, 0.1);}
		.share-item {margin: 2px;}';
	}
	if ( ! empty( $mts_options['mts_author_comment'] ) ) {
		$mts_author = '.bypostauthor {padding: 3%!important;background: #222;width: 94%!important;color: #AAA;}
        .bypostauthor .fn {color: #fff;}
		.bypostauthor:after { content: "\f044";position: absolute;font-family: fontawesome;right: 0;top: 0;padding: 1px 10px;color: #535353;font-size: 32px; }';
	}
	$custom_css = "
		body {background-color:{$mts_options['mts_bg_color']}; }
		body {background-image: url( {$mts_bg} );}
		.pace .pace-progress, #mobile-menu-wrapper ul li a:hover { background: {$mts_options['mts_color_scheme']}; }
		.postauthor h5, .copyrights a, .single_post a, .textwidget a, .pnavigation2 a, .sidebar.c-4-12 a:hover, .copyrights a:hover, footer .widget li a:hover, .sidebar.c-4-12 a:hover, .related-posts a:hover .title, .reply a, .title a:hover, .post-info a:hover, .comm, #tabber .inside li a:hover, .readMore a:hover, .fn a, a, a:hover, .secondary-navigation #navigation ul li a:hover, .readMore a, .primary-navigation a:hover, .secondary-navigation #navigation ul .current-menu-item a, .widget .wp_review_tab_widget_content a, .sidebar .wpt_widget_content a { color:{$mts_options['mts_color_scheme']}; }	
			nav li.pull a#pull, #commentform input#submit, .contactform #submit, .mts-subscribe input[type='submit'], #move-to-top:hover, .currenttext, .pagination a:hover, .pagination .nav-previous a:hover, .pagination .nav-next a:hover, #load-posts a:hover, .single .pagination a:hover .currenttext, #tabber ul.tabs li a.selected, .tagcloud a, #navigation ul .sfHover a, .woocommerce a.button, .woocommerce-page a.button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button, .woocommerce .bypostauthor:after, #searchsubmit, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .woocommerce a.button, .woocommerce-page a.button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button, .latestPost-review-wrapper, .sbutton, #searchsubmit, .widget .wpt_widget_content #tags-tab-content ul li a, .widget .review-total-only.large-thumb { background-color:{$mts_options['mts_color_scheme']}; color: #fff!important; }
		footer {background-color:{$mts_options['mts_footer_bg_color']}; }
		footer {background-image: url( {$mts_footer_bg} );}
		.copyrights { background-color: {$mts_options['mts_copyrights_bg_color']}; }
		.flex-control-thumbs .flex-active{ border-top:3px solid {$mts_options['mts_color_scheme']};}
		{$mts_sclayout}
		{$mts_shareit_left}
		{$mts_shareit_right}
		{$mts_author}
		{$mts_header_section}
		{$mts_options['mts_custom_css']}
			";
	wp_add_inline_style( 'stylesheet', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'mts_enqueue_css', 99 );

/*-----------------------------------------------------------------------------------*/
/*	Wrap videos in .responsive-video div
/*-----------------------------------------------------------------------------------*/
function mts_responsive_video( $data ) {
    return '<div class="flex-video">' . $data . '</div>';
}
add_filter( 'embed_oembed_html', 'mts_responsive_video' );

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'the_content_rss', 'do_shortcode' );

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function mts_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; 
    $mts_options = get_option( MTS_THEME_NAME ); ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" itemprop="comment" itemscope itemtype="http://schema.org/UserComments">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
				<?php printf(__('<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person"><span itemprop="name">%s</span></span>', 'mythemeshop'), get_comment_author_link() ) ?> 
				<?php if ( ! empty( $mts_options['mts_comment_date'] ) ) { ?>
					<span class="ago"><?php comment_date( get_option( 'date_format' ) ); ?></span>
				<?php } ?>
				<span class="comment-meta">
					<?php edit_comment_link( __( '( Edit )', 'mythemeshop' ), '  ', '' ) ?>
				</span>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'mythemeshop' ) ?></em>
				<br />
			<?php endif; ?>
			<div class="commentmetadata">
                <div class="commenttext" itemprop="commentText">
				    <?php comment_text() ?>
                </div>
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] )) ) ?>
				</div>
			</div>
		</div>
	</li>
<?php }

/*-----------------------------------------------------------------------------------*/
/*	Excerpt
/*-----------------------------------------------------------------------------------*/

// Increase max length
function mts_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'mts_excerpt_length', 20 );

// Remove [...] and shortcodes
function mts_custom_excerpt( $output ) {
  return preg_replace( '/\[[^\]]*]/', '', $output );
}
add_filter( 'get_the_excerpt', 'mts_custom_excerpt' );

// Truncate string to x letters/words
function mts_truncate( $str, $length = 40, $units = 'letters', $ellipsis = '&nbsp;&hellip;' ) {
    if ( $units == 'letters' ) {
        if ( mb_strlen( $str ) > $length ) {
            return mb_substr( $str, 0, $length ) . $ellipsis;
        } else {
            return $str;
        }
    } else {
        $words = explode( ' ', $str );
        if ( count( $words ) > $length ) {
            return implode( " ", array_slice( $words, 0, $length ) ) . $ellipsis;
        } else {
            return $str;
        }
    }
}

if ( ! function_exists( 'mts_excerpt' ) ) {
    function mts_excerpt( $limit = 40 ) {
      return mts_truncate( get_the_excerpt(), $limit, 'words' );
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Remove more link from the_content and use custom read more
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_content_more_link', 'mts_remove_more_link', 10, 2 );
function mts_remove_more_link( $more_link, $more_link_text ) {
	return '';
}
// shorthand function to check for more tag in post
function mts_post_has_moretag() {
    global $post;
    return strpos( $post->post_content, '<!--more-->' );
}

if ( ! function_exists( 'mts_readmore' ) ) {
    function mts_readmore() {
        ?>
        <div class="readMore">
            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow">
                <?php _e( '[Continue Reading...]', 'mythemeshop' ); ?>
            </a>
        </div>
        <?php 
    }
}

/*-----------------------------------------------------------------------------------*/
/* nofollow to next/previous links
/*-----------------------------------------------------------------------------------*/
function mts_pagination_add_nofollow( $content ) {
    return 'rel="nofollow"';
}
add_filter( 'next_posts_link_attributes', 'mts_pagination_add_nofollow' );
add_filter( 'previous_posts_link_attributes', 'mts_pagination_add_nofollow' );

/*-----------------------------------------------------------------------------------*/
/* Nofollow to category links
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_category', 'mts_add_nofollow_cat' ); 
function mts_add_nofollow_cat( $text ) {
    $text = str_replace( 'rel="category tag"', 'rel="nofollow"', $text ); return $text;
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow post author link
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_author_posts_link', 'mts_nofollow_the_author_posts_link' );
function mts_nofollow_the_author_posts_link ( $link ) {
    return str_replace( '<a href=', '<a rel="nofollow" href=', $link ); 
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow to reply links
/*-----------------------------------------------------------------------------------*/
function mts_add_nofollow_to_reply_link( $link ) {
    return str_replace( '" )\'>', '" )\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'mts_add_nofollow_to_reply_link' );

/*-----------------------------------------------------------------------------------*/
/* removes the WordPress version from your header for security
/*-----------------------------------------------------------------------------------*/
function mts_remove_wpversion() {
	return '<!--Theme by MyThemeShop.com-->';
}
add_filter( 'the_generator', 'mts_remove_wpversion' );
	
/*-----------------------------------------------------------------------------------*/
/* Removes Trackbacks from the comment count
/*-----------------------------------------------------------------------------------*/
add_filter( 'get_comments_number', 'mts_comment_count', 0 );
function mts_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
        $comments = get_comments( 'status=approve&post_id=' . $id );
        $comments_separated = separate_comments( $comments );
		$comments_by_type = &$comments_separated;
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}

/*-----------------------------------------------------------------------------------*/
/* adds a class to the post if there is a thumbnail
/*-----------------------------------------------------------------------------------*/
function has_thumb_class( $classes ) {
	global $post;
	if( has_post_thumbnail( $post->ID ) ) { $classes[] = 'has_thumb'; }
		return $classes;
}
add_filter( 'post_class', 'has_thumb_class' );

/*-----------------------------------------------------------------------------------*/	
/* AJAX Search results
/*-----------------------------------------------------------------------------------*/
function ajax_mts_search() {
    $query = $_REQUEST['q']; // It goes through esc_sql() in WP_Query
    $search_query = new WP_Query( array( 's' => $query, 'posts_per_page' => 3 )); 
    $search_count = new WP_Query( array( 's' => $query, 'posts_per_page' => -1 ));
    $search_count = $search_count->post_count;
    if ( !empty( $query ) && $search_query->have_posts() ) : 
        //echo '<h5>Results for: '. $query.'</h5>';
        echo '<ul class="ajax-search-results">';
        while ( $search_query->have_posts() ) : $search_query->the_post();
            ?><li>
    			<a href="<?php the_permalink(); ?>">
				    <?php the_post_thumbnail( 'widgetthumb', array( 'title' => '' )); ?>
    				<?php the_title(); ?>	
    			</a>
    			<div class="meta">
    					<span class="thetime"><?php the_time( 'F j, Y' ); ?></span>
    			</div> <!-- / .meta -->

    		</li>	
    		<?php
        endwhile;
        echo '</ul>';
        echo '<div class="ajax-search-meta"><span class="results-count">'.$search_count.' '.__( 'Results', 'mythemeshop' ).'</span><a href="'.get_search_link( $query ).'" class="results-link">Show all results</a></div>';
    else:
        echo '<div class="no-results">'.__( 'No results found.', 'mythemeshop' ).'</div>';
    endif;
        
    exit; // required for AJAX in WP
}
/*-----------------------------------------------------------------------------------*/
/* Redirect feed to feedburner
/*-----------------------------------------------------------------------------------*/

if ( $mts_options['mts_feedburner'] != '' ) {
function mts_rss_feed_redirect() {
    $mts_options = get_option( MTS_THEME_NAME );
    global $feed;
    $new_feed = $mts_options['mts_feedburner'];
    if ( !is_feed() ) {
            return;
    }
    if ( preg_match( '/feedburner/i', $_SERVER['HTTP_USER_AGENT'] )){
            return;
    }
    if ( $feed != 'comments-rss2' ) {
            if ( function_exists( 'status_header' )) status_header( 302 );
            header( "Location:" . $new_feed );
            header( "HTTP/1.1 302 Temporary Redirect" );
            exit();
    }
}
add_action( 'template_redirect', 'mts_rss_feed_redirect' );
}

/*-----------------------------------------------------------------------------------*/
/* Single Post Pagination - Numbers + Previous/Next
/*-----------------------------------------------------------------------------------*/
function mts_wp_link_pages_args( $args ) {
    global $page, $numpages, $more, $pagenow;
    if ( !$args['next_or_number'] == 'next_and_number' )
        return $args; 
    $args['next_or_number'] = 'number'; 
    if ( !$more )
        return $args; 
    if( $page-1 ) 
        $args['before'] .= _wp_link_page( $page-1 )
        . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>'
    ;
    if ( $page<$numpages ) 
    
        $args['after'] = _wp_link_page( $page+1 )
        . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
        . $args['after']
    ;
    return $args;
}
add_filter( 'wp_link_pages_args', 'mts_wp_link_pages_args' );

/*-----------------------------------------------------------------------------------*/
/* WooCommerce
/*-----------------------------------------------------------------------------------*/
if ( mts_isWooCommerce() ) {
    add_theme_support( 'woocommerce' );
    
    // Change number or products per row to 3
    add_filter( 'loop_shop_columns', 'loop_columns' );
    if ( !function_exists( 'loop_columns' )) {
    	function loop_columns() {
    		return 3; // 3 products per row
    	}
    }
    
    // Redefine woocommerce_output_related_products()
    function woocommerce_output_related_products() {
        woocommerce_related_products( 3, 1 ); // Display 3 products in rows of 1
    }
    
    /*** Hook in on activation */
    global $pagenow;
    if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'mythemeshop_woocommerce_image_dimensions', 1 );
     
    /*** Define image sizes */
    function mythemeshop_woocommerce_image_dimensions() {
      	$catalog = array(
    		'width' 	=> '209',	// px
    		'height'	=> '209',	// px
    		'crop'		=> 1 		// true
    	 );
    	$single = array(
    		'width' 	=> '326',	// px
    		'height'	=> '326',	// px
    		'crop'		=> 1 		// true
    	 );
    	$thumbnail = array(
    		'width' 	=> '74',	// px
    		'height'	=> '74',	// px
    		'crop'		=> 0 		// false
    	 ); 
    	// Image sizes
    	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    	update_option( 'shop_single_image_size', $single ); 		// Single product image
    	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
    }
    
    add_filter( 'woocommerce_product_thumbnails_columns', 'mts_thumb_cols' );
    function mts_thumb_cols() {
     return 4; // .last class applied to every 4th thumbnail
    }
    
    add_filter( 'loop_shop_per_page', 'mts_products_per_page', 20 );
    function mts_products_per_page() {
        $mts_options = get_option( MTS_THEME_NAME );
        return $mts_options['mts_shop_products'];
    }
    
    // Ensure cart contents update when products are added to the cart via AJAX
    add_filter( 'add_to_cart_fragments', 'mts_header_add_to_cart_fragment' );
    function mts_header_add_to_cart_fragment( $fragments ) {
    	global $woocommerce;
    	ob_start();	?>
    	
    	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'mythemeshop' ); ?>"><?php echo sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'mythemeshop' ), $woocommerce->cart->cart_contents_count );?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    	
    	<?php $fragments['a.cart-contents'] = ob_get_clean();
    	return $fragments;
    }

    /**
     * Optimize WooCommerce Scripts
     * Updated for WooCommerce 2.0+
     * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
     */
    add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
     
    function child_manage_woocommerce_styles() {
        //remove generator meta tag
        remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
     
        //first check that woo exists to prevent fatal errors
        if ( function_exists( 'is_woocommerce' ) ) {
            //dequeue scripts and styles
            if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
    			wp_dequeue_style( 'woocommerce-layout' );
    			wp_dequeue_style( 'woocommerce-smallscreen' );
    			wp_dequeue_style( 'woocommerce-general' );
    			wp_dequeue_style( 'wc-bto-styles' ); //Composites Styles
    			wp_dequeue_script( 'wc-add-to-cart' );
    			wp_dequeue_script( 'wc-cart-fragments' );
    			wp_dequeue_script( 'woocommerce' );
    			wp_dequeue_script( 'jquery-blockui' );
    			wp_dequeue_script( 'jquery-placeholder' );
            }
        }
    }
     
    remove_action('wp_head', 'wc_generator_tag');
}
/*-----------------------------------------------------------------------------------*/
/* add <!-- next-page --> button to tinymce
/*-----------------------------------------------------------------------------------*/
add_filter( 'mce_buttons', 'wysiwyg_editor' );
function wysiwyg_editor( $mce_buttons ) {
   $pos = array_search( 'wp_more', $mce_buttons, true );
   if ( $pos !== false ) {
       $tmp_buttons = array_slice( $mce_buttons, 0, $pos+1 );
       $tmp_buttons[] = 'wp_page';
       $mce_buttons = array_merge( $tmp_buttons, array_slice( $mce_buttons, $pos+1 ));
   }
   return $mce_buttons;
}

/*-----------------------------------------------------------------------------------*/
/*	Alternative post templates
/*-----------------------------------------------------------------------------------*/
function mts_get_post_template( $default = 'default' ) {
    global $post;
    $single_template = $default;
    $posttemplate = get_post_meta( $post->ID, '_mts_posttemplate', true );
    
    if ( empty( $posttemplate ) || ! is_string( $posttemplate ) )
        return $single_template;
    
    if ( file_exists( dirname( __FILE__ ) . '/singlepost-'.$posttemplate.'.php' ) ) {
        $single_template = dirname( __FILE__ ) . '/singlepost-'.$posttemplate.'.php';
    }
    
    return $single_template;
}
function mts_set_post_template( $single_template ) {
     return mts_get_post_template( $single_template );
}
add_filter( 'single_template', 'mts_set_post_template' );
/*-----------------------------------------------------------------------------------*/
/*	Custom Gravatar Support
/*-----------------------------------------------------------------------------------*/
function mts_custom_gravatar( $avatar_defaults ) {
    $mts_avatar = get_template_directory_uri() . '/images/gravatar.png';
    $avatar_defaults[$mts_avatar] = 'Custom Gravatar ( /images/gravatar.png )';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'mts_custom_gravatar' );

/*-----------------------------------------------------------------------------------*/
/*  WP Review Support
/*-----------------------------------------------------------------------------------*/

// Set default colors for new reviews
function new_default_review_colors( $colors ) {
    $colors = array(
        'color' => '#FFCA00',
        'fontcolor' => '#fff',
        'bgcolor1' => '#151515',
        'bgcolor2' => '#151515',
        'bordercolor' => '#151515'
    );
  return $colors;
}
add_filter( 'wp_review_default_colors', 'new_default_review_colors' );
 
// Set default location for new reviews
function new_default_review_location( $position ) {
  $position = 'top';
  return $position;
}
add_filter( 'wp_review_default_location', 'new_default_review_location' );

?>