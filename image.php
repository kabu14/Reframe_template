<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

        <div id="primary">
            <div id="content" role="main">

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();

                    

$args = array(  
    'post_type' => 'attachment',  
    'post_mime_type' => 'image',  
    'numberposts' => -1,  
        'order' => 'ASC',  
    'post_status' => null,  
    'post_parent' => $post->ID  
);   
 
        $img = wp_get_attachment_thumb_url( 10 ); 
echo "<img src='$img'>";




                endwhile; 
                endif; ?>

            </div><!-- #content -->
        </div><!-- #primary -->

<?php get_footer(); ?>