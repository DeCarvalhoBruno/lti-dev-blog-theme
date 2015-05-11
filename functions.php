<?php
/**
 * lti functions and definitions
 *
 * @package lti
 */

if (!function_exists('lti_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function lti_setup()
    {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on lti, use a find and replace
         * to change 'lti' to the name of your theme in all the template files
         */
        load_theme_textdomain('lti', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
	    set_post_thumbnail_size( 225, 150, false );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'lti'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            //'comment-form',
            //'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
	        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('lti_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }
endif; // lti_setup
add_action('after_setup_theme', 'lti_setup');

if (!function_exists('lti_font_url')) :
/**
 * Register Open Sans Google font.
 *
 *
 * @return string
 */
function lti_font_url()
{
    $font_url = '';
    if ('off' !== _x('on', 'Open Sans font: on or off', 'lti')) {
        $query_args = array(
            'family' => urlencode('Open Sans:400,300italic'),
            //'subset' => urlencode( 'latin-ext' ),
        );
        $font_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
    }

    return $font_url;
}
endif; // lti_font_url

if (!function_exists('new_excerpt_more')) :
// Replaces the excerpt "more" text by a link
function new_excerpt_more($more)
{
    global $post;
    return '<a class="moretag" href="' . get_permalink($post->ID) . '">' . __('Continue', 'lti') . '</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');
endif; // new_excerpt_more


if (!function_exists('new_widget_tag_cloud_args')) :
/**
 * Defined params for the tag cloud widget
 *
 * @param $args
 * @return mixed
 * @see wp_tag_cloud()
 * @link https://developer.wordpress.org/reference/hooks/widget_tag_cloud_args/
 * @link https://codex.wordpress.org/Function_Reference/wp_tag_cloud
 */
function new_widget_tag_cloud_args($args = '')
{
    $args['number'] = 20;
    $args['largest'] = 20;
    $args['smallest'] = 10;
    $args['order'] = 'RAND';
    $args['unit'] = 'px';
    return $args;
}
add_filter('widget_tag_cloud_args', 'new_widget_tag_cloud_args');
endif; // new_widget_tag_cloud_args


if (!function_exists('lti_widgets_init')) :
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function lti_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'lti'),
        'id' => 'main-sidebar',
        'description' => __('Appears on the right side of the site', 'lti'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
    register_sidebar(array(
        'name' => __('Footer top', 'lti'),
        'id' => 'footer-top',
        'description' => __('Appears on top of the footer section of the site (whole width).', 'lti'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
	register_sidebar(array(
		'name' => __('Footer bottom', 'lti'),
		'id' => 'footer-bottom',
		'description' => __('Appears in the footer section of the site.', 'lti'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	));

}

add_action('widgets_init', 'lti_widgets_init');
endif; // lti_widgets_init

if (!function_exists('lti_scripts')) :
/**
 * Enqueue scripts and styles.
 */
function lti_scripts()
{
    wp_enqueue_style('lti-open-sans', lti_font_url(), array(), null);

    wp_enqueue_style('lti-style', get_stylesheet_uri());
    if (is_singular()) {
        wp_enqueue_script('lti-scripts', get_template_directory_uri() . '/assets/dist/js/single.min.js', array(), '1.0', true);
    } else {
        wp_enqueue_script('lti-scripts', get_template_directory_uri() . '/assets/dist/js/main.min.js', array(), '1.0', true);
    }

//    if (is_singular() && comments_open() && get_option('thread_comments')) {
//        wp_enqueue_script('comment-reply');
//    }
}
add_action('wp_enqueue_scripts', 'lti_scripts');
endif; // lti_scripts

if (!function_exists('lti_body_extra_attributes')) :
/**
 * Adding the scrollspy attributes to the body tag
 *
 * @return string
 */
function lti_body_extra_attributes()
{
    return 'data-spy="scroll" data-target="#navbar-toc"';
}

add_action('after_setup_theme', 'lti_body_extra_attributes');
endif; // lti_body_extra_attributes


if (!function_exists('lti_show_user_profile')) :
	function lti_show_user_profile($user){
		$fields = array();
		$field_info = array(
			array( "lti_github_profile", 'Github profile', '' ),
			array( "lti_codeacademy_profile", 'Code Academy profile', '' ),

		);
		foreach ( $field_info as $field ) {
			$fields[] = sprintf( '<tr>
				<th><label for="%1$s">%2$s</label></th>
				<td>
					<input type="text" name="%1$s" id="%1$s" class="regular-text"
					       value="' . esc_attr( get_the_author_meta( $field[0], $user->ID ) ) . '" /><br />
					<span class="description">%3$s</span>
				</td>
			</tr>', $field[0], ltint( $field[1] ), ltint( $field[2] ) );
		}

		echo sprintf( '
		<h3>%s</h3>
		<table class="form-table">
			%s
		</table>', 'Dev related accounts', implode( PHP_EOL, $fields ) );
	}

	function lti_personal_options_update($userID){
		$field_info = array(
			array( "lti_github_profile" ),
			array( "lti_codeacademy_profile" ),

		);
		if ( current_user_can( 'edit_user', $userID ) ) {
			foreach ( $field_info as $field ) {
				update_user_meta( $userID, $field[0], $_POST[ $field[0] ] );
			}
		}

		return true;
	}
	add_action( 'show_user_profile', 'lti_show_user_profile' );
	add_action( 'edit_user_profile', 'lti_show_user_profile' );
	add_action( 'personal_options_update', 'lti_personal_options_update', 10, 1 );
	add_action( 'edit_user_profile_update', 'lti_personal_options_update', 10, 1 );
	endif;
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/custom-content.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';
/**
 * Personalized meta widget
 */
require get_template_directory() . '/inc/widgets/widget_meta.php';
require get_template_directory() . '/inc/widgets/widget_share.php';

if (!function_exists('lti_load_widget')) :

	function lti_load_widget()
	{
		register_widget('Lti_Meta_Widget');
		register_widget('Lti_Share_Widget');
	}

	add_action('widgets_init', 'lti_load_widget');
endif;
