<?php

if (!class_exists('Lti_Share_Widget')) :

/**
 * Class meta_widget
 */
class Lti_Share_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'share_widget',
            __('Share buttons', 'lti'),
            array('description' => __('Displays share buttons', 'lti'),'lti')
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

		echo self::display();
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

	public static function display($id="widget-share"){
		return '<div id="'.$id.'">
		<ul class="share-button-group">
			<li class="share-button share-facebook new-window">
				<a target="_blank" id="facebook_share_link"
				   href="#"> <span
						class="sr-only">Opens in new window</span>
					<span class="counter"><span class="share-counter"></span></span>
				</a></li>
			<li class="share-button share-gplus new-window">
				<a target="_blank" id="gplus_share_link"
				   href="#"> <span class="sr-only">Opens in new window</span>

					<span class="counter"><span class="share-counter"></span></span>
				</a></li>
			<li class="share-button share-twitter new-window">
				<a target="_blank" id="twitter_share_link"
				   href="#"> <span class="sr-only">Opens in new window</span>

					<span class="counter"><span class="share-counter"></span></span>
				</a></li>
			<li class="share-button share-pinterest new-window">
				<a target="_blank" id="pinterest_share_link"
				   href="#"> <span
						class="sr-only">Opens in new window</span>

					<span class="counter"><span class="share-counter"></span></span>
				</a></li>
			<li class="share-button share-linkedin new-window">
				<a target="_blank" id="linkedin_share_link"
				   href="#"> <span
						class="sr-only">Opens in new window</span>

					<span class="counter"><span class="share-counter"></span></span>
				</a></li>
			<li class="share-button share-email">
				<a target="_blank" id="email_share_link" href="#">
					<span class="sr-only">Opens in new window</span>

					<span class="counter"><span class="share-counter"></span></span>
				</a></li>
		</ul>
        </div>';
	}
}
endif;
