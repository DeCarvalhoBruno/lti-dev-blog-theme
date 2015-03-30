<?php
/**
 * @package lti
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="below-title-meta">
            <div class="adt">
                <div class="user-icon"></div>
                    <span class="author">
                        <?php echo the_author_posts_link(); ?>
                     </span>
                <span class="meta-sep">|</span>
                <?php lti_posted_on(); ?>
            </div>
        </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'lti' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php lti_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
