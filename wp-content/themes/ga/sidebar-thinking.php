<aside class="other_articles">
    <div class="thinking-info">
	<h4>Author</h4>
<?php 
	//$postAuthor = $post->post_author; 
    $postAuthor = get_the_author_meta('ID');
    $user = new WP_User( $postAuthor );
	if (!empty( $user->roles ) && is_array( $user->roles ) && $user->roles[0] != 'administrator') : 
?>
    <div class="author-image">
    <?php 
        $avatar = get_author_image_url($postAuthor); // Replace 123 with the id of the author you want to use
		$html = '<img src="'.$avatar.'" alt="A Picture of '.get_the_author_meta('display_name',$postAuthor) .'" class="author"/>';
		echo $html;
	?>
    </div>
    <div class="author-about">
			<h2><?php the_author_meta('display_name'); ?></h2>			
			<?php the_author_meta('jobtitle'); ?>
    </div>
    <p><a class="cta more_articles" href="<?php echo get_author_posts_url( $postAuthor ); ?>">More by this author</a></p>
<?php
	endif;
?>	
    <div class="clear hr"></div>
    
<?php
$custom = get_post_custom(get_the_ID());
$related = isset($custom["related"][0])? $custom["related"][0] : '' ;
//print_R(unserialize($related));
$cpost = $wp_query->post;
query_posts(array('post__in'=> unserialize($related), 'post_type'=>'thinksa','post__not_in' => array($cpost->ID)));
//echo $GLOBALS['wp_query']->request; 
if (have_posts()):
?>  
  <h4>Recent articles</h4>  
  <ul class="other_news">
<?php
    while (have_posts()) : the_post();
?>    
    <li>
      <a href="<?php the_permalink(); ?>">
        <?php 
        $id = get_the_ID();
        $custom = get_post_custom($id);
        $clienttitle = isset($custom["clienttitle"][0])? $custom["clienttitle"][0] : '' ;
        $clientimage = isset($custom["clientimage"][0])? $custom["clientimage"][0] : '' ;
        if ($clientimage !== '') :
           echo '<img src="'. $clientimage .'" alt="" width="100%" />';
        else:
            echo get_the_post_thumbnail($id, null);
        endif; 
        echo  ($clienttitle !='') ? '<p class="article_title arrow">'.$clienttitle.'</p>' : get_the_title('<p class="article_title arrow">','</p>'); 
        ?>       
      </a>
    </li>
<?php 
    endwhile; 
    wp_reset_postdata();
?>
  </ul>
<?php
endif;
?>    
    
    </div>
    

</aside>

