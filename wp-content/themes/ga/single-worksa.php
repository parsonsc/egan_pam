<?php 
global $wp_query;
$page_id  = $wp_query->get_queried_object_id();
$thispage = get_permalink($page_id);
function add_facebook_open_graph_tags() {
	global $post;   
?>	

	<?php 
}
add_action('wp_head', 'add_facebook_open_graph_tags',99);

get_header(); ?>
      <section class="project_content">
        <div class="inner_content">      
<?php
if(get_the_post_thumbnail(get_the_ID(), null)){
?>
  <section class="hero_banner">
    <div class="inner_content">          
      <?php echo get_the_post_thumbnail(get_the_ID(), null, array('class' => "background",'alt' => "",'title' => ""));?>
    </div>
  </section>
  <div class="clear"></div>
<?php
}
?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <header class="project_header">
      <?php the_title('<h1>', '</h1>'); ?>
      <?php the_excerpt('<h2>', '</h2>'); ?>
      
      
    </header>
    <div class="clear"></div>
    <!-- content block -->
    <div class="content_block">
      <?php the_content();
      $strhtml = get_the_content();
      ?>
    </div>
</section>
<?php endwhile;endif; ?>
  
  <div class="clear"></div>
</div>

    
<?php get_footer(); ?>
