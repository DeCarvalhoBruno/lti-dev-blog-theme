<?php

if ( ! function_exists( 'get_sidebar_with_scrollspy' ) ) :

	/**
	 * This functions grabs every h1 to h6 element in a post content and displays it as a table of content
	 * of sorts that follows the current scroll position.
	 *
	 * Relies on the scrollspy and affix functions from twitter bootstrap.
	 *
	 * Nesting hasn't been tested beyond the two levels I required for my initial setup. I don't think
	 * more than two levels would render very well in such a narrow space.
	 *
	 */
	function get_sidebar_with_scrollspy() {
		$content = get_the_content();

		//We load the post content into a DOMDocument object so we can get to the elements we want quickly
		$s = new DOMDocument();
		@$s->loadHTML( $content );
		$xpath = new DOMXPath( $s );
		//We run an XPath query asking for all elements with a toc class
		$tags      = $xpath->query( '//*[@class="toc"]' );
		$html      = '';
		$htmlLevel = $level = 0;
		$m         = [ ];
		if ( $tags->length > 0 ) {
			$html .= '<div id="affix-wrapper"><nav id="navbar-toc" role="navigation">';
			foreach ( $tags as $tag ) {
				//we try to find h1 to h6 but we just capture the number
				preg_match( "#(?<=h)[1-6]#", $tag->tagName, $m );
				if ( isset( $m[0] ) ) {
					$level = $m[0] - 1;
					if ( $level == $htmlLevel ) {
						if ( $htmlLevel > 0 ) {
							$html .= "</li>\n";
						}
					} elseif ( $level > $htmlLevel ) {
						$html .= '<ul class="nav">';
						$htmlLevel = $htmlLevel + ( $level - $htmlLevel );
					} elseif ( $level < $htmlLevel ) {
						$html .= str_repeat( "</li></ul>\n", $htmlLevel - $level ) . "</li>";
						$htmlLevel = $htmlLevel + ( $level - $htmlLevel );
					}

					$id = $tag->attributes->getNamedItem( 'id' );
					if ( is_object( $id ) ) {
						$value = $id->value;
					} else {
						$value = "";
					}
					$html .= '<li><a href="#' . $value . '">' . trim( $tag->nodeValue ) . '</a>';
				}
			}
			$html .= str_repeat( '</li></ul>', $htmlLevel );
			$html .= "<ul class=\"nav top-marker\"><li><a href=\"#page-top\">Top</a></li></ul></nav></div>\n";
		}
		echo $html;

	}
endif;

if ( ! function_exists( 'lti_get_author_social_accounts' ) ) :
	/**
	 * Grabs social account urls configured in each users' profile
	 * LTI SEO has to be activated for this to work.
	 *
	 */
	function lti_get_author_social_accounts() {
		if ( class_exists( 'Lti\Seo\Helpers\Wordpress_Helper' ) ) {
			/**
			 * @var \Lti\Seo\Helpers\Wordpress_Helper $helper
			 */
			$helper          = \Lti\Seo\LTI_SEO::get_instance()->get_helper();
			$social_accounts = $helper->get_author_social_info_with_labels( 'all_with_labels' );
			$prettyNames     = array(
				'facebook'  => 'Facebook',
				'twitter'   => 'Twitter',
				'instagram' => 'Instagram',
				'youtube'   => 'YouTube',
				'linkedin'  => 'LinkedIn',
				'gplus'     => 'Google Plus'
			);

			if ( is_array( $social_accounts ) ) {
				if ( isset( $social_accounts['email'] ) ) {
					$email = $social_accounts['email'];
					unset( $social_accounts['email'] );
				}
				foreach ( $social_accounts as $account => $link ) {
					echo sprintf( '<li class="share-button share-%s"><a href="%s" title="%s" rel="nofollow" target="_blank"></a></li>',
						$account, $link, $prettyNames[ $account ] . " profile" );
				}
				if ( ! empty( $email ) ) {
					echo sprintf( '<li class="share-button share-email"><a href="%s" title="E-mail me" rel="nofollow" target="_blank"></a></li>',
						sprintf( $email, esc_attr( 'Lti@DEV - Contact' ), '' ) );
				}
			}
		} else {
			return;
		}
	}

endif;
if ( ! function_exists( 'lti_get_author_dev_accounts' ) ) :
	/**
	 * Grabs dev account urls configured in each users' profile
	 * @see functions.php
	 *
	 */
	function lti_get_author_dev_accounts() {
		$author       = get_query_var( 'author' );
		$dev_accounts = array(
			'codeacademy' => get_user_meta( $author, 'lti_codeacademy_profile',true ),
			'github'      => get_user_meta( $author, 'lti_github_profile',true )
		);
		$prettyNames = array(
			'codeacademy' => 'Code Academy',
			'github'      => 'GitHub'
		);
		if ( ! empty( $dev_accounts ) ) {
			foreach ( $dev_accounts as $account => $link ) {
				if(!empty( $link)){
				echo sprintf( '<li class="share-button share-%s"><a href="%s" title="%s" rel="nofollow" target="_blank"></a></li>',
					$account, $link, $prettyNames[ $account ] . " profile" );
				}
			}
		}
	}

endif;