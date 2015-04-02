<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @package lti
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div id="supplementary">
    <div id="footer-sidebar3" class="footer-sidebar widget-area sitemap" role="complementary">
        <?php dynamic_sidebar( 'sidebar-3' ); ?>
    </div><!-- #footer-sidebar -->
    <div id="footer-sidebar2" class="footer-sidebar widget-area footer-widgets" role="complementary">
        <?php dynamic_sidebar( 'sidebar-2' ); ?>
    </div><!-- #footer-sidebar -->
</div><!-- #supplementary -->
