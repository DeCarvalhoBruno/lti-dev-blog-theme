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
    <div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-2' ); ?>
    </div><!-- #footer-sidebar -->
</div><!-- #supplementary -->
