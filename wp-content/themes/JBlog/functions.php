<?php/** * JBlog functions and definitions * * Sets up the theme and provides some helper functions, which are used in the * theme as custom template tags. Others are attached to action and filter * hooks in WordPress to change core functionality. * * Functions that are not pluggable (not wrapped in function_exists()) are * instead attached to a filter or action hook. * * @package WordPress * @subpackage JBlog * @since JBlog 1.0 *//** * JBlog setup. * * Sets up theme defaults and registers the various WordPress features that * Twenty Thirteen supports. * * @uses load_theme_textdomain() For translation/localization support. * @uses add_editor_style() To add Visual Editor stylesheets. * @uses add_theme_support() To add support for automatic feed links, post * formats, and post thumbnails. * @uses register_nav_menu() To add support for a navigation menu. * * @since JBlog 1.0 * * @return void */function jblog_setup() {	// This theme styles the visual editor with editor-style.css to match the theme style.	add_editor_style();	// This theme uses post thumbnails	add_theme_support( 'post-thumbnails' );	// Add default posts and comments RSS feed links to head	add_theme_support( 'automatic-feed-links' );	// Make theme available for translation	// Translations can be filed in the /languages/ directory	load_theme_textdomain( 'jblog', TEMPLATEPATH . '/languages' );	$locale = get_locale();	$locale_file = TEMPLATEPATH . "/languages/$locale.php";	if ( is_readable( $locale_file ) )		require_once( $locale_file );	// This theme uses wp_nav_menu() in one location.	register_nav_menus( array(		'primary' => __( 'Primary Navigation', 'jblog' ),	) );}add_action( 'after_setup_theme', 'jblog_setup' );/** * Modify page menu arguments to show home link. *  * @since JBlog 1.0 *  * @param  array $args Array of menu arguments. * @return array       Modified menu arguments. */function jblog_page_menu_args( $args ) {	$args['show_home'] = true;	return $args;}add_filter( 'wp_page_menu_args', 'jblog_page_menu_args' );if ( ! function_exists( 'jblog_continue_reading_link' ) ) :/** * Function to retrieve the 'continue reading' link for the current post.  * To be used inside the loop. *  * @since JBlog 1.0 *  * @return string HTML string containing a link to the post. */function jblog_continue_reading_link() {	return ' <a href="'. get_permalink() . '">' . __( '&hellip; Continue reading <span class="meta-nav">&rarr;</span>', 'jblog' ) . '</a>';}endif;/** * Replaces "[...]" (appended to automatically generated excerpts) with nothing. * * @since JBlog 1.0 *  * @param  boolean $more * @return string String with one blank space. */function jblog_auto_excerpt_more( $more ) {	return ' ';}add_filter( 'excerpt_more', 'jblog_auto_excerpt_more' );/** * Retrieves a custom excerpt with a 'continue reading' link appended to the end. * * @uses   jblog_continue_reading_link() to retrieve link. * @since JBlog 1.0 *  * @param  string $output The excerpt html. * @return string         Modified excerpt text with 'continue reading' link appended. */function jblog_custom_excerpt_more( $output ) {	if ( ! is_attachment() ) {		$output .= jblog_continue_reading_link();	}	return $output;}add_filter( 'get_the_excerpt', 'jblog_custom_excerpt_more' );/**  * Remove inline styles printed when the gallery shortcode is used. * * @since JBlog 1.0 *  * @param  String $css CSS to remove inline styles. * @return string HTML string with removed CSS. *  */function jblog_remove_gallery_css( $css ) {	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );}add_filter( 'gallery_style', 'jblog_remove_gallery_css' );/** * Initialize and register sidebar. * * @since JBlog 1.0 *  * @return void */function jblog_widgets_init() {	// Area 1, located at the top of the sidebar.	register_sidebar( array(		'name' => __( 'Primary Widget Area', 'jblog' ),		'id' => 'primary-widget-area',		'description' => __( 'The primary widget area', 'jblog' ),		'before_widget' => '<li id="%1$s" class="jblog-widget-container %2$s">',		'after_widget' => '</li>',		'before_title' => '<h3 class="jblog-widget-title">',		'after_title' => '</h3>',	) );}add_action( 'widgets_init', 'jblog_widgets_init' );/** * Remove styles on recent comments. *  * @since JBlog 1.0 *  * @return void */function jblog_remove_recent_comments_style() {	global $wp_widget_factory;	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );}add_action( 'widgets_init', 'jblog_remove_recent_comments_style' );if ( ! function_exists( 'jblog_posted_in' ) ) :/** * Prints HTML with meta information for the current post (category, tags and permalink). * * @since JBlog 1.0 *  * @return void */function jblog_posted_in() {	// Retrieves tag list of current post, separated by commas.	$tag_list = get_the_tag_list( '', ', ' );	if ( $tag_list ) {		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'jblog' );	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'jblog' );	} else {		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'jblog' );	}	// Prints the string, replacing the placeholders.	printf(		$posted_in,		get_the_category_list( ', ' ),		$tag_list,		get_permalink(),		the_title_attribute( 'echo=0' )	);}endif;		 /**  * Prints HTML with meta information for the current post—date/time and author.  *   * @since JBlog 1.0  *   * @param  array $attr    Array of attributes.  * @param  string $content Content of attachment.  * @return string          HTML for image with caption.  */function jblog_img_caption_shortcode($attr, $content = null) {	extract(shortcode_atts(array(		'id'	=> '',		'align'	=> 'alignnone',		'width'	=> '',		'caption' => ''	), $attr));	if ( 1 > (int) $width || empty($caption) )		return $content;	if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';	$align = 'class="' . esc_attr($align) . '" ';	return '<figure ' . $idtag . $align . 'aria-describedby="figcaption_' . $id . '" style="width: ' . (10 + (int) $width) . 'px">' . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';}add_shortcode('wp_caption', 'jblog_img_caption_shortcode');add_shortcode('caption', 'jblog_img_caption_shortcode');function jblog_load_usmap($attr, $content = null) {	wp_deregister_script('jquery');    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js', false, '1.6.2');	wp_enqueue_script('jquery');	wp_enqueue_script('usmap', get_stylesheet_directory_uri() . '/js/usmap.js', array('jquery'), null, true);}add_shortcode('us-map', 'jblog_load_usmap');if ( ! function_exists( 'jblog_posted_on' ) ) :/** * Prints HTML with meta information for the current post—date/time and author. * * @since JBlog 1.0 *  * @return void */function jblog_posted_on() {		printf( __( 'Posted on %2$s by %3$s', 'jblog' ),			'meta-prep meta-prep-author',			sprintf( '<a href="%1$s" rel="bookmark"><time datetime="%2$s" pubdate>%3$s</time></a>',			get_permalink(),			get_the_date('c'),			get_the_date()		),		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',			get_author_posts_url( get_the_author_meta( 'ID' ) ),			sprintf( esc_attr__( 'View all posts by %s', 'jblog' ), get_the_author() ),			get_the_author()		)	);}endif;// Custom Sidebar Widget for displaying recent postsclass JBlog_RecentPosts_Widget extends WP_Widget {	public function __construct() {		parent::__construct(			'jblog_recentposts_widget', // Base ID			'jBlog Recent Posts', // Name			array( 'description' => 'A jBlog Widget') // Args		);	}	public function widget( $args, $instance ) {		$title = "Recent Posts";		echo $args['before_widget'];		if ( ! empty( $title ) )			echo $args['before_title'] . $title . $args['after_title'];			echo "<div class='row'>";				echo "<div class='col-md-12 col-sm-4 col-xs-6'>";					echo "<ul class='jblog-widget-list'>";							echo jblog_get_recent_posts_list(5);					echo "</ul>";				echo "</div>";				echo "<div class='col-md-12 col-sm-4 col-xs-6'>";					echo "<ul class='jblog-widget-list'>";							echo jblog_get_recent_posts_list(5,2);					echo "</ul>";				echo "</div>";				echo "<div class='col-md-12 col-sm-4 col-xs-6 hidden-xs'>";					echo "<ul class='jblog-widget-list'>";							echo jblog_get_recent_posts_list(5,3);					echo "</ul>";				echo "</div>";			echo "</div>";		echo $args['after_widget'];	} 	public function form( $instance ) {		echo "JBlog Recent Posts.";	}	public function update( $new_instance, $old_instance ) {		// processes widget options to be saved	}	}if ( ! function_exists( 'jblog_get_recent_posts_list' ) ) :/** * Retrieves and echos the most recent posts and appends a class to the list item. * This class allows the list item to show the category color. * * @since JBlog 1.0 *  * @param  integer  $num   Number of posts. * @param  integer $paged The page of recent posts. * @return void */function jblog_get_recent_posts_list($num, $paged=1) {	query_posts('posts_per_page='.$num."&paged=".$paged);	// the Loop	while (have_posts()) : the_post();		$category = get_the_category();		?>		<li class="<?php echo $category[0]->slug; ?>_color"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>	<?php endwhile;	wp_reset_query();}endif;/** * Register the JBlog custom widget for recent posts. *  * @since JBlog 1.0 *  * @return void */function register_jblog_widget() {    register_widget( 'JBlog_RecentPosts_Widget' );}add_action( 'widgets_init', 'register_jblog_widget' );/** * Sets up a menu item on the WordPress backend to access JBlog Theme Settings. * * @since JBlog 1.0 *  * @return void */function jblog_setup_theme_admin_menus() {    add_submenu_page('themes.php',         'Theme Settings', 'Theme Settings', 'manage_options',         'theme-settings', 'jblog_custom_theme_settings_page'); }add_action("admin_menu", "jblog_setup_theme_admin_menus");/** * Prints and processes the JBlog Theme Settings page. * * @since JBlog 1.0 *  * @return void */function jblog_custom_theme_settings_page() {	$categories = get_categories();	if (isset($_POST["options_updated"])) {		foreach ($categories as $category) {			$color = $_POST[$category->slug.'_color'];			update_option($category->slug.'_color', $color);		}		update_option('header_name', $_POST['header_name']); 		update_option('copyright_text', $_POST['copyright_text']); 		update_option('tagline', $_POST['tagline']);		update_option('github', $_POST['github']);		update_option('twitter', $_POST['twitter']);		update_option('linkedin', $_POST['linkedin']);		jblog_write_custom_styles($categories);	}	require_once("theme-settings.php");}/** * Writes custom CSS using theme settings. * * @since JBlog 1.0 *  * @param  array $categories Array of categories. * @return void */function jblog_write_custom_styles($categories) {	if (!$categories) {		$categories = get_categories();	}	$css = "";	$smallcss = "@media (max-width: 767px) { ";	foreach ($categories as $category) {		$color = get_option($category->slug.'_color');		$css .= ".nav-justified .".$category->slug."_color:hover a, .current-menu-item.".$category->slug."_color a, .current-menu-parent.".$category->slug."_color a, li.".$category->slug."_color, .".$category->slug."_color:hover a { color:".$color."!important; } ";		$smallcss .= ".category-".$category->slug." .jblog-archive-detail:not(.jblog-no-thumb) { background: rgba(".hex2rgb($color).") }";	}	$file = get_stylesheet_directory()."/css/custom-style.css";	$smallcss .= " }";	file_put_contents($file, $css." ".$smallcss);}add_action( 'wp_enqueue_scripts', 'jblog_write_custom_styles' );/** * Add custom classes to navigation menu items so that they reflect the Theme Settings colors. *  * @since JBlog 1.0 * @param  array $classes Array of CSS classes. * @param  array $item    Navigation menu item. * @return array          Modified array of CSS classes. */function jblog_nav_class_colors($classes, $item){	$slug = get_category($item->object_id)->slug;	if ($slug) {		$classes[] = $slug.'_color';	}    return $classes;}add_filter('nav_menu_css_class' , 'jblog_nav_class_colors' , 10 , 2);/** * Ajax response function to lod more posts on the home index page. * * @since JBlog 1.0 *  * @return void */function jblog_load_more() {    $page = $_GET['page'];    	// setup your query to get what you want    query_posts('post_status=publish&posts_per_page=9&paged='.$page);        // the Loop	while (have_posts()) : the_post();		jblog_printPost("homepage");    endwhile;    // Reset Query    wp_reset_query();    die();}add_action('wp_ajax_jblog_load_more', 'jblog_load_more');add_action('wp_ajax_nopriv_jblog_load_more', 'jblog_load_more');if ( ! function_exists( 'jblog_printPost' ) ) :/** * Print a post in a given templated format. * * @since JBlog 1.0 *  * @param  string $area The area the post will be printed (corresponds to template). * @return void */function jblog_printPost($area) {	if ($area == "homepage") {		require("homepage-post.php");	}}endif;/** * Modify the excerpt length. * * @since JBlog 1.0 *  * @return integer Excerpt length */function jblog_custom_excerpt_length( ) {	return 80;}add_filter( 'excerpt_length', 'jblog_custom_excerpt_length', 999 );if ( ! function_exists( 'jblog_comments' ) ) :/** * Customize the jblog comments fields with HTML5 form elements. * * @since JBlog 1.0 *  * @return array Comment fields. */function jblog_comments() {	$req = get_option('require_name_email');	$fields =  array(		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .		            '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "What can we call you?"' . ( $req ? ' required' : '' ) . '/></p>',		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .		            '<input class="form-control" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="How can we reach you?"' . ( $req ? ' required' : '' ) . ' /></p>',		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .		            '<input class="form-control" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="Have you got a website?" /></p>'	);	return $fields;}endif;if ( ! function_exists( 'jblog_commentfield' ) ) :/** * Custom comment field. *  * @since JBlog 1.0 *  * @return string HTML commentfield string. */function jblog_commentfield() {		$commentArea = '<p class="comment-form-comment"><label style="display:none;" for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="What\'s on your mind?"	></textarea></p>';	return $commentArea;}endif;if ( ! function_exists( 'jblog_comment_args' ) ) :/** * Get custom comment arguments. * * @since JBlog 1.0 *  * @return array Comment form arguments. */function jblog_comment_args() {	$args = array("fields"=>jblog_comments(), "comment_field"=> jblog_commentfield(), "comment_notes_after" => "");		return $args;}endif;/** * Add scripts and styles necessary for running the JBlog theme. * * @since JBlog 1.0 *  * @return void */function jblog_scripts() {	// Styles		wp_register_style('bootstrap-style', get_stylesheet_directory_uri() . '/css/bootstrap.css');	wp_register_style('bootstrap-theme', get_stylesheet_directory_uri() . '/css/bootstrap-theme.css', array('bootstrap-style'));	wp_enqueue_style('bootstrap-style');	wp_enqueue_style('bootstrap-theme');	wp_enqueue_style('fonts', get_stylesheet_directory_uri() . '/fonts/stylesheet.css');	wp_enqueue_style('jblog-style', get_stylesheet_uri(), array('bootstrap-theme'));	wp_enqueue_style('jblog-custom', get_stylesheet_directory_uri()."/css/custom-style.css",array('jblog-style'));	wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');		// Scripts	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.js', array('jquery'), null,true);	wp_enqueue_script('modernizr', get_stylesheet_directory_uri() . '/js/modernizr.js', array('jquery'), null,true);	wp_enqueue_script('selectivizr', get_stylesheet_directory_uri() . '/js/selectivizr.js', array('jquery'), null, true);	wp_enqueue_script('imgLiquid', get_stylesheet_directory_uri() . '/js/imgLiquid.js', array('jquery'), null, true);	wp_enqueue_script('jblog', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);}add_action( 'wp_enqueue_scripts', 'jblog_scripts');/** * Tells BWP Minify plugin to ignore the font-awesome stylesheet. * * @since JBlog 1.0 *  * @return array Array of stylesheets to ignore. */function jblog_style_ignore() {	return array('font-awesome');}add_filter("bwp_minify_style_ignore", "jblog_style_ignore");if ( ! function_exists( 'hex2rgb' ) ) :/** * Utility function to change a hex color to rgb. * * @since JBlog 1.0 *  * @param  string $hex A hex color. * @return string RGB color, comma separated. */function hex2rgb($hex) {   $hex = str_replace("#", "", $hex);   if(strlen($hex) == 3) {      $r = hexdec(substr($hex,0,1).substr($hex,0,1));      $g = hexdec(substr($hex,1,1).substr($hex,1,1));      $b = hexdec(substr($hex,2,1).substr($hex,2,1));   } else {      $r = hexdec(substr($hex,0,2));      $g = hexdec(substr($hex,2,2));      $b = hexdec(substr($hex,4,2));   }   $rgb = array($r, $g, $b, .8);   return implode(",", $rgb); // returns the rgb values separated by commas   //return $rgb; // returns an array with the rgb values}endif;?>