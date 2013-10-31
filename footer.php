<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

		</div><!-- #main -->

		<footer id="colophon" role="contentinfo">
			<div id="footerblock">
				<div id="site-generator">
	            	&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> | Website and Hosting by <a href="http://www.reframemarketing.com/">Reframe Marketing</a>.
				</div>
			</div> <!-- #footerblock -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
</div><!-- $background -->

<?php wp_footer(); ?>

</body>
</html>