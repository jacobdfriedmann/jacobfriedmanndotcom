<?php
/**
 * Theme functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, jboil_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'jboil_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage JBoil
 * 
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run jboil_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'jboil_setup' );

if ( ! function_exists( 'jboil_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override jboil_setup() in a child theme, add your own jboil_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * 
 */
function jboil_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'jboil', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'jboil' ),
	) );

	
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * 
 */
function jboil_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'jboil_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * 
 * @return int
 */
function jboil_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'jboil_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * 
 * @return string "Continue Reading" link
 */
function jboil_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'jboil' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and jboil_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * 
 * @return string An ellipsis
 */
function jboil_auto_excerpt_more( $more ) {
	return ' &hellip;' . jboil_continue_reading_link();
}
add_filter( 'excerpt_more', 'jboil_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * 
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function jboil_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= jboil_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'jboil_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in JBoil's style.css.
 *
 * 
 * @return string The gallery style filter, with the styles themselves removed.
 */
function jboil_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'jboil_remove_gallery_css' );


/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override jboil_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * 
 * @uses register_sidebar
 */
function jboil_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'jboil' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'jboil' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'jboil' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'jboil' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'jboil' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'jboil' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'jboil' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'jboil' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'jboil' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'jboil' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'jboil' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'jboil' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running jboil_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'jboil_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * 
 */
function jboil_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'jboil_remove_recent_comments_style' );



