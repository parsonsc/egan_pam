<aside class="other_articles">

<?php
$cat = get_the_category();
$args = array(
    'numberposts' => 2,
    'category' => $cat[0]->term_id,
    'post__not_in' => array( get_the_ID() )
);
$myposts2 = get_posts($args);
if (count($myposts2) > 0):
?>  
  <h4>OTHER GOOD NEWS STORIES</h4>  
  <ul class="other_news">
<?php
    foreach ( $myposts2 as $post ) : 
        setup_postdata( $post );
?>    
    <li>
      <a href="<?php the_permalink(); ?>">
        <?php 
        if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'list-image', get_the_id())) :
                  MultiPostThumbnails::the_post_thumbnail(
                   get_post_type(),
                   'list-image', get_the_id() ,'goodagency-news'
                  );
        else:
            echo get_the_post_thumbnail(get_the_id(), null);
       endif; ?>

        <p class="article_title arrow"><?php the_title(); ?></p>   
      </a>
    </li>
<?php 
    endforeach; 
    wp_reset_postdata();
?>
  </ul>
<?php
endif;
?>
</aside>

