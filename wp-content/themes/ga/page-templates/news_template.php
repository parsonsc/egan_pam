<?php

/**
 * Template Name: News Page
 *
 * @package GoodAgency
 */
error_reporting(0);
define('PER_PAGE_DEFAULT', 12);
function custom_query_posts(array $query = array())
{
        global $wp_query;
        wp_reset_query();
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $defaults = array(
                'paged' => $paged,
                'posts_per_page' => PER_PAGE_DEFAULT
        );
        $query += $defaults;
        $wp_query = new WP_Query($query);
        //file_put_contents('/xampp/htdocs/ga/query.log', print_R($wp_query->query, true), FILE_APPEND);
} 

get_header(); 
$thisP = get_the_ID();
if(get_the_post_thumbnail(get_the_ID(), null)){
?>
       
<?php
}
?>  
<?php the_post_thumbnail('my_feature_image'); ?>  
        <div class="clear"></div>
    <div class="mainContent" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
        
        <section class="work_grid">
            <div class="inner_content">
                <header class="work_grid_header">     
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_title( '<h1>', '</h1>' );?>   
                <?php the_content();?>
                <?php endwhile; endif;?>
                <?php 
                $taxonomy     = 'worksac';
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
                <!-- <?php echo (isset($_GET["cat"])) ? $_GET["cat"]: ''; ?> -->
             
                </header>
                <div class="grid_collage" id="FilterContainer">
<?php 
global $wp_query;

$full = array();
$half = array();
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$qarray = array(
    'post_type' => 'worksa', 
    'post_status'=>'publish', 
    'posts_per_page' => -1, 
    'meta_key' => 'fullwidth', 
    'meta_value' => 1,
    'orderby' => 'menu_order title', 
    'order' => 'DESC');
    /*
if ($getcat != '') {
    foreach ($cats as $cat):
        if ($getcat == $cat->slug) $qarray['tax_query'] = array(array(
                    'taxonomy' => 'worksac',
                    'field' => 'slug',
                    'terms' => array($cat->slug),
                    'operator' => 'IN'
                ));
    endforeach;                    
}
    */
custom_query_posts($qarray);
$total_pages = $wp_query->max_num_pages;
//print_R($the_query1->request);                    
while (have_posts()) :
    the_post(); 
    $id = get_the_ID(); 
    $custom = get_post_custom($id);
    $clienttitle = isset($custom["clienttitle"][0])? $custom["clienttitle"][0] : '' ;
    $clientdesc = isset($custom["clientdesc"][0])? $custom["clientdesc"][0] : '' ;
    $clientimage = isset($custom["clientimage"][0])? $custom["clientimage"][0] : '' ;
    $fullwidth = isset($custom["fullwidth"][0])? $custom["fullwidth"][0] : 0 ;
    
    $full[] = array(
        'id' => $id,
        'title' => $clienttitle,
        'desc' => $clientdesc,
        'image' => $clientimage,
        'full' => $fullwidth,
    );
endwhile;
//$wp_query = null; 
//$wp_query = $temp;

$getmore = 6 - count($full);
$qarray = array(
    'post_type' => 'worksa', 
    'post_status'=>'publish', 
    'posts_per_page' => -1, 
    'meta_key' => 'fullwidth', 
    'meta_value' => 0,
    'orderby' => 'menu_order title', 
    'order' => 'DESC');
    /*
if ($getcat != '') {
    foreach ($cats as $cat):
        if ($getcat == $cat->slug) $qarray['tax_query'] = array(array(
                    'taxonomy' => 'work',
                    'field' => 'slug',
                    'terms' => array($cat->slug),
                    'operator' => 'IN'
                ));
    endforeach;                    
}     
    */                    
