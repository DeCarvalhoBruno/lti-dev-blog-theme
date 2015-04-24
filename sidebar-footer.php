<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @package lti
 */

if ( ! is_active_sidebar( 'footer-bottom' ) ) {
	return;
}
?>

<div id="supplementary">
    <div id="footer-sitemap" class="footer-sidebar widget-area sitemap" role="complementary">
        <?php dynamic_sidebar( 'footer-top' ); ?>
    </div><!-- #footer-sidebar -->
    <div id="footer-bottom" class="footer-sidebar widget-area footer-widgets" role="complementary">
        <?php dynamic_sidebar( 'footer-bottom' ); ?>
    </div><!-- #footer-sidebar -->
</div><!-- #supplementary -->
