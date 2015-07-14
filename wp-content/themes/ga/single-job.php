<?php 
global $wp_query;
$page_id  = $wp_query->get_queried_object_id();
$thispage = get_permalink($page_id);

function add_facebook_open_graph_tags() {
    global $post; 
	?>	
	<meta property="og:title" content="GOOD job." />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/facebook.jpg" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="GOOD agency exists to unleash the good in everyone. Work with them and you can too." />
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
else if(get_the_post_thumbnail(23, null)){
?>
        <section class="hero_banner">
          <div class="inner_content">          
            <?php echo get_the_post_thumbnail(23, null, array('class' => "background",'alt' => "",'title' => ""));?>
          </div>
        </section>
<?php
}
?>
    <div class="job_role_content">
        <section class="inner_content">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <section class="role_brief"> 
<?php
	$custom = get_post_custom(get_the_ID());
	//print_r($custom);
	//echo get_the_ID();
	$job_supervisor = (isset($custom["job_supervisor"][0])) ? $custom["job_supervisor"][0] : '';
	$job_type = (isset($custom["job_type"][0])) ? $custom["job_type"][0] : '';
	$job_salary = (isset($custom["job_salary"][0])) ? $custom["job_salary"][0] : '';
	$job_salarytype = (isset($custom["job_salarytype"][0])) ? $custom["job_salarytype"][0] : '';
	$job_pdf = (isset($custom["job_pdf"][0])) ? $custom["job_pdf"][0] : '';
	$second_column = (isset($custom["second_column"][0])) ? $custom["second_column"][0] : '';
	$second_column = apply_filters('the_content', $second_column);
	$second_column = str_replace(']]>', ']]&gt;', $second_column);			
?>	                 
            <header class="role_header">
            	<h1>Join us</h1>
	            <?php the_title('<h2>','</h2>'); ?></h1>
    	    </header>
	        <?php the_content();
$strhtml = get_the_content();
?>		
	    </section>
        <?php endwhile;endif; ?>
        
        <section class="key_skills">            
            <div class="skills_block">
            	<?php echo $second_column; ?>	
            </div>
        </section>
        <div class="clear"></div>
		<div class="content_block">   
            <div class="underline"></div> 
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
	var product_name   = 	'GOOD job.';
	var description	   =	"GOOD agency exists to unleash the good in everyone. Work with them and you can too.";
	var share_image	   =	'<?php echo get_template_directory_uri(); ?>/images/facebook.jpg';	
	var share_url	   =	'<?php echo $thispage; ?>';
    var share_capt     =    'Looks like GOOD Agency is recruiting – check out this job opportunity.';
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
            <a href="<?php echo get_permalink(23); ?>" class="back_cta">Back to all roles</a>
        </div>        

    </div>

    
<?php get_footer(); ?>