custom_query_posts($qarray);                    
//print_R($the_query->request);
if ($wp_query->max_num_pages > $total_pages ) $total_pages = $wp_query->max_num_pages;
while (have_posts()) : 
    the_post(); 
    $id = get_the_ID(); 
    $custom = get_post_custom($id);
    $clienttitle = isset($custom["clienttitle"][0])? $custom["clienttitle"][0] : '' ;
    $clientdesc = isset($custom["clientdesc"][0])? $custom["clientdesc"][0] : '' ;
    $clientimage = isset($custom["clientimage"][0])? $custom["clientimage"][0] : '' ;
    $fullwidth = isset($custom["fullwidth"][0])? $custom["fullwidth"][0] : 0 ;                    
    $half[] = array(
        'id' => $id,
        'title' => $clienttitle,
        'desc' => $clientdesc,
        'image' => $clientimage,
        'full' => $fullwidth,
    );
endwhile;
$z = 0;
//file_put_contents('/xampp/htdocs/ga/query.log', print_R($full, true), FILE_APPEND);
for ($j = 0; $j < count($full); $j++){
    $halfc  = count($half);
    switch ($j) {
        case 0:
            if ($halfc > 2) array_splice($half, 2, 0, array($full[$j]));
            else array_splice($half, count($half), 0, array($full[$j]));
            break;
        case 1:
            $z++;
            if ($halfc > 7) array_splice($half, 7, 0, array($full[$j]));
            else array_splice($half, count($half), 0, array($full[$j]));        
            break;
        default:
            $posn = 7 + (5 * $z);
            //file_put_contents('/xampp/htdocs/ga/query.log', print_R('posn '. $z .' ='. $posn, true), FILE_APPEND);
            $z++;
            if ($halfc > $posn) array_splice($half, $posn, 0, array($full[$j]));
            else array_splice($half, count($half), 0, array($full[$j]));          
            break;
    }
}

$max_num_pages = ceil(count($half) / PER_PAGE_DEFAULT);
$start = ($current_page - 1) * (PER_PAGE_DEFAULT + 1);
$offset = PER_PAGE_DEFAULT + 1;

$outArray = array_slice($half, $start, $offset);
//file_put_contents('/xampp/htdocs/ga/query.log', print_R($half, true), FILE_APPEND);
//file_put_contents('/xampp/htdocs/ga/query.log', print_R($outArray, true), FILE_APPEND);
//print_R($half);
//print_R($outArray);
if (count($outArray) > 0): 
?>
              
    <ul class="grid news_grid" id="grid">
        <?php
        foreach ($outArray as $post):
            $id = $post['id'];
            $full = $post['full'];
            $title = $post['title'];
            $desc = $post['desc'];
            $image = $post['image'];
            $hidethis = false;
            if ($getcat != ''){
                foreach(get_the_terms( $id, 'work' ) as $category) {
                    if ($getcat == $category->slug) $hidethis = true;
                }
            }
        ?>                  
            <li <?php //echo ($hidethis) ? 'style="display:none"':'' ?> class="<?php echo ($full == 1) ? 'one_block':'two_block';?> all <?php $first = ''; $x=0;foreach(get_the_terms( $id, 'worksa' ) as $category) {if ($x < 1) $first=$category->slug;  echo $category->slug . ' ';} ?>" data-category-type="<?php $x=0; foreach(get_the_terms( $id, 'worksa' ) as $category) {if ($x < 1) $first=$category->slug;  echo $category->slug . ' ';};?>">
            <a href="<?php echo get_permalink($id); ?>">              
                <img src="<?php echo $image ?>" alt="" width="100%">
                <article>
                  <h3><?php echo $title;?></h3>
                  <p><?php echo $desc;?></p>
                </article>    
            </a>
            </li>
        <?php 
        endforeach; 
        ?>                        
    </ul>
<?php
/*
if ($the_query->max_num_pages > $paged){
?>
    <a href="get_permalink($thisP., echo (int)$current_page+1 ;?>" class="next">Older work</a>
<?php
}
*/
//echo $start. '//';

//echo PER_PAGE_DEFAULT .'//';
//echo count($half);
next_posts_link( 'Older Entries', $max_num_pages );

endif; 
wp_reset_postdata();
?>
                </div>
            </div>
        </section>                
    </div>        
<?php get_footer(); ?>