if ( ! function_exists( 'jboil_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * 
 */
function jboil_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'jboil' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'jboil' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'jboil' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;




/**
 * JBoil functions and definitions
 *
 * This additional code adds in HTML5 functionality to the JBoil theme.
 * You will still require the orginal functions.php (above) which has not
 * been altered.
 *
 * The code below overwrites or extends some of the JBoil functionality.
 *
 * For more information on see 
 * http://www.smashingmagazine.com/2011/02/22/using-html5-to-transform-wordpress-twentyten-theme/
 *
 * and
 * http://twentytenfive.com
 *
 * @package WordPress
 * @subpackage JBoil
 * */


/**
 * Shortcodes.
 *
 * The supported attributes for the shortcode are 'id', 'align', 'width', and
 * 'caption'.
 *
 * 
 */

add_shortcode('wp_caption', 'jboil_img_caption_shortcode');
add_shortcode('caption', 'jboil_img_caption_shortcode');

/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * 
 */
function jboil_img_caption_shortcode($attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;


if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';
$align = 'class="' . esc_attr($align) . '" ';

  return '<figure ' . $idtag . $align . 'aria-describedby="figcaption_' . $id . '" style="width: ' . (10 + (int) $width) . 'px">' 
  . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}


if ( ! function_exists( 'jboil_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * 
 */
function jboil_posted_on() {
		printf( __( 'Posted on %2$s by %3$s', 'jboil' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" rel="bookmark"><time datetime="%2$s" pubdate>%3$s</time></a>',
			get_permalink(),
			get_the_date('c'),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'jboil' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;
/**
 * Adds custom Image size(s)
 *
 * 
 */
add_action( 'init', 'my_register_image_sizes' );

function my_register_image_sizes() {

	add_image_size( 'post_block', 300, 300, true );
	add_image_size( 'single' , 610, 300, true );
	add_image_size( 'loop', 250, 250, true );
}

function get_recent_posts_list($num) {

 query_posts('posts_per_page='.$num);

    // initialsise your output

    // the Loop
   while (have_posts()) : the_post();

    $category = get_the_category();
	$id = $category[0]->term_id;
	if ( $id == get_option('color1_cat') ) {
		$color = 'color1';
	}
	elseif ($id == get_option('color2_cat') ) {
		$color = 'color2';
	}
	elseif ($id == get_option('color3_cat') ) {
		$color = 'color3';
	}
	elseif ($id == get_option('color4_cat') ) {
		$color = 'color4';
	}
	elseif ($id == get_option('color5_cat') ) {
		$color = 'color5';
	}
	
	?>
	<li class="<?php echo $color; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

  <?php endwhile;
  wp_reset_query();
  
 }

function setup_theme_admin_menus() {
    add_submenu_page('themes.php', 
        'Theme Settings', 'Theme Settings', 'manage_options', 
        'theme-settings', 'custom_theme_settings_page'); 
}

// This tells WordPress to call the function named "setup_theme_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_theme_admin_menus");

function custom_theme_settings_page() {
	if (isset($_POST["options_updated"])) {
    		update_option('color1', $_POST['color1']);
		update_option('color2', $_POST['color2']);
		update_option('color3', $_POST['color3']);
		update_option('color4', $_POST['color4']);
		update_option('color5', $_POST['color5']);
		update_option('color1_cat', $_POST['color1_cat']);
		update_option('color2_cat', $_POST['color2_cat']);
		update_option('color3_cat', $_POST['color3_cat']);
		update_option('color4_cat', $_POST['color4_cat']);
		update_option('color5_cat', $_POST['color5_cat']);
		update_option('header_name', $_POST['header_name']); 
		update_option('copyright_text', $_POST['copyright_text']); 
		update_option('tagline', $_POST['tagline']);
		update_option('facebook', $_POST['facebook']);
		update_option('twitter', $_POST['twitter']);
		update_option('linkedin', $_POST['linkedin']); 
	}


?>
   	<script>
	jQuery(document).ready(function() {
		jQuery("#color1_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color1_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
		jQuery("#color2_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color2_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
		jQuery("#color3_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color3_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
		jQuery("#color4_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color4_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
		jQuery("#color5_cat option").each(function()
		{
    			if (jQuery(this).val() == <?php echo get_option('color5_cat'); ?>) {
				jQuery(this).attr('selected', 'selected');
			}
		});
	});
	</script>
    <div class="wrap">
    <?php screen_icon('themes'); ?> <h2>Theme Settings</h2>

    <form method="POST" action="">
       

        <h3>Color Scheme</h3>
	<p class="description">Enter colors in hex form (i.e. #FFFFF). Select a category to associate the color with.</p>
        <ul id="color-scheme-list">
        	<li>
        		<label for="color1">Color 1 (Hex):</label>
        		<input type="text" name="color1" value="<? echo get_option('color1'); ?>"/><? wp_dropdown_categories('name=color1_cat'); ?>
    		</li>
    		<li>
        		<label for="color2">Color 2 (Hex):</label>
        		<input type="text" name="color2" value="<? echo get_option('color2'); ?>"/><? wp_dropdown_categories('name=color2_cat'); ?>
    		</li>
    		<li>
        		<label for="color3">Color 3 (Hex):</label>
        		<input type="text" name="color3" value="<? echo get_option('color3'); ?>"/><? wp_dropdown_categories('name=color3_cat'); ?>
    		</li>
    		<li>
        		<label for="color4">Color 4 (Hex):</label>
        		<input type="text" name="color4" value="<? echo get_option('color4'); ?>"/><? wp_dropdown_categories('name=color4_cat'); ?>
    		</li>
    		<li>
        		<label for="color5">Color 5 (Hex):</label>
        		<input type="text" name="color5" value="<? echo get_option('color5'); ?>"/><? wp_dropdown_categories('name=color5_cat'); ?>
    		</li>
        </ul>

	<h3>Blog Title and Footer</h3>

	<label for="header_name">Blog Name or Logo Element: </label><input type="text" name="header_name" value="<?php echo get_option('header_name'); ?>" /><br>

	<label for="copyright_text">Copyright Text: </label><input type="text" name="copyright_text" value="<?php echo get_option('copyright_text'); ?>" /><br>

	<label for="tagline">Footer Tagline: </label><input type="text" name="tagline" value="<?php echo get_option('tagline'); ?>" /><br>

	<h3>Social Media Links</h3>
	
	<label for="facebook">facebook.com/</label><input type="text" name="facebook" value="<?php echo get_option('facebook'); ?>" /><br>
	<label for="twitter">twitter.com/</label><input type="text" name="twitter" value="<?php echo get_option('twitter'); ?>" /><br>
	<label for="linkedin">linkedin.com/</label><input type="text" name="linkedin" value="<?php echo get_option('linkedin'); ?>" /><br>
	
      
        <input type="hidden" name="options_updated" />

       	<input type="submit" name="submit" value="Submit" class="button button-primary"/>
         
    </form>
    
    

</div>

<?php
}



add_filter('nav_menu_css_class' , 'nav_class_colors' , 10 , 2);
function nav_class_colors($classes, $item){
     $category1 = get_cat_name(get_option('color1_cat'));
     $category2 = get_cat_name(get_option('color2_cat'));
     $category3 = get_cat_name(get_option('color3_cat'));
     $category4 = get_cat_name(get_option('color4_cat'));
     $category5 = get_cat_name(get_option('color5_cat'));
     if($item->title == $category1){
             $classes[] = "color1";
     }
     elseif ($item->title == $category2){
             $classes[] = "color2";
     }
     elseif ($item->title == $category3){
             $classes[] = "color3";
     }
     elseif ($item->title == $category4){
             $classes[] = "color4";
     }
     elseif ($item->title == $category5){
             $classes[] = "color5";
     }
     return $classes;
}

function loadMore() {
    $posts = $_GET['posts'] + 3;

    // setup your query to get what you want
    query_posts('posts_per_page='.$posts);

    // initialsise your output

    // the Loop
   while (have_posts()) : the_post();
$category = get_the_category();
$name =  $category[0]->term_id;
if ($name == get_option('color1_cat')) {
	$color = 'color1';
}
elseif ($name == get_option('color2_cat')) {
	$color = 'color2';
}
elseif ($name == get_option('color3_cat')) {
	$color = 'color3';
}
elseif ($name == get_option('color4_cat')) {
	$color = 'color4';
}
else {
	$color = 'color5';
}
 ?>


<div class="post_block <?php echo $color; ?>" onclick="window.location.href='<?php the_permalink(); ?>'">

<?php echo the_post_thumbnail( 'post_block' ); ?>

 <!-- Display the Title as a link to the Post's permalink. -->
 
 <div class="post_block_content">

 <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>





 <!-- Display the Post's content in a div box. -->

 <div class="entry">
   <?php the_excerpt(); ?>
 </div>


 <!-- Display a comma separated list of the Post's Categories. -->

 <p class="post_block_category"><?php the_category(', '); ?></p>
 </div> <!-- closes the first div box --></a>


 <!-- Stop The Loop (but note the "else:" - see next line). -->
</div>
<?php



    endwhile;

    // Reset Query
    wp_reset_query();

    die();

}
 
add_action('wp_ajax_loadMore', 'loadMore');
add_action('wp_ajax_nopriv_loadMore', 'loadMore');

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Customise the JBoil comments fields with HTML5 form elements
 *
 *	Adds support for 			placeholder
 *						required
 *						type="email"
 *						type="url"
 *
 * 
 */
function jboil_comments() {

	$req = get_option('require_name_email');

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "What can we call you?"' . ( $req ? ' required' : '' ) . '/></p>',
		            
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="How can we reach you?"' . ( $req ? ' required' : '' ) . ' /></p>',
		            
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		            '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="Have you got a website?" /></p>'

	);
	return $fields;
}


function jboil_commentfield() {	

	$commentArea = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="What\'s on your mind?"	></textarea></p>';
	
	return $commentArea;

}


add_filter('comment_form_default_fields', 'jboil_comments');
add_filter('comment_form_field_comment', 'jboil_commentfield');

add_action( 'admin_menu', 'jstore_plugin_menu' );

function jstore_plugin_menu() {
	add_menu_page( 'jStore Options', 'jStore', 'manage_options', 'jstore', 'jstore_options' );
	add_submenu_page('jstore', 'jStore Options', 'jStore Options', 'manage_options', 'jstore-options', 'jstore_options');
	add_submenu_page('jstore', 'Manage Products', 'Manage Products', 'manage_options', 'jstore-manage', 'jstore_manage');
	add_submenu_page('jstore', 'Edit Product', 'Add New Product', 'manage_options', 'jstore-edit', 'jstore_edit');
}

function jstore_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	if (isset($_POST["options_updated"])) {
		update_option('productpage', $_POST['productpage']);
		for ($i = 0; $i <= $_POST['options_updated']; $i++) {
			$categories[$i] = $_POST['category_'.$i];
		}
		update_option('jstorecategories', $categories);
		
	} ?>
	 <div class="wrap">
    	<?php screen_icon('themes'); ?> <h2>jStore Options</h2>

    	<form method="POST" action="">
    		<h3>Product Page</h3>
    			<p class="description">Enter the complete url to the product page in which the product shortcode has been added.</p>
    			<label for="productpage">Product Page Url: </label><input type="text" name="productpage" value="<?php echo get_option('productpage'); ?>" /><br>
    		<div>
    		<div id="jstore-options-categories">
    		<h3>Categories</h3>
    			<p class="description">Choose categories of products.</p>
    			<?php $categories = get_option('jstorecategories');
    			$i = 0;
    			if ($categories) {
    				
    				foreach ($categories as $category) {
    					?> <label for="category_<?php echo $i ?>">Category <?php echo $i ?>: </label><input type="text" name="category_<?php echo $i ?>" value="<?php echo $category; ?>" /><br>
    				<?php 
    					$i = $i + 1;
    				}
    			} ?>
    		</div>		
    		<a onclick="add_category_field()">+ Add Another Category</a>
    		<input type="hidden" id="options_updated" name="options_updated" value="<?php echo $i ?>" />
       		<input type="submit" name="submit" value="Submit" class="button button-primary"/>
    	</form>
    	
    	<script type = "text/javascript">
    			jstorei = <?php echo $i; ?>;
    			function add_category_field() {
    				jQuery('#jstore-options-categories').append("<label for='category_"+jstorei+"'>Category "+jstorei+": </label><input type='text' name='category_"+jstorei+"' value='' /><br>");	
    				jQuery('#options_updated').val(jstorei);
    				jstorei = jstorei + 1;
    			}
    	</script>
    	
    </div>
    <?php
}

function jstore_edit() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	// do this!
	if (isset($_POST["options_updated"])) {
		
		
	} 
	// the rest should be o.k.
	
	global $wpdb;
	$product_table = $wpdb->prefix."products";
	$meta_table = $wpdb->prefix."product_meta";
	$id = $_GET['id'];
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', WP_PLUGIN_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
	wp_enqueue_style('thickbox');
	
	if ($id) {
		$product = $wpdb->get_row("SELECT * FROM $product_table WHERE ID = ".$id);
		$categories = $wpdb->get_results("SELECT meta_value FROM $meta_table WHERE product_ID = ".$id." AND meta_key = 'category'");
		$description = $wpdb->get_results("SELECT meta_value FROM $meta_table WHERE product_ID = ".$id." AND meta_key = 'description'");
	} ?>
	
	<form method="POST" action="" enctype="multipart/form-data">
    		<div id="jstore-edit-basic">
    		<h3>Basic Product Info</h3>
    			<p class="description">Basic information about the product.</p>
    			<label for="product-name">Name: </label><input type="text" name="product-name" value="<?php echo $product->name; ?>" /><br>
    			<label for="product-price">Price: </label><input type="text" name="product-price" value="<?php echo $product->price; ?>" /><br>
    		</div>
    		
    		<div id="jstore-edit-image">
    		<h3>Product Image</h3>
    			<table>
    			<tr valign="top">
				<th scope="row">Upload Image</th>
				<td><label for="upload_image">
					<input id="upload_image" type="text" size="36" name="upload_image" value="" />
					<input id="upload_image_button" type="button" value="Upload Image" />
					<br />Enter an URL or upload an image for the banner.
				</label></td>
				</tr>
				</table>
    		</div>
    	
    		<div id="jstore-edit-categories">
    		<h3>Categories</h3>
    			<p class="description">Choose categories for the products.</p>
    			<?php $allcategories = get_option('jstorecategories');
    			if ($allcategories) {
    				
    				foreach ($allcategories as $category) {
    					?> <input type="checkbox" name="categories[]" value="<?php echo $category; ?>" />&nbsp&nbsp<label for="categories[]"><?php echo $category; ?></label><br>
    				<?php 
    				}
    				
    			} ?>
    		</div>
    		
    		<div id="jstore-edit-description">
    		<h3>Description</h3>
    			<p class="description">Add descriptions.</p>
    			<?php
    			$i = 0;
    			if ($description) {
    				
    				foreach ($description as $descriptor) {
    					?> <label for="description_<?php echo $i ?>">Description <?php echo $i ?>: </label><input type="text" name="description_<?php echo $i ?>" value="<?php echo $descriptor; ?>" /><br>
    				<?php 
    				$i = $i +1;
    				}
    			} ?>
    		</div>
    		<a onclick="add_description_field()">+ Add Another Description</a>
    		
    		<div id="jstore-edit-featured">
    		<h3>Featured?</h3>
    			<p class="description">Is this a featured product?</p>
    			<label for="featured">Featured?: </label><input type="checkbox" name="featured" value="yes" /><br>
    			<label for="featured-price">Featured Price: </label><input type="text" name="featured-price" value="<?php echo $product->feat_price; ?>" /><br>
    			<label for="featured-desc">Featured Description: </label><input type="text" name="featured-desc" value="<?php echo $product->feat_desc; ?>" /><br>
    		</div>
    		
    		<div id="jstore-edit-sold">
    		<h3>Sold?</h3>
    			<p class="description">Has this product been sold?</p>
    			<label for="sold">Sold?: </label><input type="checkbox" name="sold" value="yes" /><br>
    		</div>
    		
    		<input type="hidden" id="options_updated" name="options_updated" value="<?php echo $i; ?>" />
    		<input type="hidden" id="product_id" name="product_id" value="<?php echo $product->ID; ?>" />
       		<input type="submit" name="submit" value="Submit" class="button button-primary"/>
    </form>
    <script type = "text/javascript">
    			jstoreediti = <?php echo $i; ?>;
    			function add_description_field() {
    				jQuery('#jstore-edit-description').append("<label for='description_"+jstoreediti+"'>Description "+jstoreediti+": </label><input type='text' name='description_"+jstoreediti+"' value='' /><br>");	
    				jQuery('#options_updated').val(jstoreediti);
    				jstoreediti = jstoreediti + 1;
    			}
    			jQuery(document).ready(function() {

					jQuery('#upload_image_button').click(function() {
 						formfield = jQuery('#upload_image').attr('name');
 						tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 						return false;
					});

					window.send_to_editor = function(html) {
 						imgurl = jQuery('img',html).attr('class');
 						id = imgurl.replace(/(.*?)wp-image-/, '');
 						jQuery('#upload_image').val(id);
 						tb_remove();
					}

				});
    </script>
	<?php
	
}

function jstore_manage() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
}

?>