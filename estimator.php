<?php

// if the hidden form input (name=human) is filled in it usually means a bot 
// filled it without looking at the form
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['human']) ) {
	// if the same billing info checkbox is not checked
	// and any of the billing fileds are empty send an error message.
	if ( !isset($_POST['equal']) && (empty($_POST['billing']) || empty($_POST['bcity']) || empty($_POST['bpostal'])) ) {
		$status = '<p class="error">Please fill in the Billing Information.</p>';
	}
	else {
		$inputs = array(
			'name'     => safe_input($_POST['first']),
			'number'   => safe_input($_POST['number']),
			'company'    => safe_input($_POST['company']),
			'email'    => safe_input($_POST['email']),
			'address'  => safe_input($_POST['address']),
			'city'  => safe_input($_POST['city']),
			'postal'  => safe_input($_POST['postal']),
			'billing'  => safe_input($_POST['billing']),
			'bcity'  => safe_input($_POST['bcity']),
			'bpostal'  => safe_input($_POST['bpostal']),
			'service'  => safe_input($_POST['service']),
			'perform'  => safe_input($_POST['perform']),
			'special'  => safe_input($_POST['special']),
			'rate'  => safe_input($_POST['rate']),
			'flat'  => safe_input($_POST['flat']),
			'extra'  => safe_input($_POST['extra']),
			'clean'  => safe_input($_POST['clean']),
			'contaminated'  => safe_input($_POST['contaminated']),
			'additional'  => safe_input($_POST['additional']),
			'time'  => safe_input($_POST['time']),
			'truck'  => safe_input($_POST['truck']),
			'disposal'  => safe_input($_POST['disposal']),
			'other'    => safe_input($_POST['other']),
			'surcharge' => safe_input($_POST['surcharge']),
			'tax'  => safe_input($_POST['tax']),
			'total'  => safe_input($_POST['total'])
		);
		// Takes an associative array and turn the keys into variables 
		// instead of refering to $input[$key]
		extract($inputs);

		// checks for if the user selects the checkbox if the billing = shipping
		// or else set the email inputs and labels
		if ( isset($_POST['equal']) ) {
			$billing = "Billing Address is the same as Shipping address";
			$bcity = '';
			$bpostal = '';
		}
		else {
			$billing = optional('', $billing);
			$bcity = optional('', $bcity);
			$bpostal = optional('', $bpostal);
		}

		// Optional fields and their labels. set labels only
		// if the label is on the same line as the input 
		// in the email. 
		$company = optional('', $company);
		$special = optional('Special Instructions:<br>', $special);
		$rate = optional( 'Truck rate per hour$:', $rate);
		$flat = optional('Truck flat per hour$: ', $flat);
		$extra = optional('Extra Labour: ', $extra);
		$clean = optional('Disposal rate (clean): ', $clean);
		$contaminated = optional('Disposal rate (contaminated): ', $contaminated);
		$additional = optional('Additional charges (hose/other equipment): ', $additional);
		$time = optional('Time estimate on site: ', $time);
		$truck = optional('Truck cost: ', $truck);
		$disposal = optional('Disposal: ', $disposal);
		$other = optional('Other: ', $other);
		$surcharge = optional('Fuel Surcharge: ', $surcharge);
		
		// extra email information
		$date = get_the_date();

		// heredocs used to easily create email structure
		// optional inputs are just the variable themselves
		// the closing EOT; cannot have any spaces or tabs
		$advantage_email = <<<EOT
			$date

			<h2>Customer</h2>
		    <p>
		    $name<br>
			$company<br>
			$email<br>
			$number
			</p>
			
			
			<h2>Shipping Address</h2>
			<p>
				$address,<br>
				$city $postal
			</p>

			<h2>Billing Address</h2>
			<p>
				$billing,<br>
				$bcity $bpostal
			</p>
			
			<h2>Services</h2>
			<p>
				Service Type: $service<br>
				Services to be performed:<br>
				$perform
			</p>
			
			<p>
				$special
			</p>
			<p>
				$rate
				$flat
				$extra
				$clean
				$contaminated
				$additional
			</p>

			<p>$time</p>
			<p>
				$truck
				$disposal
				$other
				$surcharge
			</p>

			<p>Taxes: $tax</p>

			<p><b>Total: $total</b><p>

			<p>Interest will be charged on unpaid accounts at the rate of 2% per month (24% per annum).</p>

			<p>This quotation is valid for 30 days.</p>
EOT;

		$advantage_logo = '<a href="http://www.advantagewaste.com/"><img class="alignright size-medium wp-image-16" title="Advantage Waste Estimation Form" src="http://advantage.reframemarketing.com/wp-content/uploads/2012/06/Advantage-Waste-Logo-300x225.jpg" alt="" width="200" height="150" /></a>';
		$customer_email = <<<EOC
			$advantage_logo
			
			<p>Dear $name,</p>
			<p>Thank you for taking the time to speak with me today to go over your job requirements.</p>
			<p>As promised, below is your job estimate.</p>

			$advantage_email

			<p>To give the go ahead on this estimate or if you have any further questions, please reply back to this email or call 604-630-8755.</p>
			<p>
				Thank you,</br>
				Alan Roersma<br>
				Owner<br>
				Advantage Waste<br> 
				604-630-8755<br>
				alanroersma@advantagewaste.com<br>
				http://www.advantagewaste.com<br>
			</p>
EOC;

		// set Advantage email to, subject, headers 
		$to = 'whuang@reframemarketing.com';
		$company_name = !empty($_POST['company']) ? ", {$_POST['company']}" : '';
		$subject = 'Estimate For ' . $name . $company_name;
		$headers[] = 'From: Advantage <info@advantagewaste.com>';

		// set Customer email to, subject, headers 
		$customer_to = $email;
		$customer_subject = 'Advantage Waste Estimate';
		$customer_headers[] = 'From: Alan Roersma <alanroersma@advantagewaste.com>';

		// Set email to html type
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );

		// To Advantage
		wp_mail($to, $subject, $advantage_email, $headers);

		// To Customer
		wp_mail($customer_to, $customer_subject, $customer_email, $customer_headers);

		// remove html email type back to text/plain to avoid errors
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		// reset super global
		$_POST[] = array();
		
		// set the status message when the form is submitted.
		$status = '<p class="submission">Form Submitted</p>';
	}
}