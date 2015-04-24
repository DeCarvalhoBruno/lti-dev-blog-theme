<?php

if (!class_exists('meta_widget')) :

/**
 * Class meta_widget
 */
class meta_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'meta_widget',
            __('Personalized meta', 'meta_widget_domain'),
            array('description' => __('Simplified meta widget with only RSS feeds', 'meta_widget_domain'),)
        );
    }

    //Front-end
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo '<div class="meta">
            <ul>
              <li><a href="' . get_bloginfo('rss2_url') . '">Entries <abbr title="Really Simple Syndication">RSS</abbr></a></li>
              <li><a href="' . get_bloginfo('comments_rss2_url') . '">Comments <abbr title="Really Simple Syndication">RSS</abbr></a></li>
            </ul>
        </div>';
        echo $args['after_widget'];
    }

    //Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Meta', 'meta_widget_domain');
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
endif;

if (!function_exists('wpb_load_widget')) :

function wpb_load_widget()
{
    register_widget('meta_widget');
}

add_action('widgets_init', 'wpb_load_widget');
endif;
