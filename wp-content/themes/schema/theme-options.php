<?php

defined('ABSPATH') or die;

/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 *
 */
require_once( dirname( __FILE__ ) . '/options/options.php' );
/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'mythemeshop'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'mythemeshop'),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = false;
//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'mythemeshop');

//Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
										'link' => 'http://twitter.com/mythemeshopteam',
										'title' => 'Follow Us on Twitter', 
										'img' => 'fa fa-facebook-square'
										);
$args['share_icons']['linked_in'] = array(
										'link' => 'http://www.facebook.com/mythemeshop',
										'title' => 'Like us on Facebook', 
										'img' => 'fa fa-twitter-square'
										);

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = MTS_THEME_NAME;

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
$args['menu_title'] = __('Theme Options', 'mythemeshop');

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Theme Options', 'mythemeshop');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
$args['page_slug'] = 'theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 62;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';
		
//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-1',
							'title' => __('Support', 'mythemeshop'),
							'content' => __('<p>If you are facing any problem with our theme or theme option panel, head over to our <a href="http://mythemeshop.com/support">Knowledge Base</a></p>', 'mythemeshop')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-3',
							'title' => __('Credit', 'mythemeshop'),
							'content' => __('<p>Options Panel created using the <a href="http://leemason.github.com/NHP-Theme-Options-Framework/" target="_blank">NHP Theme Options Framework</a> Version 1.0.5</p>', 'mythemeshop')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-2',
							'title' => __('Earn Money', 'mythemeshop'),
							'content' => __('<p>Earn 60% commision on every sale by refering your friends and readers. Join our <a href="http://mythemeshop.com/affiliate-program/">Affiliate Program</a>.</p>', 'mythemeshop')
							);

//Set the Help Sidebar for the options page - no sidebar by default										
//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'mythemeshop');



$sections = array();

