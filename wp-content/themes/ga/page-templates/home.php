<?php 
/**
 * Template Name: Home Page
 *
 * @package Albemarle
 */
   
 
 
get_header();?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
<?php the_post_thumbnail('my_feature_image'); ?> 
<?php the_content();?>
<?php endwhile; endif;?>   		
<?php get_footer(); ?>