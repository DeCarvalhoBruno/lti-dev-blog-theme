<?php
/**
 * The template for displaying all single posts.
 *
 * @package lti
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<div id="page-top"></div>
		<?php while ( have_posts() ) : the_post(); ?>
		<main id="main" class="site-main <?php echo lti_single_no_toc_class(); ?>" role="main">
			<?php get_template_part( 'content', 'single' ); ?>

			<?php lti_the_post_navigation(); ?>

		<?php echo Lti_Shares::display('post-share', lti_single_no_toc_class() );
		comments_template();?>
		</main><!-- #main -->
		<?php endwhile; // end of the loop. ?>
	</div><!-- #primary -->
<?php get_sidebar('single'); ?>


<?php
// If comments are open or we have at least one comment, load up the comment template
//if ( comments_open() || get_comments_number() ) :
//    comments_template();
//endif;
?>
<div id="page-bottom"></div>
<?php get_footer(); ?>
