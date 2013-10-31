<?php
/**
 * Template Name: Estimator
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

include 'estimator.php';

get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->

				<form action="<?php the_permalink(); ?>" method="POST">
					<?php echo isset($status) ? $status : ''; ?>
					<ul>
						<fieldset>
							<legend>Customer:</legend>
							<li>
								<label for="first" class="required">Name</label>
								<input type="text" maxlength="30" placeholder="First Name..." name="first" id="first" value="<?= old('first'); ?>" autofocus required/>
							</li>

							<li>
								<label for="number" class="required">Phone Number</label>
								<input type="text" maxlength="20" placeholder="xxx-xxx-xxxx" name="number" id="number" value="<?= old('number') ?>" required/>
							</li>

							<li>
								<label for="company" class="optional">Company Name</label>
								<input type="text" maxlength="50" name="company" id="company" value="<?= old('company'); ?>" />
							</li>

							<li>
								<label for="email" class="required">Email</label>
								<input type="email" maxlength="250" placeholder="example@email.com" name="email" id="email" value="<?= old('email'); ?>" required/>
							</li>
						</fieldset>

						<fieldset>
							<legend>Shipping Information</legend>
							<li>
								<label for="address" class="required">Street Address</label>
								<textarea name="address" maxlength="400" id="address" required/><?= old('address'); ?></textarea>
							</li>

							<li>
								<label for="city" class="required">City</label>
								<input type="text" maxlength="25" name="city" id="city" value="<?= old('city'); ?>" required/>
							</li>

							<li>
								<label for="postal" class="required">Postal Code</label>
								<input type="text" maxlength="7" name="postal" id="postal" value="<?= old('postal'); ?>" required/>
							</li>
						</fieldset>
						
						<fieldset>
							<input type="checkbox" class="addChk" id="equal" name="equal" value="equal"/>
							<label for="equal" class="check">Billing address same as shipping address</label>
							<script type="text/javascript">
							$('.addChk').click(function() {
							    if( $(this).is(':checked')) {
							        $(".billing").hide();
							    } else {
							        $(".billing").show();
							    }
							}); 
							</script>
						</fieldset>
						
						<fieldset>
							<div class="billing">
								<legend>Billing Information</legend>
								<li>
									<label for="billing" class="required">Street Address</label>
									<textarea name="billing" id="billing" /><?= old('billing'); ?></textarea>
								</li>

								<li>
									<label for="bcity" class="required">City</label>
									<input type="text" maxlength="25" name="bcity" id="bcity" value="<?= old('bcity'); ?>" />
								</li>

								<li>
									<label for="bpostal" class="required">Postal Code</label>
									<input type="text" maxlength="7" name="bpostal" id="bpostal" value="<?= old('bpostal'); ?>" />
								</li>
							</div>
						</fieldset>

						<fieldset>
							<legend>Service Information</legend>
							<li>
								<label for="service" class="required">Service Type</label>
								<div class="radio">
									<input type="radio" name="service" value="Commercial" id="commercial" required <?= old_radio('service', 'Commercial'); ?>/>
									<label for="commercial">Commercial</label>
								</div>
								<div class="radio">
									<input type="radio" name="service" value="Residential" id="residential" required <?= old_radio('service', 'Residential'); ?>/>
									<label for="residential">Residential</label>
								</div>
							</li>

							<li>
								<label for="perform" class="required">Services to be performed: (remember "MADE")</label>
								<textarea name="perform" maxlength="255" id="perform" required><?= old('perform'); ?></textarea>
							</li>

							<li>
								<label for="special" class="optional">Special instructions</label>
								<textarea name="special" maxlength="255" id="special" ><?= old('special'); ?></textarea>
							</li>

							<li>
								<label for="rate" class="optional">Truck rate per hour$</label>
								<input type="text" name="rate" maxlength="10" id="rate" value="<?= old('rate'); ?>" />
							</li>

							<li>
								<label for="flat" class="optional">Truck flat rate$</label>
								<input type="text" name="flat" maxlength="10" id="flat" value="<?= old('flat'); ?>" />
							</li>

							<li>
								<label for="extra" class="optional">Extra labour$</label>
								<input type="text" name="extra" maxlength="10" id="extra" value="<?= old('extra'); ?>" />
							</li>

							<li>
								<label for="clean" class="optional">Disposal rate (clean)</label>
								<input type="text" name="clean" maxlength="10" id="clean" value="<?= old('clean'); ?>" />
							</li>

							<li>
								<label for="contaminated" class="optional">Disposal rate (contaminated)</label>
								<input type="text" name="contaminated" maxlength="10" id="contaminated" value="<?= old('contaminated'); ?>" />
							</li>

							<li>
								<label for="additional" class="optional">Additional charges (hose/other equipment)</label>
								<input type="text" name="additional" maxlength="10" id="additional" value="<?= old('additional'); ?>" />
							</li>

							<li>
								<label for="time" class="optional">Time estimated on site</label>
								<input type="text" name="time" maxlength="10" id="time" value="<?= old('time'); ?>" />
							</li>

							<li>
								<label for="truck" class="optional">Truck cost</label>
								<input type="text" name="truck" maxlength="10" id="truck" value="<?= old('truck'); ?>" />
							</li>

							<li>
								<label for="disposal" class="optional">Disposal</label>
								<input type="text" name="disposal" maxlength="10" id="disposal" value="<?= old('disposal'); ?>" />
							</li>

							<li>
								<label for="other" class="optional">Other</label>
								<input type="text" name="other" maxlength="40" id="other" value="<?= old('other'); ?>" />
							</li>
							
							<li>
								<label for="surcharge" class="optional">Fuel Surcharge</label>
								<input type="text" name="surcharge" maxlength="10" id="surcharge" value="<?= old('surcharge'); ?>" />
							</li>

							<li>
								<label for="tax" class="required">Taxes</label>
								<input type="text" name="tax" id="tax" maxlength="10" value="<?= old('tax'); ?>" required/>
							</li>

							<li>
								<label for="total" class="required">Total</label>
								<input type="text" name="total" maxlength="20" id="total" value="<?= old('total'); ?>" required/>
							</li>
							<li>
								<input type="text" id="human" name="human" />
							</li>
						</fieldset>
						<li>
							<input type="submit" value="SEND"/>
						</li>
					</ul>
				</form>
			</article><!-- #post -->

		</div><!-- #content -->
	</div><!-- #primary -->
		
<?php get_footer(); ?>