$sections[] = array(
				'icon' => 'fa fa-cogs',
				'title' => __('General Settings', 'mythemeshop'),
				'desc' => __('<p class="description">This tab contains common setting options which will be applied to the whole theme.</p>', 'mythemeshop'),
				'fields' => array(
				
					array(
						'id' => 'mts_logo',
						'type' => 'upload',
						'title' => __('Logo Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your logo using the Upload Button or insert image URL.', 'mythemeshop')
						),
					array(
						'id' => 'mts_favicon',
						'type' => 'upload',
						'title' => __('Favicon', 'mythemeshop'), 
						'sub_desc' => __('Upload a <strong>16 x 16 px</strong> image that will represent your website\'s favicon. You can refer to this link for more information on how to make it: <a href="http://www.favicon.cc/" target="blank" rel="nofollow">http://www.favicon.cc/</a>', 'mythemeshop')
						),
					array(
						'id' => 'mts_header_code',
						'type' => 'textarea',
						'title' => __('Header Code', 'mythemeshop'), 
						'sub_desc' => __('Enter the code which you need to place <strong>before closing </head> tag</strong>. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)', 'mythemeshop')
						),
					array(
						'id' => 'mts_analytics_code',
						'type' => 'textarea',
						'title' => __('Footer Code', 'mythemeshop'), 
						'sub_desc' => __('Enter the codes which you need to place in your footer. <strong>(ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)</strong>.', 'mythemeshop')
						),
					array(
						'id' => 'mts_copyrights',
						'type' => 'textarea',
						'title' => __('Copyrights Text', 'mythemeshop'), 
						'sub_desc' => __('You can change or remove our link from footer and use your own custom text. (Link back is always appreciated)', 'mythemeshop'),
						'std' => 'Theme by <a href="http://mythemeshop.com/">MyThemeShop</a>'
						),
					array(
                        'id' => 'mts_pagenavigation_type',
                        'type' => 'radio',
                        'title' => __('Pagination Type', 'mythemeshop'),
                        'sub_desc' => __('Select pagination type.', 'mythemeshop'),
                        'options' => array(
                                        '0'=> __('Default (Next / Previous)','mythemeshop'), 
                                        '1' => __('Numbered (1 2 3 4...)','mythemeshop'), 
                                        '2' => 'AJAX (Load More Button)', 
                                        '3' => 'AJAX (Auto Infinite Scroll)'),
                        'std' => '0'
                        ),
                    array(
                        'id' => 'mts_ajax_search',
                        'type' => 'button_set',
                        'title' => __('AJAX Quick search', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable or disable search results appearing instantly below the search form', 'mythemeshop'),
						'std' => '0'
                        ),
                    array(
                        'id' => 'mts_full_posts',
                        'type' => 'button_set',
                        'title' => __('Posts on blog pages', 'mythemeshop'), 
						'options' => array('0' => 'Excerpts','1' => 'Full posts'),
						'sub_desc' => __('Show post excerpts or full posts on the homepage and other archive pages.', 'mythemeshop'),
						'std' => '0',
                        'class' => 'green'
                        ),
					array(
						'id' => 'mts_responsive',
						'type' => 'button_set',
						'title' => __('Responsiveness', 'mythemeshop'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('MyThemeShop themes are responsive, which means they adapt to tablet and mobile devices, ensuring that your content is always displayed beautifully no matter what device visitors are using. Enable or disable responsiveness using this option.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_prefetching',
						'type' => 'button_set',
						'title' => __('Prefetching', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable or disable prefetching. If user is on homepage, then single page will load faster and if user is on single page, homepage will load faster in modern browsers.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_rtl',
						'type' => 'button_set',
						'title' => __('Right To Left Language Support', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable this option for right-to-left sites.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_shop_products',
						'type' => 'text',
						'title' => __('No. of Products', 'mythemeshop'),
						'sub_desc' => __('Enter the total number of products which you want to show on shop page (WooCommerce plugin must be enabled).', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '9',
						'class' => 'small-text'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-adjust',
				'title' => __('Styling Options', 'mythemeshop'),
				'desc' => __('<p class="description">Control the visual appearance of your theme, such as colors, layout and patterns, from here.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_color_scheme',
						'type' => 'color',
						'title' => __('Color Scheme', 'mythemeshop'), 
						'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'mythemeshop'),
						'std' => '#0274BE'
						),
					array(
						'id' => 'mts_layout',
						'type' => 'radio_img',
						'title' => __('Layout Style', 'mythemeshop'), 
						'sub_desc' => __('Choose the <strong>default sidebar position</strong> for your site. The position of the sidebar for individual posts can be set in the post editor. <br/><strong>[C]</strong>: Content<br/><strong>[S]</strong>: Sidebar.', 'mythemeshop'),
						'options' => array(
										'cslayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cs.png'),
										'sclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/sc.png')
											),
						'std' => 'cslayout'
						),
					array(
						'id' => 'mts_thumb_layout',
						'type' => 'radio_img',
						'title' => __('HomePage Thumbnail Size', 'mythemeshop'), 
						'sub_desc' => __('Choose the <strong>featured thumbnail size</strong> for your site.', 'mythemeshop'),
						'options' => array(
										'large_home_thumb' => array('img' => NHP_OPTIONS_URL.'img/layouts/tb.png'),
										'small_home_thumb' => array('img' => NHP_OPTIONS_URL.'img/layouts/ts.png')
											),
						'std' => 'large_home_thumb'
						),
					array(
						'id' => 'mts_bg_color',
						'type' => 'color',
						'title' => __('Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick a color for the site background color.', 'mythemeshop'),
						'std' => '#F5F5F5'
						),
					array(
						'id' => 'mts_bg_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose from any of <strong>37</strong> awesome background patterns for your site\'s background.', 'mythemeshop'),
						'options' => array(
										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
											),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_bg_pattern_upload',
						'type' => 'upload',
						'title' => __('Custom Background Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your own custom background image or pattern.', 'mythemeshop')
						),
					array(
						'id' => 'mts_top_footer',
						'type' => 'button_set_hide_below',
						'title' => __('Footer', 'mythemeshop'), 
						'sub_desc' => __('Enable or disable first footer with this option.', 'mythemeshop'),
						'options' => array(
								'0' => 'Off',
								'1' => 'On'
							),
						'std' => '0',
						'args' => array(
							'hide' => 4
							)
						),
					array(
						'id' => 'mts_top_footer_num',
						'type' => 'button_set',
						'class' => 'green',
						'title' => __('Footer Layout', 'mythemeshop'), 
						'sub_desc' => __('Choose the number of widget areas in the <strong>top footer</strong>', 'mythemeshop'),
						'options' => array(
								'3' => '3 Widgets',
								'4' => '4 Widgets'
							),
						'std' => '4'
						),
					array(
						'id' => 'mts_footer_bg_color',
						'type' => 'color',
						'title' => __('Footer Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick a color for the footer background color.', 'mythemeshop'),
						'std' => '#222222'
						),
					array(
						'id' => 'mts_footer_bg_pattern',
						'type' => 'radio_img',
						'title' => __('Footer Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose from any of <strong>25</strong> awesome background patterns for your site\'s background.', 'mythemeshop'),
						'options' => array(
										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
											),
						'std' => 'nobg'
						),
					array(
						'id' => 'mts_footer_bg_pattern_upload',
						'type' => 'upload',
						'title' => __('Custom Footer Background Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your own custom footer background image or pattern.', 'mythemeshop')
						),
					array(
						'id' => 'mts_copyrights_bg_color',
						'type' => 'color',
						'title' => __('Copyrights Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick a color for the Copyrights section background color.', 'mythemeshop'),
						'std' => '#ffffff'
						),
					array(
						'id' => 'mts_custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'mythemeshop'), 
						'sub_desc' => __('You can enter custom CSS code here to further customize your theme. This will override the default CSS used on your site.', 'mythemeshop')
						),
					array(
						'id' => 'mts_lightbox',
						'type' => 'button_set',
						'title' => __('Lightbox', 'mythemeshop'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('A lightbox is a stylized pop-up that allows your visitors to view larger versions of images without leaving the current page. You can enable or disable the lightbox here.', 'mythemeshop'),
						'std' => '0'
						),																		
					)
				);
$sections[] = array(
				'icon' => 'fa fa-credit-card',
				'title' => __('Header', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the elements of header section.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_header_style',
						'type' => 'radio_img',
						'title' => __('Header Styling', 'mythemeshop'), 
						'sub_desc' => __('Choose the <strong>Header design</strong> for your site.', 'mythemeshop'),
						'options' => array(
										'regular_header' => array('img' => NHP_OPTIONS_URL.'img/layouts/h1.png'),
										'logo_in_nav_header' => array('img' => NHP_OPTIONS_URL.'img/layouts/h2.png')
											),
						'std' => 'regular_header'
						),
					array(
						'id' => 'mts_sticky_nav',
						'type' => 'button_set',
						'title' => __('Floating Navigation Menu', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to enable <strong>Floating Navigation Menu</strong>.', 'mythemeshop'),
						'std' => '0'
						),
                    array(
						'id' => 'mts_show_primary_nav',
						'type' => 'button_set',
						'title' => __('Show Primary Menu', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to enable <strong>Primary Navigation Menu</strong>.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_header_section2',
						'type' => 'button_set',
						'title' => __('Show Logo', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide <strong>Logo</strong> completely.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_feedburner',
						'type' => 'text',
						'title' => __('FeedBurner URL', 'mythemeshop'),
						'sub_desc' => __('Enter your FeedBurner\'s URL here, ex: <strong>http://feeds.feedburner.com/mythemeshop</strong> and your main feed (http://example.com/feed) will get redirected to the FeedBurner ID entered here.)', 'mythemeshop'),
						'validate' => 'url'
						),
					array(
						'id' => 'mts_header_social_icons',
						'type' => 'button_set_hide_below',
						'title' => __('Header Social Icons', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Check this box to show social icons in header area.', 'mythemeshop'),
						'std' => '0',
                        'args' => array('hide' => 5)
						),
					array(
						'id' => 'mts_header_feed_icon',
						'type' => 'button_set',
						'title' => __('Header Feed Icon', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Check this box to show Feed Icon in header area.', 'mythemeshop'),
						'std' => '0',
						),
					array(
						'id' => 'mts_twitter_username',
						'type' => 'text',
						'title' => __('Twitter Username', 'mythemeshop'),
						'sub_desc' => __('Enter your Username here.', 'mythemeshop'),
						),
					array(
						'id' => 'mts_facebook_username',
						'type' => 'text',
						'title' => __('Facebook link', 'nhp-opts'),
						'sub_desc' => __('Enter your Facebook profile/page link here.', 'nhp-opts')
						),
					array(
						'id' => 'mts_gplus_username',
						'type' => 'text',
						'title' => __('Google Plus Page', 'nhp-opts'),
						'sub_desc' => __('Enter your Google Plus profile/page link here.', 'nhp-opts')
						),
					array(
						'id' => 'mts_pinterest_username',
						'type' => 'text',
						'title' => __('Pinterest link', 'nhp-opts'),
						'sub_desc' => __('Enter your Pinterest link her.', 'nhp-opts')
						),
					)
				);	
$sections[] = array(
				'icon' => 'fa fa-home',
				'title' => __('Homepage', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the elements of the homepage.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_featured_slider',
						'type' => 'button_set_hide_below',
						'title' => __('Homepage Slider', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('<strong>Enable or Disable</strong> homepage slider with this button. The slider will show recent articles from the selected categories.', 'mythemeshop'),
						'std' => '0',
                        'args' => array('hide' => 3)
						),
						array(
						'id' => 'mts_featured_slider_cat',
						'type' => 'cats_multi_select',
						'title' => __('Slider Category(s)', 'mythemeshop'), 
						'sub_desc' => __('Select a category from the drop-down menu, latest articles from this category will be shown <strong>in the slider</strong>.', 'mythemeshop'),
						'args' => array('number' => '100')
						),
                        array(
						'id' => 'mts_featured_slider_num',
						'type' => 'text',
                        'class' => 'small-text',
						'title' => __('Number of posts', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of posts to show in the slider', 'mythemeshop'),
                        'std' => '3',
                        'args' => array('type' => 'number')
						),	
                        array(
                        'id'        => 'mts_custom_slider',
                        'type'      => 'group',
                        'title'     => __('Custom Slider', 'mythemeshop'), 
                        'sub_desc'  => __('With this option you can set up a slider with custom image and text instead of the default slider automatically generated from your posts.', 'mythemeshop'),
                        'groupname' => __('Slider', 'mythemeshop'), // Group name
                        'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_custom_slider_title',
            						'type' => 'text',
            						'title' => __('Title', 'mythemeshop'), 
            						'sub_desc' => __('Title of the slide', 'mythemeshop'),
                                    ),
                                array(
                                    'id' => 'mts_custom_slider_image',
            						'type' => 'upload',
            						'title' => __('Image', 'mythemeshop'), 
            						'sub_desc' => __('Upload or select an image for this slide', 'mythemeshop'),
                                    'return' => 'id'
            						),
                                array('id' => 'mts_custom_slider_link',
            						'type' => 'text',
            						'title' => __('Link', 'mythemeshop'), 
            						'sub_desc' => __('Insert a link URL for the slide', 'mythemeshop'),
                                    'std' => '#'
                                    ),
                            ),
                        ),
                    array(
                        'id'        => 'mts_featured_categories',
                        'type'      => 'group',
                        'title'     => __('Featured Categories', 'mythemeshop'), 
                        'sub_desc'  => __('Select categories appearing on the homepage.', 'mythemeshop'),
                        'groupname' => __('Section', 'mythemeshop'), // Group name
                        'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_featured_category',
            						'type' => 'cats_select',
            						'title' => __('Category', 'mythemeshop'), 
            						'sub_desc' => __('Select a category or the latest posts for this section', 'mythemeshop'),
									'std' => 'latest',
                                    'args' => array('include_latest' => 1, 'hide_empty' => 0, 'number' => 200),
            						),
                                array(
                                    'id' => 'mts_featured_category_postsnum',
            						'type' => 'text',
                                    'class' => 'small-text',
            						'title' => __('Number of posts', 'mythemeshop'), 
            						'sub_desc' => sprintf(__('Enter the number of posts to show in this section.<br/><strong>For Latest Posts</strong>, this setting will be ignored, and number set in <a href="%s" target="_blank">Settings&nbsp;&gt;&nbsp;Reading</a> will be used instead.', 'mythemeshop'), admin_url('options-reading.php')),
                                    'std' => '3',
                                    'args' => array('type' => 'number')
            						),	
                            ),
            				'std' => array(
            					'1' => array(
            						'group_title' => '',
            						'group_sort' => '1',
            						'mts_featured_category' => 'latest',
            						'mts_featured_category_postsnum' => get_option('posts_per_page')
            					)
            				)
                        ),
                    array(
						'id' => 'mts_home_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('HomePage Post Meta Info.', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info on HomePage. (<strong>Author name, Date etc.</strong>).', 'mythemeshop'),
						'std' => '1'
						),
						array(
                        'id' => 'mts_home_headline_meta_info',
                        'type' => 'multi_checkbox',
                        'title' => __('Meta Info to Show', 'mythemeshop'),
                        'sub_desc' => __('Choose What Meta Info to Show.', 'mythemeshop'),
                        'options' => array('author' => __('Author Name','mythemeshop'),'date' => __('Date','mythemeshop'),'category' => __('Categories','mythemeshop'),'comment' => __('Comment Count','mythemeshop')),
                        'std' => array('author' => '1', 'date' => '1', 'category' => '1', 'comment' => '1')
                        ),
					)
				);	
$sections[] = array(
				'icon' => 'fa fa-file-text',
				'title' => __('Single Posts', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the appearance and functionality of your single posts page.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_single_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('Post Meta Info.', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info <strong>Author name and Categories</strong>.', 'mythemeshop'),
						'std' => '1'
						),
						array(
 						'id' => 'mts_single_headline_meta_info',
 						'type' => 'multi_checkbox',
 						'title' => __('Meta Info to Show', 'mythemeshop'),
 						'sub_desc' => __('Choose What Meta Info to Show.', 'mythemeshop'),
 						'options' => array('author' => __('Author Name','mythemeshop'),'date' => __('Date','mythemeshop'),'category' => __('Categories','mythemeshop'),'comment' => __('Comment Count','mythemeshop')),
 						'std' => array('author' => '1', 'date' => '1', 'category' => '1', 'comment' => '1')
 						),
					array(
						'id' => 'mts_breadcrumb',
						'type' => 'button_set',
						'title' => __('Breadcrumbs', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Breadcrumbs are a great way to make your site more user-friendly. You can enable them by checking this box.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_author_comment',
						'type' => 'button_set',
						'title' => __('Highlight Author Comment', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to highlight author comments.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_tags',
						'type' => 'button_set',
						'title' => __('Tag Links', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button if you want to show a tag cloud below the related posts.', 'mythemeshop'),
						'std' => '0'
						),
					array(
        				'id' => 'mts_related_posts',
        				'type' => 'button_set_hide_below',
        				'title' => __('Related Posts', 'mythemeshop') ,
        				'options' => array(
        					'0' => 'Off',
        					'1' => 'On'
        				) ,
        				'sub_desc' => __('Use this button to show related posts with thumbnails below the content area in a post.', 'mythemeshop') ,
        				'std' => '1',
        				'args' => array(
        					'hide' => 2
        				)
        			),
        			array(
        				'id' => 'mts_related_posts_taxonomy',
        				'type' => 'button_set',
        				'title' => __('Related Posts Taxonomy', 'mythemeshop') ,
        				'options' => array(
        					'tags' => 'Tags',
        					'categories' => 'Categories'
        				) ,
        				'class' => 'green',
        				'sub_desc' => __('Related Posts based on tags or categories.', 'mythemeshop') ,
        				'std' => 'categories'
        			),
        			array(
        				'id' => 'mts_related_postsnum',
        				'type' => 'text',
        				'class' => 'small-text',
        				'title' => __('Number of related posts', 'mythemeshop') ,
        				'sub_desc' => __('Enter the number of posts to show in the related posts section.', 'mythemeshop') ,
        				'std' => '3',
        				'args' => array(
        					'type' => 'number'
        				)
        			),
					array(
						'id' => 'mts_author_box',
						'type' => 'button_set',
						'title' => __('Author Box', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button if you want to display author information below the article.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_comment_date',
						'type' => 'button_set',
						'title' => __('Date in Comments', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to show the date for comments.', 'mythemeshop'),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-group',
				'title' => __('Social Buttons', 'mythemeshop'),
				'desc' => __('<p class="description">Enable or disable social sharing buttons on single posts using these buttons.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_social_buttons',
						'type' => 'button_set_hide_below',
						'title' => __('Social Media Buttons', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Check this box to show social sharing buttons after an article\'s content text.', 'mythemeshop'),
						'std' => '1',
                        'args' => array('hide' => 7)
						),
					array(
						'id' => 'mts_social_button_position',
						'type' => 'button_set',
						'title' => __('Social Sharing Buttons Position', 'mythemeshop'), 
						'options' => array('top' => __('Above Content','mythemeshop'), 'bottom' => __('Below Content','mythemeshop'), 'floating' => __('Floating','mythemeshop')),
						'sub_desc' => __('Choose position for Social Sharing Buttons.', 'mythemeshop'),
						'std' => 'floating',
						'class' => 'green'
						),
					array(
						'id' => 'mts_twitter',
						'type' => 'button_set',
						'title' => __('Twitter', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_gplus',
						'type' => 'button_set',
						'title' => __('Google Plus', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_facebook',
						'type' => 'button_set',
						'title' => __('Facebook Like', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_linkedin',
						'type' => 'button_set',
						'title' => __('LinkedIn', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0'
						),
					array(
						'id' => 'mts_stumble',
						'type' => 'button_set',
						'title' => __('StumbleUpon', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0'
						),
					array(
						'id' => 'mts_pinterest',
						'type' => 'button_set',
						'title' => __('Pinterest', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-bar-chart-o',
				'title' => __('Ad Management', 'mythemeshop'),
				'desc' => __('<p class="description">Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_header_adcode',
						'type' => 'textarea',
						'title' => __('Header Ad', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads in Header Area.', 'mythemeshop')
						),
					array(
						'id' => 'mts_posttop_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Title', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.', 'mythemeshop')
						),
					array(
						'id' => 'mts_posttop_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					array(
						'id' => 'mts_postend_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Content', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.', 'mythemeshop')
						),
					array(
						'id' => 'mts_postend_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-columns',
				'title' => __('Sidebars', 'mythemeshop'),
				'desc' => __('<p class="description">Now you have full control over the sidebars. Here you can manage sidebars and select one for each section of your site, or select a custom sidebar on a per-post basis in the post editor.<br></p>', 'mythemeshop'),
                'fields' => array(
                    array(
                        'id'        => 'mts_custom_sidebars',
                        'type'      => 'group', //doesn't need to be called for callback fields
                        'title'     => __('Custom Sidebars', 'mythemeshop'), 
                        'sub_desc'  => __('Add custom sidebars. <strong style="font-weight: 800;">You need to save the changes to use the sidebars in the dropdowns below.</strong><br />You can add content to the sidebars in Appearance &gt; Widgets.', 'mythemeshop'),
                        'groupname' => __('Sidebar', 'mythemeshop'), // Group name
                        'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_custom_sidebar_name',
            						'type' => 'text',
            						'title' => __('Name', 'mythemeshop'), 
            						'sub_desc' => __('Example: Homepage Sidebar', 'mythemeshop')
            						),	
                                array(
                                    'id' => 'mts_custom_sidebar_id',
            						'type' => 'text',
            						'title' => __('ID', 'mythemeshop'), 
            						'sub_desc' => __('Enter a unique ID for the sidebar. Use only alphanumeric characters, underscores (_) and dashes (-), eg. "sidebar-home"', 'mythemeshop'),
            						'std' => 'sidebar-'
            						),
                            ),
                        ),
                    array(
						'id' => 'mts_sidebar_for_home',
						'type' => 'sidebars_select',
						'title' => __('Homepage', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the homepage.', 'mythemeshop'),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_post',
						'type' => 'sidebars_select',
						'title' => __('Single Post', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the single posts. If a post has a custom sidebar set, it will override this.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_page',
						'type' => 'sidebars_select',
						'title' => __('Single Page', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the single pages. If a page has a custom sidebar set, it will override this.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_archive',
						'type' => 'sidebars_select',
						'title' => __('Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the archives. Specific archive sidebars will override this setting (see below).', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_category',
						'type' => 'sidebars_select',
						'title' => __('Category Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the category archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_tag',
						'type' => 'sidebars_select',
						'title' => __('Tag Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the tag archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_date',
						'type' => 'sidebars_select',
						'title' => __('Date Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the date archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_author',
						'type' => 'sidebars_select',
						'title' => __('Author Archive', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the author archives.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_search',
						'type' => 'sidebars_select',
						'title' => __('Search', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the search results.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_notfound',
						'type' => 'sidebars_select',
						'title' => __('404 Error', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for the 404 Not found pages.', 'mythemeshop'),
                        'args' => array('exclude' => array('sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => ''
						),
                    
                    array(
						'id' => 'mts_sidebar_for_shop',
						'type' => 'sidebars_select',
						'title' => __('Shop Pages', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for Shop main page and product archive pages (WooCommerce plugin must be enabled). Default is <strong>Shop Page Sidebar</strong>.', 'mythemeshop'),
                        'args' => array('exclude' => array('shop-sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => 'shop-sidebar'
						),
                    array(
						'id' => 'mts_sidebar_for_product',
						'type' => 'sidebars_select',
						'title' => __('Single Product', 'mythemeshop'), 
						'sub_desc' => __('Select a sidebar for single products (WooCommerce plugin must be enabled). Default is <strong>Single Product Sidebar</strong>.', 'mythemeshop'),
                        'args' => array('exclude' => array('product-sidebar', 'footer-top', 'footer-top-2', 'footer-top-3', 'footer-top-4', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4')),
                        'std' => 'product-sidebar'
						),
                    ),
				);
//$sections[] = array(
//				'icon' => NHP_OPTIONS_URL.'img/glyphicons/fontsetting.png',
//				'title' => __('Fonts', 'mythemeshop'),
//				'desc' => __('<p class="description"><div class="controls">You can find theme font options under the Appearance Section named <a href="themes.php?page=typography"><b>Theme Typography</b></a>, which will allow you to configure the typography used on your site.<br></div></p>', 'mythemeshop'),
//				);
$sections[] = array(
				'icon' => 'fa fa-list-alt',
				'title' => __('Navigation', 'mythemeshop'),
				'desc' => __('<p class="description"><div class="controls">Navigation settings can now be modified from the <a href="nav-menus.php"><b>Menus Section</b></a>.<br></div></p>', 'mythemeshop')
				);
				
				
	$tabs = array();
    
    $args['presets'] = array();
    include('theme-presets.php');
    
	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function

/*--------------------------------------------------------------------
 * 
 * Default Font Settings
 *
 --------------------------------------------------------------------*/
if(function_exists('register_typography')) { 
  register_typography(array(
  	'Logo Font' => array(
      'preview_text' => 'Logo',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '32px',
      'font_color' => '#222',
      'css_selectors' => '#logo a',
      'additional_css' => 'text-transform: uppercase;',
    ),
  	'primary_navigation_font' => array(
      'preview_text' => 'Primary Navigation Font',
      'preview_color' => 'light',
      'font_family' => 'Raleway',
      'font_variant' => '500',
      'font_size' => '13px',
      'font_color' => '#777',
      'css_selectors' => '.primary-navigation a'
    ),
    'secondary_navigation_font' => array(
      'preview_text' => 'Secondary Navigation Font',
      'preview_color' => 'dark',
      'font_family' => 'Raleway',
      'font_variant' => '700',
      'font_size' => '16px',
      'font_color' => '#fff',
      'css_selectors' => '.secondary-navigation a',
      'additional_css' => 'text-transform: uppercase;',
    ),
    'home_title_font' => array(
      'preview_text' => 'Home Article Title',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_size' => '38px',
	  'font_variant' => '300',
      'font_color' => '#0274BE',
      'css_selectors' => '.latestPost .title a'
    ),
    'single_title_font' => array(
      'preview_text' => 'Single Article Title',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_size' => '38px',
	  'font_variant' => '300',
      'font_color' => '#222',
      'css_selectors' => '.single-title'
    ),
    'content_font' => array(
      'preview_text' => 'Content Font',
      'preview_color' => 'light',
      'font_family' => 'Raleway',
      'font_size' => '16px',
	  'font_variant' => '500',
      'font_color' => '#444444',
      'css_selectors' => 'body'
    ),
    'sidebar_title_font' => array(
      'preview_text' => 'Sidebar Title Font',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '20px',
      'font_color' => '#222222',
      'css_selectors' => '#sidebars .widget h3',
      'additional_css' => 'text-transform: uppercase;',
    ),
	'sidebar_font' => array(
      'preview_text' => 'Sidebar Font',
      'preview_color' => 'light',
      'font_family' => 'Raleway',
      'font_variant' => '500',
      'font_size' => '16px',
      'font_color' => '#444444',
      'css_selectors' => '#sidebars .widget'
    ),
	'top_footer_title_font' => array(
		'preview_text' => 'First Footer Title Font',
		'preview_color' => 'dark',
		'font_family' => 'Roboto Slab',
		'font_variant' => 'normal',
		'font_size' => '18px',
		'font_color' => '#ffffff',
		'css_selectors' => '.footer-widgets h3',
		'additional_css' => 'text-transform: uppercase;',
	) ,
	'top_footer_link_font' => array(
		'preview_text' => 'First Footer Links',
		'preview_color' => 'dark',
		'font_family' => 'Raleway',
		'font_variant' => '500',
		'font_size' => '16px',
		'font_color' => '#999999',
		'css_selectors' => '.f-widget a, footer .wpt_widget_content a, footer .wp_review_tab_widget_content a, footer .wpt_tab_widget_content a, footer .widget .wp_review_tab_widget_content a'
	) ,
	'top_footer_font' => array(
		'preview_text' => 'First Footer Font',
		'preview_color' => 'dark',
		'font_family' => 'Raleway',
		'font_variant' => '500',
		'font_size' => '16px',
		'font_color' => '#777777',
		'css_selectors' => '.footer-widgets, .f-widget .top-posts .comment_num, footer .meta, footer .twitter_time, footer .widget .wpt_widget_content .wpt-postmeta, footer .widget .wpt_comment_content, footer .widget .wpt_excerpt, footer .wp_review_tab_widget_content .wp-review-tab-postmeta, footer .advanced-recent-posts p, footer .popular-posts p, footer .category-posts p'
	) ,
	'copyrights_font' => array(
		'preview_text' => 'Copyrights Font',
		'preview_color' => 'dark',
		'font_family' => 'Raleway',
		'font_variant' => '500',
		'font_size' => '14px',
		'font_color' => '#7e7d7d',
		'css_selectors' => '#copyright-note, #copyright-note a'
	) ,
    'h1_headline' => array(
      'preview_text' => 'H1 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '28px',
      'font_color' => '#222222',
      'css_selectors' => 'h1'
    ),
	'h2_headline' => array(
      'preview_text' => 'H2 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '24px',
      'font_color' => '#222222',
      'css_selectors' => 'h2'
    ),
	'h3_headline' => array(
      'preview_text' => 'H3 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '22px',
      'font_color' => '#222222',
      'css_selectors' => 'h3'
    ),
	'h4_headline' => array(
      'preview_text' => 'H4 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '20px',
      'font_color' => '#222222',
      'css_selectors' => 'h4'
    ),
	'h5_headline' => array(
      'preview_text' => 'H5 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '18px',
      'font_color' => '#222222',
      'css_selectors' => 'h5'
    ),
	'h6_headline' => array(
      'preview_text' => 'H6 Headline',
      'preview_color' => 'light',
      'font_family' => 'Roboto Slab',
      'font_variant' => 'normal',
      'font_size' => '16px',
      'font_color' => '#222222',
      'css_selectors' => 'h6'
    )
  ));
}

?>