<?php 
global $wp_query;
$page_id  = $wp_query->get_queried_object_id();
$thispage = get_permalink($page_id);
function add_facebook_open_graph_tags() {
	global $post;  
	?>	
	<meta property="og:title" content="GOOD Thinking." />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/facebook.jpg" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="GOOD agency exists to unleash the good in everyone. Have a look at this thinking from their website." />
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
	<?php 
}
add_action('wp_head', 'add_facebook_open_graph_tags',99);
get_header(); 
if(get_the_post_thumbnail(get_the_ID(), null)){
?>
        <section class="hero_banner">
          <div class="inner_content">          
            <?php echo get_the_post_thumbnail(get_the_ID(), null, array('class' => "background",'alt' => "",'title' => ""));?>
          </div>
        </section>
<?php
}
?>
    <div class="news_article_section">
        <section class="thinking_article" role="article" itemscope itemtype="http://schema.org/BlogPosting">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="date"> 
            <?php the_time('d/m/Y') ?>
            </div>
            <h1 itemprop="headline"><?php the_title(); ?></h1>
                     
                    
    <?php
        $cats = new stdClass();
        $cats = get_the_terms( get_the_ID(), 'thinksac' );
        if ( $cats && ! is_wp_error( $cats ) ){
        ?>          
        <nav class="tag_category">
            <ul>
                <li class="title">Tags</li>			  
                <?php
                foreach ($cats as $cat):
                    $term_link = get_term_link( $cat );
                    if ( is_wp_error( $term_link ) ) {
                        continue;
                    }  
 
                    ?>                 
              	<li<?php echo ($cat->slug == '') ? ' class="spc"':'';	?>>
              	<?php 
              	if ($term_link && trim($cat->slug) !== ''){
              	?>
              	<a href="<?php echo esc_url( $term_link ) ?>"> 
              	<?php
              	}
              	echo $cat->name;
              	if ($cat->slug != ''){
              	?>
              	</a> 
              	<?php
              	}
              	?>
              	</li>
              	<?php
              endforeach;
              ?>
              </ul>
            </nav>
<?php
}
?>  
        <div class="clear hr"></div>
<?php the_content();
$postAuthor = get_the_author_meta('ID'); 
$strhtml = get_the_content();
?>	
        <?php endwhile;endif; ?>
        
<?php

$pinit = '';
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($strhtml);
$xpath = new DOMXPath($doc);
$nodes = $xpath->query('//img[contains(@class,"pinit")]');
if (is_object($nodes->item(0))) $pinit = $nodes->item(0)->getAttribute('src');
$emailsubj = "I thought this was GOOD";
$emailbody = "GOOD agency exists to unleash the good in everyone. I thought you might like to see this.\n\n ".$thispage;                           



?>
<script>
window.fbAsyncInit = function() {
    FB.init({
        appId      : '<?php echo ($_SERVER['HTTP_HOST'] == 'test4.thegoodagencydigital.co.uk' ) ? '1606005939657300': '1536552766602618';?>',
        xfbml      : true,
        version    : 'v2.2'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function FBShareOp(){
	var product_name   = 	'GOOD Thinking';
	var description	   =	"GOOD agency exists to unleash the good in everyone. Have a look at this item from their website.";
	var share_image	   =	'<?php echo get_template_directory_uri(); ?>/images/facebook.jpg';	
	var share_url	   =	'<?php echo $thispage; ?>';
    var share_capt     =    'Check out this item from GOOD agency.';
    FB.ui({
        method: 'feed',
        name: product_name,
        link: share_url,
        picture: share_image,
        caption: share_capt,
        description: description
    }, function(response) {
        if(response && response.post_id){}
        else{}
    });
}   
</script>           
        <div class="social_share">            
            <div class="underline"></div> 
            <section class="social_share">
              <h3>Share this, it&rsquo;s rather good</h3>
              <ul class="social_buttons">
                <li class="twitter">
                  <a href="http://twitter.com/share?url=<?php echo $thispage;?>&amp;text=<?php echo urlencode("Something GOOD: "); ?>"></a>                  
                </li>
                <li class="facebook">
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $thispage;?>"  onclick="FBShareOp(); return false;"></a>                
                </li>
                <li class="google">
                  <a href="https://plus.google.com/share?url=<?php echo urlencode($thispage); ?>"></a>                  
                </li>
                <li class="pinterest">
                  <a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($thispage); ?>&media=<?php echo urlencode($pinit); ?>&description=<?php echo urlencode("Something GOOD: "); ?>"></a>                  
                </li>
                <li class="email">
                 <?php
        
                    $emailsubj = str_replace(" ", "%20", $emailsubj);
                    $emailbody = str_replace(array("\n", "\r"), '%0D%0A%0D%0A', str_replace(" ", "%20",$emailbody));
                ?>  
                  <a href="mailto: ?subject=<?php echo $emailsubj;?>&body=<?php echo $emailbody;?>"></a>                  
                </li>
              </ul>
	      <a href="<?php echo get_permalink(8253); ?>" class="back_cta">Back to all GOOD thinking</a>
            </section>
            <div class="clear"></div>
        </div>        
        </section>
        <?php get_sidebar('thinking'); ?>
    </div>
<?php get_footer(); ?>
