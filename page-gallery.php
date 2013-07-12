<?php
/**
 * Template Name: Gallery Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header('gallery'); ?>


		<div id="primary">
			<div id="content" role="main">
<script type="text/javascript">
  $(document).ready(function(){
    
$('.bxslider').bxSlider({
  pagerCustom: '#bx-pager'
});
  });

</script>
				<?php while ( have_posts() ) : the_post(); ?>
	<?php

	$args = array(
		'numberposts' => -1, // Using -1 loads all posts
		'orderby' => 'menu_order', // This ensures images are in the order set in the page media manager
		'order'=> 'ASC',
		'post_mime_type' => 'image', // Make sure it doesn't pull other resources, like videos
		'post_parent' => $post->ID, // Important part - ensures the associated images are loaded
		'post_status' => null,
		'post_type' => 'attachment'
	);

	$images = get_children( $args ); 
	?>

	<?php get_template_part( 'content', 'page' ); ?>
	

	<?php if($images){ ?>
		<ul class="bxslider">
			<?php foreach($images as $image){ ?>
			<li>
				<img src="<?php echo $image->guid; ?>" alt="<?php echo $image->post_title; ?>" title="<?php echo $image->post_title; ?>" />
			</li>
			<?php } // End foreach ?>
		</ul><!-- $main-image -->
  		
  		<div id="bx-pager">
  			<?php $index = 0;?>
  			<?php foreach($images as $key => $image) { ?> 
					<a data-slide-index="<?php echo $index ?>" href="">
						<?php echo wp_get_attachment_image( $key, 'thumbnail', $icon = false, $attr = '' ); ?>
					
					</a>
					<?php $index++ ?>
			<?php } ?>
					
					
			
  		</div><!-- #bx-pager -->

  	<?php } // End if ?>



				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>