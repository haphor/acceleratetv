<?php
/**
 * The header v1 for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package vodi
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php if ( is_home() && ! is_front_page() ) : ?>

        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<style>
.main_blog h2 {
    overflow: hidden;
    font-weight: 600;
    letter-spacing: -2px;}
.main_blog h2:after {
    content: "";
    display: inline-block;
    height: 0.5em;
    vertical-align: bottom;
    width: 100%;
    margin-right: -100%;
    margin-left: 10px;
    background: transparent !important;
    border-top: 1px solid #fff;}
.latest {
    position: relative;
    overflow: hidden;}
.latest .owl-item {
    display: inline-block;
    vertical-align: bottom;}
.latest.customLatest .owl-item {
    min-height: 600px;}
.latest.latestFeatured .owl-item {
    min-height: 330px;
    width: 350px !important;}
.latest article {
    display: flex;
    position: relative;
    padding: 5px 20px 3px;
/*     background-size: 100% 100%;} */
    background-size: cover;
	background-position: center top;}
.latest.customLatest article {
    min-height: 600px;}
.latest.latestFeatured article {
    min-height: 330px;}
.latest article:before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.3);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;}
.latest article > div {
    align-self: flex-end;
    z-index: 9999;}
.latest article a {
    color: #fff;
    font-weight: 700;}
.latest article small {
    color: #f5f4f4;}
.latest .owl-nav {
    position: absolute;
    top: 0;
    right: 0;}
.latest .owl-nav button {
    font-size: 20px;
    padding: 3px 15px;
    border-radius: 0px;
    z-index: 999999;}
.latest .owl-dots {
    display: none;}
.main_blog .other_cat_content {
    width: 68%;}
.main_blog .other_cat_sidebar {
    width: 31%;}
.main_blog .other_cat_content,
.main_blog .other_cat_sidebar {
    display: inline-block;
    vertical-align: text-top;}
.main_blog .other_cat_sidebar {
    padding-top: 21px;}
.major_cat article > div {
    display: inline-block;
    vertical-align: middle;}
.main_blog .image {
    width: 35%;}
.main_blog .cat_content {
    width: 64%;}
.major_cat article:first-of-type:after {
    content: "";
    width: 35%;
    display: block;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px dashed #fff;}
.main_blog .cat_content p {
    margin: 20px 0px 5px;}
.cat_content a {
    color: #fff;}
</style>
<?php endif; ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'vodi_before_site' ); ?>

<div id="page" class="hfeed site">
    
    <?php do_action( 'vodi_before_header' ); ?>

    <header id="site-header" class="site-header header-v1 desktop-header stick-this <?php echo esc_attr( apply_filters( 'vodi_header_theme', 'light' ) );?>" role="banner" style="<?php vodi_header_styles(); ?>">
        <div class="container-fluid">
            <div class="site-header__inner">
                <?php
                /**
                 * Functions hooked into vodi_header_v1 action
                 *
                 */
                do_action( 'vodi_header_v1' ); ?>
            </div>
        </div>
    </header><!-- #site-header -->

    <?php
    /**
     * Functions hooked in to vodi_before_content
     *
     * @hooked vodi_header_widget_region - 10
     * @hooked woocommerce_breadcrumb - 10
     */
    do_action( 'vodi_before_content' );
    ?>

    <div id="content" class="site-content" tabindex="-1">
        
        <?php do_action( 'vodi_content_top' ); ?>
        
            <div class="site-content__inner">
