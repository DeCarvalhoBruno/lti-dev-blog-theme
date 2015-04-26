<?php

if (!function_exists('get_sidebar_with_scrollspy')) :

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
			$html .= str_repeat('</li></ul>', $htmlLevel-$level) . '</li>';
			$html .= "<ul class=\"nav top-marker\"><li><a href=\"#page-top\">Top</a></li></ul></nav></div>\n";
		}
		echo $html;

	}
endif;