<?php 
/**
 * Template Name: People Page
 *
 * @package GoodAgency
 */
 
get_header(); 
if(get_the_post_thumbnail(get_the_ID(), null)){
?>
       
<?php
}
?>        
        <div class="clear"></div>
        <section class="team" id="team">
            <div class="inner_content">                
                <div class="team_member_section"> 

                <?php
                	$staffBits = new WP_Query();
                    $staffBits->query(array('post_type' => 'staff_member', 'post_status'=>'publish', 'orderby' => 'menu_order title', 'order' => 'ASC', 'posts_per_page' => -1 ));
                	if ($staffBits->have_posts()):
                    
                        $count = $staffBits->found_posts;
                        $j = 0;
                        $k = 1;
                        $closed = true;
                ?>

<?php
        $people = array();
		while ($staffBits->have_posts()): 
            //print_R($staffBits);
    
			$staffBits->the_post();
            $attr = array(
                'alt'	=> trim( the_title_attribute(array('echo' => 0)) ),
                'title'	=> trim( the_title_attribute(array('echo' => 0)) ),
                'itemprop' =>'photo'
            ); 
			$custom = get_post_meta($post->ID, 'job_title', true);

            $people[] = array(
                'image' => get_the_post_thumbnail($post->ID, 'headshot-large', $attr ), 
                'title' => (get_the_title()!='') ? '<p class="member_name" itemprop="name">'.get_the_title().'</p>':'',
                'role' => (trim($custom) != "") ? '<p class="member_role" itemprop="jobtitle">'. $custom.'</p>':'',
                'descr' => '<div class="member_desc" itemprop="description">'.str_replace('href="mailto', 'class="member_email" itemprop="email" href="mailto', str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content()))).'</div>'
            );
        endwhile;
        //echo $count;
        $people = array_chunk($people, ceil($count/3));
        //print_R($people);
        for($i = 0; $i < sizeof($people); $i++){
            echo '<ul class="column" id="column_'. sprintf("%02s", $i+ 1)  .'">';
            foreach ($people[$i] as $person){
                $j++;
?>
            <li class="member member-<?php echo $j % 4 ?>" itemscope itemtype="http://schema.org/Person">

                <?php echo $person['image'];?>
                <div class="member_content">
                    <?php echo $person['title'];?>
                    <?php echo $person['role'];?>
                    <?php echo $person['descr'];?>
                </div>
            </li>
<?php            
            }
?>
            </ul>
<?php            
		}
        if (!$closed) echo '</ul>';
    endif;
?>                    
                    
                </div>
            </div>
        </section>                

                            
<?php get_footer(); ?>
