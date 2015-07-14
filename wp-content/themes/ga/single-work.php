<?php 
global $wp_query;
$page_id  = $wp_query->get_queried_object_id();
$thispage = get_permalink($page_id);
function add_facebook_open_graph_tags() {
	global $post;   
	?>	
	<meta property="og:title" content="GOOD work." />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/facebook.jpg" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="GOOD agency exists to unleash the good in everyone. Have a look at how." />
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
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
            
            <nav class="project_category"><div class="catlist">
<?php
$cats = array();
foreach(get_the_terms( get_the_ID(), 'work' ) as $category) {
	if (count($cats) > 0) $cats[] = array('name'=>'|','slug'=>'');
	$cats[] = array('name'=>$category->name, 'slug'=>$category->slug);
}
?>            
              <ul>
              <?php
              foreach ($cats as $cat):
              ?>
              	<li<?php echo ($cat['slug'] == '') ? ' class="spc"':'';	?>>
              	<?php 
              	if ($cat['slug'] != ''){
		/*
              	?>
              	<a href="<?php echo get_permalink(15) . '?cat='. $cat['slug']; ?>"> 
              	<?php
		*/
              	}
              	echo $cat['name'];
              	if ($cat['slug'] != ''){
		/*
              	?>
              	</a> 
              	<?php
		*/
              	}
              endforeach;
              ?>
              </ul></div>
            </nav>
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
        appId      : '1536552766602618',
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
	var product_name   = 	'GOOD work.';
	var description	   =	"GOOD agency exists to unleash the good in everyone. Have a look at how.";
	var share_image	   =	'<?php echo get_template_directory_uri(); ?>/images/facebook.jpg';	
	var share_url	   =	'<?php echo $thispage; ?>';
    var share_capt     =    'Love this work from GOOD. ';
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
        
        <div class="clear"></div>
		<div class="content_block">   
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
            </section>
            <div class="clear"></div>
            <a href="<?php echo get_permalink(15); ?>" class="back_cta">Back to work</a>
        </div>        

    </div>

    
<?php get_footer(); ?>
