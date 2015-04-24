<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package lti
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        <?php get_sidebar( 'footer' ); ?>
		<div class="site-info">
			<a href="<?php echo esc_url( 'http://info.linguisticteam.org' ); ?>"><?php _e( 'Linguistic Team International', 'lti' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>');
</script>
</body>
</html>
