<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package lti
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
				<div class="author-info">
				<div class="author-img">
					<?php
					$avatar_img = get_avatar( get_query_var( 'author' ), 200, '', get_the_author() );
					echo $avatar_img;

					?>
				</div>
				<div class="author-social">
					<div class="footer-shares">
						<ul class="share-button-group">
							<li class="share-button share-facebook">
								</li>
							<li class="share-button share-gplus">
								</li>
							<li class="share-button share-twitter">
								</li>
							<li class="share-button share-pinterest">
								</li>
							<li class="share-button share-linkedin">
								</li>
							<li class="share-button share-email">
								</li>
						</ul>
					</div>
				</div>

				</div>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/* Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
