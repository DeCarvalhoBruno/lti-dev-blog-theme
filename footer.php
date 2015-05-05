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
	<div class="footer-elem-wrapper">
		<?php get_sidebar( 'footer' ); ?>
		<div class="site-info">
			<div class="copyleft">
				<img id="img-copyleft" alt="This website is based on a copyleft template" src="<?php echo get_template_directory_uri() ?>/assets/images/copyleft.png">
				<span><a target="_blank" href="<?php echo esc_url( 'http://info.linguisticteam.org' ); ?>"
				         rel="nofollow"><?php _e( 'Linguistic Team International', 'lti' ); ?></a></span>
			</div>

		</div>
		<!-- .site-info -->
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script>
	<?php if(WP_DEBUG_DISPLAY==true){?>
	document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>');
	<?php } ?>
	window.lti = {
		'vars': {
			'api_url': "<?php echo LTI_BACKEND_API_URL;?>",
			'api_token': "<?php echo LTI_BACKEND_API_TOKEN;?>",
			'tested_url': "<?php echo get_permalink();?>"
		}
	}
</script>
</body>
</html>
