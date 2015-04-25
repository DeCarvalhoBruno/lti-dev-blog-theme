<?php
/**
 * @package lti
 */
?>

<div class="article-wrapper">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (is_sticky() && is_home() && !is_paged()) : ?>
        <div class="featured-post">
            <?php _e('Featured Article', 'lti'); ?>
        </div>
    <?php endif; ?>
    <header class="entry-header">
        <?php the_title(sprintf('<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h1>'); ?>

        <?php if ('post' == get_post_type()) : ?>
            <div class="below-title-meta">
            <?php lti_about_author(); ?>
            </div>
        <?php endif; ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <div class="entry-summary">
            <div class="excerpt-thumb">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Link to %s', 'lti'),
                        the_title_attribute('echo=0')); ?>" rel="bookmark">
                        <?php the_post_thumbnail('thumbnail', 'class=alignleft'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php the_excerpt(); ?>
        </div>
    </div>
    <!-- .entry-content -->

    <footer class="entry-footer">
        <?php lti_entry_footer(); ?>
    </footer>
    <!-- .entry-footer -->
</article><!-- #post-## -->
</div>