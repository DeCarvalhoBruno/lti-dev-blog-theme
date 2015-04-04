<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package lti
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo lti_body_extra_attributes(); ?>>
<div id="page" class="hfeed site">
    <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'lti'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="site-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img id="logo" src="<?php echo get_template_directory_uri() ?>/images/logo.png"
                     alt="Linguistic Team international Logo"/>
                <img id="logo-text" src="<?php echo get_template_directory_uri() ?>/images/logo_text.png"
                     alt="Development at LTI"/>
            </a>

            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                      rel="home"><?php bloginfo('name'); ?></a></h1>

            <h2 class="site-description"><?php bloginfo('description'); ?></h2>
        </div>
        <!-- .site-branding -->
        <div class="social-media-headers">
            <a class="social-header h-fb" target="_blank" href="https://www.facebook.com/groups/LinguisticTeamInternational/" alt="facebook group"></a>
            <a class="social-header h-tw" target="_blank" href="https://twitter.com/LinguisticTeam"
               alt="twitter page"></a>
            <a class="social-header h-gp" target="_blank" href="#" alt="google plus page"></a>
        </div>

        <nav id="site-navigation" class="main-navigation" role="navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"></button>
            <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu')); ?>
        </nav>
        <!-- #site-navigation -->
    </header>
    <!-- #masthead -->

    <div id="content" class="site-content">
