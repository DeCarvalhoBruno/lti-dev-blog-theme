<?php
/**
 * The template for displaying all single posts.
 *
 * @package lti
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<div id="page-top"></div>
		<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php lti_the_post_navigation(); ?>

		<?php endwhile; // end of the loop. ?>
		<?php echo Lti_Shares::display('post-share'); ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar('single'); ?>
<?php
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>
<div id="page-bottom"></div>
<?php get_footer(); ?>
