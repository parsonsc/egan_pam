<?php 
/**
 * Template Name: News Page
 *
 * @package GoodAgency
 */
 
get_header();?>
<?php the_post_thumbnail('my_feature_image'); ?> 
    <div class="clear"></div>
    <div class="mainContent" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
       
        <section class="news_section">
            <div class="inner_content">
                <header class="news_section_header">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php the_title( '<h1>', '</h1>' );?>       
                    <?php the_content();?>
                    <?php endwhile; endif;?>
                </header>
                <div class="news_grid" id="NewsContainer">   
                    <ul class="grid effect-1" id="grid">
                        <?php 
                        $current_page = max( 1, get_query_var('paged') );
                        $total_pages = $wp_query->max_num_pages; ?>
                        <?php $the_query = new WP_Query('category_name=News&showposts=12&paged=' . $current_page); ?>
                        <?php while ($the_query->have_posts()) : $the_query->the_post(); $id = get_the_ID(); ?>
                        
                            
                            <li class="item-<?php the_ID(); ?>">
                                <a href="<?php echo get_permalink($id);?>">
                                    <?php 
                                    if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'list-image', $id)) :
        							    MultiPostThumbnails::the_post_thumbnail(
        							        get_post_type(),
        							        'list-image', $id ,'goodagency-news'
        							    );
        						    else:
        							    echo get_the_post_thumbnail($id, null);
        							endif; ?>
                                    
                                    <div class="news_text"> 
                                        <?php the_title('<p>','</p>'); ?>
                                    </div>
                                </a>
                            </li>
                        <?php endwhile; ?>                    
                    </ul>
                    <?php 
                    next_posts_link( 'Older Entries', $the_query->max_num_pages );
                    wp_reset_postdata();                     
                    ?>
                </div>
            </div>
        </section>                
    </div>                            
<?php get_footer(); ?>