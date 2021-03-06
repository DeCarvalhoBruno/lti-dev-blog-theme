<?php

if ( ! class_exists( 'Lti_Share_Widget' ) ) :

	/**
	 * Class meta_widget
	 */
	class Lti_Share_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'share_widget',
				__( 'Share buttons', 'lti' ),
				array( 'description' => __( 'Displays share buttons', 'lti' ), 'lti' )
			);
		}

		//Front-end
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			echo Lti_Shares::display();
			echo $args['after_widget'];
		}

		//Backend
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = __( 'Meta', 'meta_widget_domain' );
			}

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
				       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
				       value="<?php echo esc_attr( $title ); ?>"/>
			</p>
		<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			return $instance;
		}

	}

	abstract class Lti_Shares {
		public static function display( $id = "widget-share", $class = "" ) {
			if ( class_exists( 'Lti\Seo\Helpers\Wordpress_Helper' ) ) {
				$helper = \Lti\Seo\LTI_SEO::get_instance()->get_helper();
			} else {
				$helper = null;
			}
			$buttons   = array();
			$buttons[] = new Lti_Button_Facebook( $helper );
			$buttons[] = new Lti_Button_Google_Plus( $helper );
			$buttons[] = new Lti_Button_Twitter( $helper );
			$buttons[] = new Lti_Button_Pinterest( $helper );
			$buttons[] = new Lti_Button_LinkedIn( $helper );
			$buttons[] = new Lti_Button_Email( $helper );
			$html      = '';

			/**
			 * @var Lti_Button $button
			 */
			foreach ( $buttons as $button ) {
				$html .= $button->getHtml();
			}
			if ( ! empty( $class ) ) {
				$class = 'class="' . $class . '"';
			}

			return '<div id="' . $id . '" ' . $class . '><ul class="share-button-group">' . $html . '</ul></div>';
		}
	}

	abstract class Lti_Button {
		protected $url;
		protected $html;
		protected $buttonClass;
		protected $linkTitle;
		protected $newWindow=true;
		/**
		 * @var Lti_Button|\Lti\Seo\Helpers\Wordpress_Helper
		 */
		protected $helper;

		public function __construct( $helper = null ) {
			if ( is_null( $helper ) ) {
				$this->helper = $this;
			} else {
				$this->helper = $helper;
			}

			if ( is_null( $this->linkTitle ) ) {
				$this->linkTitle = "Share on " . ucfirst( $this->buttonClass );
			}

			$newWindow = '';

			if ( $this->newWindow ) {
				$newWindow = 'new-window';
			}

			$this->html = sprintf( '<li class="share-button share-%1$s %4$s">
				<a target="_blank" title="%3$s" rel="nofollow" id="%1$s_share_link" href="%2$s">
					<span class="sr-only">Opens in new window</span>
				<span class="counter"><span class="share-counter"></span></span></a></li>', $this->buttonClass,
				esc_attr( $this->build_url() ), $this->linkTitle, $newWindow );
		}

		public function getHtml() {
			return $this->html;
		}

		protected function build_url() {
			$page_url = $this->helper->get_canonical_url();
			$title    = $this->helper->get_title();

			return sprintf( $this->url, $page_url, $title );
		}

		protected function get_title() {
			return get_bloginfo( 'name' );
		}

		protected function get_description() {
			return get_bloginfo( 'description' );
		}

		protected function get_canonical_url() {
			return get_permalink();
		}

		protected function page_type(){
			return "Frontpage";
		}

		protected function get_social_image_url() {

			if ( has_post_thumbnail( 'single-post-thumbnail' ) ) {
				$image_size = apply_filters( 'lti_seo_image_size_index', 'large' );
				$image_data = $this->get_img( get_post_thumbnail_id(), $image_size );
				if ( isset( $image_data->url ) ) {
					return $image_data->url;
				}
			}

			return "";
		}
	}

	class Lti_Button_Facebook extends Lti_Button {
		protected $buttonClass = 'facebook';
		protected $url = 'http://www.facebook.com/sharer.php?s=100&app_id=%s&p[title]=%s&p[summary]=%s&p[url]=%s&p[images][0]=%s';

		protected function build_url() {
			$app_id      = LTI_FACEBOOK_APP_ID;
			$title       = $this->helper->get_title();
			$description = $this->helper->get_description();
			$page_url    = $this->helper->get_canonical_url();
			$image_url   = $this->helper->get_social_image_url();

			return sprintf( $this->url, $app_id, $title, $description, $page_url, $image_url );
		}
	}

	class Lti_Button_Google_Plus extends Lti_Button {
		protected $buttonClass = 'gplus';
		protected $linkTitle = "Share on Google Plus";
		protected $url = 'https://plus.google.com/share?url=%s';

		protected function build_url() {
			$page_url = ( $this->helper->get_canonical_url() );

			return sprintf( $this->url, $page_url );
		}
	}

	class Lti_Button_Twitter extends Lti_Button {
		protected $buttonClass = 'twitter';
		protected $url = 'http://twitter.com/intent/tweet?url=%s&text=%s';
	}

	class Lti_Button_Pinterest extends Lti_Button {
		protected $buttonClass = 'pinterest';
		protected $url = 'http://pinterest.com/pin/create/button/?url=%s&media=%s&description=%s';

		protected function build_url() {
			$page_url    = $this->helper->get_canonical_url();
			$image_url   = $this->helper->get_social_image_url();
			$description = $this->helper->get_description();

			return sprintf( $this->url, $page_url, $image_url, $description );
		}
	}

	class Lti_Button_Linkedin extends Lti_Button {
		protected $buttonClass = 'linkedin';
		protected $url = 'http://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s';
	}

	class Lti_Button_Email extends Lti_Button {
		protected $buttonClass = 'email';
		protected $linkTitle = "Share by email/Email the author";
		protected $url = 'mailto:%3$s?subject=%2$s&body=%1$s';
		protected $newWindow = false;

		protected function build_url() {
			$page_url = $this->helper->get_canonical_url();
			$title    = "About " . $this->helper->get_title();
			if ( $this->helper->page_type() == "Frontpage" ) {
				$email = "linguisticteam@gmail.com";
			} else {
				$email = $this->helper->get_user_meta_key( 'lti_public_email' );

			}

			return sprintf( $this->url, $page_url, $title, $email );
		}
	}
endif;
