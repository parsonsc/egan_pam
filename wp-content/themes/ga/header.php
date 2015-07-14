<?php 
if(function_exists('lcfirst') === false) {
    function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }
} 

function csssafename($int, $span = 10){
    $string = '';
    $int = $int % $span;
    switch ((int)$int){
        case 0: return 'first';
        case 1: return 'second';
        case 2: return 'third';
        case 3: return 'fourth';
        case 4: return 'fifth';
        case 5: return 'sixth';
        case 6: return 'seventh';
        case 7: return 'eighth';
        case 8: return 'ninth';
        case 9: return 'tenth';
    }
}
ob_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php goodagency_html_schema(); ?> <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php goodagency_html_schema(); ?> <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php goodagency_html_schema(); ?> <?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php goodagency_html_schema(); ?> <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title itemprop="name"><?php wp_title(''); ?></title>
    <?php // mobile meta (hooray!) ?>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width" />
    <!-- <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/social/apple-touch-icon.png" /> -->
 
    <!-- <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/social/favicon.png"> -->
    <!--[if IE]>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/social/favicon.ico">
    <![endif]-->
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/social/apple-touch-icon-144.png">
    
    
    <?php wp_head(); ?>
    
    
</head>
<body>
  <div class="site_container  <?php echo lcfirst(str_replace(" ", "", ucwords(trim(strtolower(preg_replace('/\b[a-zA-Z]{1,2}\b/u','',preg_replace('/[^a-zA-Z]+/u',' ', get_post_type()))))))); ?> <?php echo lcfirst(str_replace(" ", "", ucwords(trim(strtolower(preg_replace('/\b[a-zA-Z]{1,2}\b/u','',preg_replace('/[^a-zA-Z]+/u',' ', get_the_title()))))))); ?>" id="site-container">
    <section class="left_nav">
      <nav class="main_nav">
        <ul>
          <li>
            <a href="<?php echo home_url(); ?>"><img id="logo" src="<?php echo get_bloginfo('template_directory');?>/images/logo.jpg" class="" alt="" width="100%"/></a>
          </li>
          <li>
            <a href="https://goo.gl/maps/D8Dt8" target="_blank">
              66 Grosvenor Street,<br />London W1K 3JL
            </a>
          </li>
          <li>
            <a href="tel:02076591060">
              <p>T: 020 7659 1060</p>
            </a>
            <a href="mailto:mail@egan-pam.com" target="_blank">
              <p>E: mail@egan-pam.com</p>
            </a>
          </li>
          <li>
            <a href="#">
              <img src="<?php echo get_bloginfo('template_directory');?>/images/rics.jpg" alt="" width="100%">
            </a>
          </li>
          <li>
            <p>090923092309</p>
          </li>
        </ul>
      </nav>
    </section>
    <div class="main_content">
      <div class="mobile_menu show_mobile">
        <!-- mobile menu icon -->        
        <a id="menu-icon" href="#" title="Menu" class="show_mobile">
          <span class="line line-1"></span>
          <span class="line line-2"></span>
          <span class="line line-3"></span>
        </a>
      </div>
      <nav role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="site_nav">
        <?php wp_nav_menu(array(
         'container' => false,                           // remove nav container
         'container_class' => 'menu cf',                 // class of container (should you choose to use it)
         'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
         'menu_class' => 'nav top-nav cf',               // adding custom nav class
         'theme_location' => 'main-nav',                 // where it's located in the theme
         'before' => '',                                 // before the menu
               'after' => '',                                  // after the menu
               'link_before' => '',                            // before each link
               'link_after' => '',                             // after each link
               'depth' => 0,                                   // limit the depth of the nav
         'fallback_cb' => ''                             // fallback function (if there is one)
        )); ?>

      </nav>      
      <div class="clear"></div>
      






