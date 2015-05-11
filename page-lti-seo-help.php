<?php
/**
 * The template for displaying project pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package lti
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main with-toc" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile;// end of the loop.
			echo Lti_Shares::display('post-share', lti_single_no_toc_class() );
			comments_template();
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
    <div id="secondary" class="table-contents" role="complementary">
        <?php get_sidebar_with_scrollspy(); ?>
    </div><!-- #secondary -->
<div style="clear: both;height:50px"></div>
<?php
?>
<?php get_footer(); ?>
