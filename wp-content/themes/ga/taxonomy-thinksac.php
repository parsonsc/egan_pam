<?php

error_reporting(0);
define('PER_PAGE_DEFAULT', 8);
 
wp_register_script('infinitescroll', get_template_directory_uri().'/js/jquery.infinitescroll.js', false, null, true);
wp_enqueue_script('infinitescroll');
 
wp_register_script('manualtrig', get_template_directory_uri().'/js/manual-trigger.js', false, null, true); 
wp_enqueue_script('manualtrig'); 

get_header(); 
$tag_id = '';

global $wp_query;
#print_R($wp_query);
$tag_id = $wp_query->query_vars['term']; 

//print_R($wp_query->query_vars);
	
if(get_the_post_thumbnail(8253, null)){
?>
        <section class="hero_banner">
          <div class="inner_content">          
            <?php echo get_the_post_thumbnail(23, null, array('class' => "background",'alt' => '','title' => ""));?>
          </div>
        </section>
<?php
}
?>
	<div class="clear"></div>
    <div class="mainContent" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
       
        <section class="thinking_section">
            <div class="inner_content">
                <header class="news_section_header">
                    <?php 
                    $taxonomy     = 'thinksac';
                    $orderby      = 'ID';
                    $show_count   = 0;      // 1 for yes, 0 for no
                    $pad_counts   = 0;      // 1 for yes, 0 for no
                    $hierarchical = 1;      // 1 for yes, 0 for no
                    $title        = '';
                    $empty        = 0;

                    $args = array(
                      'taxonomy'     => $taxonomy,
                      'orderby'      => $orderby,
                      'show_count'   => $show_count,
                      'pad_counts'   => $pad_counts,
                      'hierarchical' => $hierarchical,
                      'title_li'     => $title,
                      'hide_empty'   => $empty
                    );
                    
                    $cats = get_categories( $args );   
                    $getcat = '';
                    if (isset($_GET['cat'])) $getcat = $_GET['cat'];
                    ?>
                    <div class="custom_select">
                        
                        <?php 
                        $t = 'I&rsquo;D LIKE TO READ ABOUT&hellip;';
                        if ($getcat != '') {
                            foreach ($cats as $cat):
                                if ($getcat == $cat->slug) $t = $cat->name;
                            endforeach;
                        }
                        ?>
                        <button value="all" class="select_title all"><?php echo $t;?><span class="select_arrow"></span></button>       
                        <ul name="work_filter" id="work_filter" class="work_filter filterby">
                        <li class="all" data-category-type="" data-category-name="show all">
                        <a href="<?php echo get_permalink(8253);?>">
                        RECENT &amp; POPULAR

                        </a>
                        </li>
                        <?php foreach ($cats as $cat): 
                        // The $term is an object, so we don't need to specify the $taxonomy.
                        $term_link = get_term_link( $cat );
   
                        // If there was an error, continue to the next term.
                        if ( is_wp_error( $term_link ) ) {
                            continue;
                        }  
                        //print_R($cat);
			//echo $tag_id .'=='. $cat->term_id.'|';
                        ?>
                        <li class="<?php echo ($tag_id == $cat->slug) ? 'selected ':''; ?><?php echo $cat->slug;?>" data-category-type="<?php echo $cat->slug;?>" data-category-name="<?php echo $cat->slug;?>">
                        <a href="<?php echo esc_url( $term_link );?>">
                        <?php echo $cat->name;?>
                        </a>
                        </li>
                        <?php endforeach;?>                  
                        </ul>                    
                    </div>                
					<h1 class="archive-title h2">
						<?php single_tag_title(); ?>
					</h1>
</header>
                <div class="news_grid quadmasonry" id="NewsContainer">   
                    <?php 
                    $current_page = max( 1, get_query_var('paged') );
                    $total_pages = $wp_query->max_num_pages; ?>
                   	<?php
                   	$args = array(
                   		'post_type' => 'thinksa',
                   		'posts_per_archive_page' => 8,
                    	'tax_query' => array(
							array(
								'taxonomy' => 'thinksac',
								'field'    => 'slug',
								'terms'    => $tag_id,
							),
						),
						'paged'=> $current_page
					);
					$the_query = new WP_Query($args); ?>
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); $id = get_the_ID(); ?>

                    <div class="item item-<?php the_ID(); ?>">
                        <a href="<?php echo get_permalink($id);?>">
                            <?php 
                            $custom = get_post_custom($id);
                            $clienttitle = isset($custom["clienttitle"][0])? $custom["clienttitle"][0] : '' ;
                            $clientimage = isset($custom["clientimage"][0])? $custom["clientimage"][0] : '' ;
                            if ($clientimage !== '') :
							   echo '<img src="'. $clientimage .'" alt="" width="100%" />';
						    else:
							    echo get_the_post_thumbnail($id, null);
							endif; ?>                            
                            <div class="news_text"> 
                                <?php echo  ($clienttitle !='') ? '<p>'.$clienttitle.'</p>' : get_the_title('<p>','</p>'); ?>
                            </div>
                        </a>
                    </div>

                    <?php endwhile; ?>                    
                    
                    <?php 
                    next_posts_link( 'Older Entries', $total_pages );
                    wp_reset_postdata(); 
                    
                    ?>
                    
                </div>
                <a href="<?php echo get_permalink(8253); ?>" class="back_cta">Back to all GOOD thinking</a>
            </div>
        </section>
    </div>            

<?php get_footer(); ?>
