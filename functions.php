<?php
/**
 * lti functions and definitions
 *
 * @package lti
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

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
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('lti_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }
endif; // lti_setup
add_action('after_setup_theme', 'lti_setup');

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

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more)
{
    global $post;
    return '<a class="moretag" href="' . get_permalink($post->ID) . '">' . __('Continue', 'lti') . '</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');

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


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function lti_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'lti'),
        'id' => 'sidebar-1',
        'description' => __('Appears on the right side of the site', 'lti'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'lti'),
        'id' => 'sidebar-2',
        'description' => __('Appears in the footer section of the site.', 'lti'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
    register_sidebar(array(
        'name' => __('Footer Widget Area2', 'lti'),
        'id' => 'sidebar-3',
        'description' => __('Appears in the footer section of the site.', 'lti'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
}

add_action('widgets_init', 'lti_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function lti_scripts()
{
    wp_enqueue_style('lti-open-sans', lti_font_url(), array(), null);

    wp_enqueue_style('lti-style', get_stylesheet_uri());

    //wp_enqueue_script( 'lti-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
    //wp_enqueue_script( 'lti-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
    if (is_singular()) {
        wp_enqueue_script('lti-scripts', get_template_directory_uri() . '/js/dist/single.min.js', array(), '1.0', true);
    } else {
        wp_enqueue_script('lti-scripts', get_template_directory_uri() . '/js/dist/main.min.js', array(), '1.0', true);

    }
//    wp_localize_script(
//        'lti-scripts',
//        'code_prettify_settings',
//        array(
//            'base_url' => get_template_directory_uri().'/js/dist/prettify',
//        )
//    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'lti_scripts');

/**
 * Adding the scrollspy attributes to a body tag if we're in a single post,
 * where we want to display a table of contents if we want to.
 *
 * @return string
 */
function lti_body_extra_attributes()
{
    if (is_singular('post')) {
        return 'data-spy="scroll" data-target="#navbar-toc"';
    }
    return '';
}

add_action('after_setup_theme', 'lti_body_extra_attributes');

if (!function_exists('get_sidebar_with_scrollspy')) :

    /**
     * This functions grabs every h1 to h6 element in a post content and displays it as a table of content
     * of sorts that follows the current scroll position.
     *
     * Relies on the scrollspy and affix functions from twitter bootstrap.
     *
     * Nesting hasn't been tested beyond the two levels I required for my initial setup. I don't think
     * more than two levels would render very well on such a narrow space.
     *
     */
    function get_sidebar_with_scrollspy()
    {

        $content = get_the_content();

        //We load the post content into a DOMDocument object so we can get to the elements we want quickly
        $s = new DOMDocument();
        @$s->loadHTML($content);
        $xpath = new DOMXPath($s);
        //We run an XPath query asking for all elements with a toc class
        $tags = $xpath->query('//*[@class="toc"]');
        $html = '';
        $htmlLevel = 0;
        $m = [];
        if ($tags->length > 0) {
            //We want the table of contents to have a fixed position when we've scolled 250px from the top
            //until we're 650px from the bottom of the screen
            $html .= '<div id="affix-wrapper"><nav id="navbar-toc" role="navigation">';
            foreach ($tags as $tag) {
                //we try to find h1 to h6 but we just capture the number
                preg_match("#(?<=h)[1-6]#", $tag->tagName, $m);
                if (isset($m[0])) {
                    $level = $m[0];
                    if ($level == $htmlLevel) {
                        if ($htmlLevel > 0) {
                            $html .= "</li>\n";
                        }
                    } elseif ($level > $htmlLevel) {
                        $html .= '<ul class="nav">';
                    } elseif ($level < $htmlLevel) {
                        $html .= str_repeat("</li></ul>\n", $htmlLevel - $level) . "</li>";
                    }
                    $htmlLevel = $level;

                    $id = $tag->attributes->getNamedItem('id');
                    if (is_object($id)) {
                        $value = $id->value;
                    } else {
                        $value = "";
                    }
                    $html .= '<li><a href="#' . $value . '">' . trim($tag->nodeValue) . '</a>';

                }
            }
            $html .= str_repeat('</li></ul>', $htmlLevel) . '</li>';
            $html .= "<ul class=\"nav top-marker\"><li><a href=\"#\">Top</a></li></ul></nav></div>\n";
        }
        echo $html;

    }
endif;
/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
require get_template_directory() . '/inc/widget_meta.php';
