<?php
	//only admins can get this
	if(!function_exists("current_user_can") || (!current_user_can("manage_options") && !current_user_can("pmpro_paymentsettings")))
	{
		die(__("You do not have permissions to perform this action.", "pmpro"));
	}	
	
	global $wpdb, $pmpro_currency_symbol, $msg, $msgt;
	
	//get/set settings	
	if(!empty($_REQUEST['savesettings']))
	{                   
		pmpro_setOption("sslseal");
		pmpro_setOption("nuclear_HTTPS");
			
		//gateway options
		pmpro_setOption("gateway");					
		pmpro_setOption("gateway_environment");
		pmpro_setOption("gateway_email");
		pmpro_setOption("payflow_partner");
		pmpro_setOption("payflow_vendor");
		pmpro_setOption("payflow_user");
		pmpro_setOption("payflow_pwd");
		pmpro_setOption("apiusername");
		pmpro_setOption("apipassword");
		pmpro_setOption("apisignature");
		pmpro_setOption("loginname");
		pmpro_setOption("transactionkey");
		pmpro_setOption("stripe_secretkey");
		pmpro_setOption("stripe_publishablekey");
		pmpro_setOption("stripe_billingaddress");
		pmpro_setOption("braintree_merchantid");
		pmpro_setOption("braintree_publickey");
		pmpro_setOption("braintree_privatekey");
		pmpro_setOption("braintree_encryptionkey");
		pmpro_setOption("twocheckout_apiusername");
		pmpro_setOption("twocheckout_apipassword");
		pmpro_setOption("twocheckout_accountnumber");
		pmpro_setOption("twocheckout_secretword");
		pmpro_setOption("cybersource_merchantid");
		pmpro_setOption("cybersource_securitykey");
		
		//Click & Pledge
		pmpro_setOption("cnp_AccountID");
		pmpro_setOption("cnp_AccountGuid");
		pmpro_setOption("cnp_email_customer");
		pmpro_setOption("cnp_OrganizationInformation");
		pmpro_setOption("cnp_ThankYouMessage");
		pmpro_setOption("cnp_TermsCondition");
		
		pmpro_setOption("cnp_email_customer_recurring");
		pmpro_setOption("cnp_OrganizationInformation_subscription");
		pmpro_setOption("cnp_ThankYouMessage_subscription");
		pmpro_setOption("cnp_TermsCondition_subscription");
		
		pmpro_setOption("cnp_email_customer_trial");
		pmpro_setOption("cnp_OrganizationInformation_trial");
		pmpro_setOption("cnp_ThankYouMessage_trial");
		pmpro_setOption("cnp_TermsCondition_trial");
		
		pmpro_setOption("cnp_tax_state_rate");
		
		//currency
		pmpro_setOption("currency");
			
		//credit cards
		$pmpro_accepted_credit_cards = array();
		if(!empty($_REQUEST['creditcards_visa']))
			$pmpro_accepted_credit_cards[] = "Visa";
		if(!empty($_REQUEST['creditcards_mastercard']))
			$pmpro_accepted_credit_cards[] = "Mastercard";
		if(!empty($_REQUEST['creditcards_amex']))
			$pmpro_accepted_credit_cards[] = "American Express";
		if(!empty($_REQUEST['creditcards_discover']))
			$pmpro_accepted_credit_cards[] = "Discover";
		if(!empty($_REQUEST['creditcards_dinersclub']))
			$pmpro_accepted_credit_cards[] = "Diners Club";
		if(!empty($_REQUEST['creditcards_enroute']))
			$pmpro_accepted_credit_cards[] = "EnRoute";
		if(!empty($_REQUEST['creditcards_jcb']))
			$pmpro_accepted_credit_cards[] = "JCB";
		
		//check instructions
		pmpro_setOption("instructions");
		
		//use_ssl
		pmpro_setOption("use_ssl");				
		
		//tax
		pmpro_setOption("tax_state");
		pmpro_setOption("tax_rate");
		
		pmpro_setOption("accepted_credit_cards", implode(",", $pmpro_accepted_credit_cards));	

		//assume success
		$msg = true;
		$msgt = __("Your payment settings have been updated.", "pmpro");			
	}
	
	$sslseal = pmpro_getOption("sslseal");
	$nuclear_HTTPS = pmpro_getOption("nuclear_HTTPS");
	
	$gateway = pmpro_getOption("gateway");
	$gateway_environment = pmpro_getOption("gateway_environment");
	$gateway_email = pmpro_getOption("gateway_email");
	$payflow_partner = pmpro_getOption("payflow_partner");
	$payflow_vendor = pmpro_getOption("payflow_vendor");
	$payflow_user = pmpro_getOption("payflow_user");
	$payflow_pwd = pmpro_getOption("payflow_pwd");
	$apiusername = pmpro_getOption("apiusername");
	$apipassword = pmpro_getOption("apipassword");
	$apisignature = pmpro_getOption("apisignature");
	$loginname = pmpro_getOption("loginname");
	$transactionkey = pmpro_getOption("transactionkey");
	$stripe_secretkey = pmpro_getOption("stripe_secretkey");
	$stripe_publishablekey = pmpro_getOption("stripe_publishablekey");		
	$stripe_billingaddress = pmpro_getOption("stripe_billingaddress");
	$braintree_merchantid = pmpro_getOption("braintree_merchantid");
	$braintree_publickey = pmpro_getOption("braintree_publickey");
	$braintree_privatekey = pmpro_getOption("braintree_privatekey");
	$braintree_encryptionkey = pmpro_getOption("braintree_encryptionkey");
	$twocheckout_apiusername = pmpro_getOption("twocheckout_apiusername");
	$twocheckout_apipassword = pmpro_getOption("twocheckout_apipassword");
	$twocheckout_accountnumber = pmpro_getOption("twocheckout_accountnumber");
	$twocheckout_secretword = pmpro_getOption("twocheckout_secretword");
	$cybersource_merchantid = pmpro_getOption("cybersource_merchantid");
	$cybersource_securitykey = pmpro_getOption("cybersource_securitykey");
	
	$cnp_AccountID = pmpro_getOption("cnp_AccountID");
	$cnp_AccountGuid = pmpro_getOption("cnp_AccountGuid");
	$cnp_email_customer = pmpro_getOption("cnp_email_customer");
	$cnp_OrganizationInformation = pmpro_getOption("cnp_OrganizationInformation");
	$cnp_ThankYouMessage = pmpro_getOption("cnp_ThankYouMessage");
	$cnp_TermsCondition = pmpro_getOption("cnp_TermsCondition");
	
	$cnp_email_customer_recurring = pmpro_getOption("cnp_email_customer_recurring");
	$cnp_OrganizationInformation_subscription = pmpro_getOption("cnp_OrganizationInformation_subscription");
	$cnp_ThankYouMessage_subscription = pmpro_getOption("cnp_ThankYouMessage_subscription");
	$cnp_TermsCondition_subscription = pmpro_getOption("cnp_TermsCondition_subscription");
	
	$cnp_email_customer_trial = pmpro_getOption("cnp_email_customer_trial");
	$cnp_OrganizationInformation_trial = pmpro_getOption("cnp_OrganizationInformation_trial");
	$cnp_ThankYouMessage_trial = pmpro_getOption("cnp_ThankYouMessage_trial");
	$cnp_TermsCondition_trial = pmpro_getOption("cnp_TermsCondition_trial");

	$cnp_tax_state_rate = pmpro_getOption("cnp_tax_state_rate");
	
	$currency = pmpro_getOption("currency");
	
	$pmpro_accepted_credit_cards = pmpro_getOption("accepted_credit_cards");
	
	$instructions = pmpro_getOption("instructions");
	
	$tax_state = pmpro_getOption("tax_state");
	$tax_rate = pmpro_getOption("tax_rate");		
	
	//make sure the tax rate is not > 1
	if((double)$tax_rate > 1)
	{
		//assume the entered X%
		$tax_rate = $tax_rate / 100;
		pmpro_setOption("tax_rate", $tax_rate);
	}
	
	$use_ssl = pmpro_getOption("use_ssl");	
	
	//default settings			
	if(empty($gateway_environment))
	{
		$gateway_environment = "sandbox";
		pmpro_setOption("gateway_environment", $gateway_environment);
	}
	if(empty($pmpro_accepted_credit_cards))
	{
		$pmpro_accepted_credit_cards = "Visa,Mastercard,American Express,Discover";
		pmpro_setOption("accepted_credit_cards", $pmpro_accepted_credit_cards);		
	}
	
	$pmpro_accepted_credit_cards = explode(",", $pmpro_accepted_credit_cards);
						
	require_once(dirname(__FILE__) . "/admin_header.php");		
?>

	<form action="" method="post" enctype="multipart/form-data">         
		<h2><?php _e('Payment Gateway', 'pmpro');?> &amp; <?php _e('SSL Settings', 'pmpro');?></h2>
		
		<p><?php _e('Learn more about <a title="Paid Memberships Pro - SSL Settings" target="_blank" href="http://www.paidmembershipspro.com/support/initial-plugin-setup/ssl/">SSL</a> or <a title="Paid Memberships Pro - Payment Gateway Settings" target="_blank" href="http://www.paidmembershipspro.com/support/initial-plugin-setup/payment-gateway/">Payment Gateway Settings</a>.', 'pmpro'); ?></p>
		
		<table class="form-table">
		<tbody>                		   
			<tr>
				<th scope="row" valign="top">	
					<label for="gateway"><?php _e('Payment Gateway', 'pmpro');?>:</label>
				</th>
				<td>
					<select id="gateway" name="gateway" onchange="pmpro_changeGateway(jQuery(this).val());">
						<option value="">Testing Only</option>
						<option value="cnp" <?php selected( $gateway, "cnp" ); ?>><?php _e('Click & Pledge', 'pmpro');?></option>
						<option value="check" <?php selected( $gateway, "check" ); ?>><?php _e('Pay by Check', 'pmpro');?></option>
						<option value="stripe" <?php selected( $gateway, "stripe" ); ?>>Stripe</option>						
						<option value="paypalexpress" <?php selected( $gateway, "paypalexpress" ); ?>>PayPal Express</option>
						<option value="paypal" <?php selected( $gateway, "paypal" ); ?>>PayPal Website Payments Pro</option>
						<option value="payflowpro" <?php selected( $gateway, "payflowpro" ); ?>>PayPal Payflow Pro/PayPal Pro</option>
						<option value="paypalstandard" <?php selected( $gateway, "paypalstandard" ); ?>>PayPal Standard</option>
						<option value="authorizenet" <?php selected( $gateway, "authorizenet" ); ?>>Authorize.net</option>
						<option value="braintree" <?php selected( $gateway, "braintree" ); ?>>Braintree Payments</option>
						<option value="twocheckout" <?php selected( $gateway, "twocheckout" ); ?>>2Checkout</option>
						<option value="cybersource" <?php selected( $gateway, "cybersource" ); ?>>CyberSource</option>
					</select>                        
				</td>
			</tr>
			<tr class="gateway gateway_cybersource gateway_twocheckout" <?php if($gateway != "cybersource" && $gateway != "twocheckout") { ?>style="display: none;"<?php } ?>>
				<td colspan="2">
					<strong><?php _e('Note', 'pmpro');?>:</strong> <?php _e('This gateway option is in beta. Some functionality may not be available. Please contact Paid Memberships Pro with any issues you run into. <strong>Please be sure to upgrade Paid Memberships Pro to the latest versions when available.</strong>', 'pmpro');?>
				</td>	
			</tr>
			<tr class="gateway gateway_paypalstandard" <?php if($gateway != "paypalstandard") { ?>style="display: none;"<?php } ?>>
				<td colspan="2">
					<strong><?php _e('Note', 'pmpro');?>:</strong> <?php _e('We do not recommend using PayPal Standard. We suggest using PayPal Express, Website Payments Pro (Legacy), or PayPal Pro (Payflow Pro). <a target="_blank" href="http://www.paidmembershipspro.com/2013/09/read-using-paypal-standard-paid-memberships-pro/">More information on why can be found here.</a>', 'pmpro');?>
				</td>	
			</tr>			
			<tr>
				<th scope="row" valign="top">
					<label for="gateway_environment"><?php _e('Gateway Environment', 'pmpro');?>:</label>
				</th>
				<td>
					<select name="gateway_environment">
						<option value="sandbox" <?php selected( $gateway_environment, "sandbox" ); ?>><?php _e('Sandbox/Testing', 'pmpro');?></option>
						<option value="live" <?php selected( $gateway_environment, "live" ); ?>><?php _e('Live/Production', 'pmpro');?></option>
					</select>
					<script>
						function pmpro_changeGateway(gateway)
						{							
							//hide all gateway options
							jQuery('tr.gateway').hide();
							jQuery('tr.gateway_'+gateway).show();
						}
						pmpro_changeGateway(jQuery('#gateway').val());
					</script>
				</td>
		   </tr>
		   
		   <!--Click & Pledge Start-->
		   <tr class="gateway gateway_cnp" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_AccountID"><?php _e('Account ID', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="cnp_AccountID" name="cnp_AccountID" size="60" value="<?php echo esc_attr($cnp_AccountID)?>" /><br />
					Get your "Account ID" from Click & Pledge. [Portal > Account Info > API Information].
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_AccountGuid"><?php _e('API Account GUID', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="cnp_AccountGuid" name="cnp_AccountGuid" size="60" value="<?php echo esc_attr($cnp_AccountGuid)?>" /><br />
					Get your "API Account GUID" from Click & Pledge [Portal > Account Info > API Information].
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_email_customer"><?php _e('Send Receipt to Patron (Initial Payment)', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="checkbox" id="cnp_email_customer" name="cnp_email_customer" size="60" value="1" <?php if($cnp_email_customer == '1') { ?>checked<?php } ?>/>
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_OrganizationInformation" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_OrganizationInformation"><?php _e('Organization Information', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_OrganizationInformation" name="cnp_OrganizationInformation" rows="3" cols="80"><?php echo esc_attr($cnp_OrganizationInformation)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_OrganizationInformation_countdown">1500</span> characters left.
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_ThankYouMessage" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_ThankYouMessage"><?php _e('Thank You Message', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_ThankYouMessage" name="cnp_ThankYouMessage" rows="3" cols="80"><?php echo esc_attr($cnp_ThankYouMessage)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_ThankYouMessage_countdown">1500</span> characters left.
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_TermsCondition" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_TermsCondition"><?php _e('Terms & Conditions', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_TermsCondition" name="cnp_TermsCondition" rows="3" cols="80"><?php echo esc_attr($cnp_TermsCondition)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_TermsCondition_countdown">1500</span> characters left.
				</td>
		   </tr>
		   <script>
			   jQuery(document).ready(function(){
				function in_array(needle, haystack, argStrict) {
				  var key = '',
					strict = !! argStrict;
				  if (strict) {
					for (key in haystack) {
					  if (haystack[key] === needle) {
						return true;
					  }
					}
				  } else {
					for (key in haystack) {
					  if (haystack[key] == needle) {
						return true;
					  }
					}
				  }

				  return false;
				}
				
				/*
				if(jQuery('#cnp_email_customer').is(":checked"))
				{
					jQuery('.cnp_OrganizationInformation').show();
					jQuery('.cnp_ThankYouMessage').show();
					jQuery('.cnp_TermsCondition').show();
				}
				else
				{
					jQuery('.cnp_OrganizationInformation').hide();
					jQuery('.cnp_ThankYouMessage').hide();
					jQuery('.cnp_TermsCondition').hide();
				}
				
				jQuery('#cnp_email_customer').click(function(){
					if(jQuery('#cnp_email_customer').is(":checked"))
					{
						jQuery('.cnp_OrganizationInformation').show();
						jQuery('.cnp_ThankYouMessage').show();
						jQuery('.cnp_TermsCondition').show();
					}
					else
					{
						jQuery('.cnp_OrganizationInformation').hide();
						jQuery('.cnp_ThankYouMessage').hide();
						jQuery('.cnp_TermsCondition').hide();
					}
				});
				*/
				if(jQuery('#gateway').val() == 'cnp')
				{
					jQuery('input[name="creditcards_dinersclub"]').attr('checked', false);
					//jQuery('input[name="creditcards_dinersclub"]').attr('onclick', 'return false');
					jQuery('input[name="creditcards_enroute"]').attr('checked', false);
					//jQuery('input[name="creditcards_enroute"]').attr('onclick', 'return false');
				}
				jQuery( "form" ).submit(function( event ) {
					if(jQuery('#gateway').val() == 'cnp')
					{
						if(jQuery('#cnp_AccountID').val() == '')
						{
							alert('Please enter AccountID');
							jQuery('#cnp_AccountID').focus();
							return false;
						}
						
						if(jQuery('#cnp_AccountGuid').val() == '')
						{
							alert('Please enter AccountGuid');
							jQuery('#cnp_AccountGuid').focus();
							return false;
						}
						var all_cards = new Array();
						var all_cards_object = jQuery( "input[name*='creditcards_']" );
						var cnp_accepted_cards = new Array('creditcards_visa', 'creditcards_mastercard', 'creditcards_amex', 'creditcards_discover', 'creditcards_jcb');
						var selected_cards = new Array();
						all_cards_object.each(function(){
							all_cards.push(jQuery(this).attr('name'));
							if(jQuery(this).is(':checked')) 
							selected_cards.push(jQuery(this).attr('name'));
						});
						
						if(selected_cards.length == 0)
						{
							alert('Please select at least  one card');
							jQuery('input[name="creditcards_visa"]').focus();
							return false;
						}
						
						for(var i = 0; i < selected_cards.length; i++ )
						{
							if(!in_array(selected_cards[i], cnp_accepted_cards))
							{
								alert('Click & Pledge not accepting '+selected_cards[i].substr(12).toUpperCase());
								jQuery(this).focus();
								return false;
							}
						}
						
						
						var cards = 0;
						if(jQuery('input[name="creditcards_visa"]').is(':checked'))
						{
							cards++;
						}					
						if(jQuery('input[name="creditcards_mastercard"]').is(':checked'))
						{
							cards++;
						}
						if(jQuery('input[name="creditcards_amex"]').is(':checked'))
						{
							cards++;
						}
						if(jQuery('input[name="creditcards_discover"]').is(':checked'))
						{
							cards++;
						}
						if(jQuery('input[name="creditcards_jcb"]').is(':checked'))
						{
							cards++;
						}
						if(cards == 0) 
						{
							alert('Please select at least  one card');
							jQuery('input[name="creditcards_visa"]').focus();
							return false;
						}
					}
				});
				
				function limitText(limitField, limitCount, limitNum) {
					if (limitField.val().length > limitNum) {
						limitField.val( limitField.val().substring(0, limitNum) );
					} else {
						limitCount.html (limitNum - limitField.val().length);
					}
				}
				limitText(jQuery('#cnp_OrganizationInformation'),jQuery('#cnp_OrganizationInformation_countdown'),1500);
				
				limitText(jQuery('#cnp_ThankYouMessage'),jQuery('#cnp_ThankYouMessage_countdown'),500);
				
				limitText(jQuery('#cnp_TermsCondition'),jQuery('#cnp_TermsCondition_countdown'),1500);
				
				//OrganizationInformation
				jQuery('#cnp_OrganizationInformation').keydown(function(){
					limitText(jQuery('#cnp_OrganizationInformation'),jQuery('#cnp_OrganizationInformation_countdown'),1500);
				});
				jQuery('#cnp_OrganizationInformation').keyup(function(){
					limitText(jQuery('#cnp_OrganizationInformation'),jQuery('#cnp_OrganizationInformation_countdown'),1500);
				});
				//ThankYouMessage
				jQuery('#cnp_ThankYouMessage').keydown(function(){
					limitText(jQuery('#cnp_ThankYouMessage'),jQuery('#cnp_ThankYouMessage_countdown'),500);
				});
				jQuery('#cnp_ThankYouMessage').keyup(function(){
					limitText(jQuery('#cnp_ThankYouMessage'),jQuery('#cnp_ThankYouMessage_countdown'),500);
				});
				//TermsCondition
				jQuery('#cnp_TermsCondition').keydown(function(){
					limitText(jQuery('#cnp_TermsCondition'),jQuery('#cnp_TermsCondition_countdown'),1500);
				});
				jQuery('#cnp_TermsCondition').keyup(function(){
					limitText(jQuery('#cnp_TermsCondition'),jQuery('#cnp_TermsCondition_countdown'),1500);
				});
			   });
		   </script>
		   
		   
		   
		   <tr class="gateway gateway_cnp" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_email_customer_trial"><?php _e('Send Receipt to Patron (Custom Trial)', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="checkbox" id="cnp_email_customer_trial" name="cnp_email_customer_trial" size="60" value="1" <?php if($cnp_email_customer_trial == '1') { ?>checked<?php } ?>/>
				</td>
		   </tr>
		    <tr class="gateway gateway_cnp cnp_OrganizationInformation_trial" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_OrganizationInformation_trial"><?php _e('Organization Information', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_OrganizationInformation_trial" name="cnp_OrganizationInformation_trial" rows="3" cols="80"><?php echo esc_attr($cnp_OrganizationInformation_trial)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_OrganizationInformation_countdown_trial">1500</span> characters left.
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_ThankYouMessage_trial" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_ThankYouMessage_trial"><?php _e('Thank You Message', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_ThankYouMessage_trial" name="cnp_ThankYouMessage_trial" rows="3" cols="80"><?php echo esc_attr($cnp_ThankYouMessage_trial)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_ThankYouMessage_countdown_trial">1500</span> characters left.
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_TermsCondition_trial" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_TermsCondition_trial"><?php _e('Terms & Conditions', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_TermsCondition_trial" name="cnp_TermsCondition_trial" rows="3" cols="80"><?php echo esc_attr($cnp_TermsCondition_trial)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_TermsCondition_countdown_trial">1500</span> characters left.
				</td>
		   </tr>
		   <script>
			   jQuery(document).ready(function(){
				function in_array(needle, haystack, argStrict) {
				  var key = '',
					strict = !! argStrict;
				  if (strict) {
					for (key in haystack) {
					  if (haystack[key] === needle) {
						return true;
					  }
					}
				  } else {
					for (key in haystack) {
					  if (haystack[key] == needle) {
						return true;
					  }
					}
				  }

				  return false;
				}
				
				/*
				if(jQuery('#cnp_email_customer_trial').is(":checked"))
				{
					jQuery('.cnp_OrganizationInformation_trial').show();
					jQuery('.cnp_ThankYouMessage_trial').show();
					jQuery('.cnp_TermsCondition_trial').show();
				}
				else
				{
					jQuery('.cnp_OrganizationInformation_trial').hide();
					jQuery('.cnp_ThankYouMessage_trial').hide();
					jQuery('.cnp_TermsCondition_trial').hide();
				}
				
				jQuery('#cnp_email_customer_trial').click(function(){
					if(jQuery('#cnp_email_customer_trial').is(":checked"))
					{
						jQuery('.cnp_OrganizationInformation_trial').show();
						jQuery('.cnp_ThankYouMessage_trial').show();
						jQuery('.cnp_TermsCondition_trial').show();
					}
					else
					{
						jQuery('.cnp_OrganizationInformation_trial').hide();
						jQuery('.cnp_ThankYouMessage_trial').hide();
						jQuery('.cnp_TermsCondition_trial').hide();
					}
				});
				*/				
				function limitText(limitField, limitCount, limitNum) {
					if (limitField.val().length > limitNum) {
						limitField.val( limitField.val().substring(0, limitNum) );
					} else {
						limitCount.html (limitNum - limitField.val().length);
					}
				}
				limitText(jQuery('#cnp_OrganizationInformation_trial'),jQuery('#cnp_OrganizationInformation_countdown_trial'),1500);
				
				limitText(jQuery('#cnp_ThankYouMessage_trial'),jQuery('#cnp_ThankYouMessage_countdown_trial'),500);
				
				limitText(jQuery('#cnp_TermsCondition_trial'),jQuery('#cnp_TermsCondition_countdown_trial'),1500);
				
				//OrganizationInformation
				jQuery('#cnp_OrganizationInformation_trial').keydown(function(){
					limitText(jQuery('#cnp_OrganizationInformation_trial'),jQuery('#cnp_OrganizationInformation_countdown_trial'),1500);
				});
				jQuery('#cnp_OrganizationInformation').keyup(function(){
					limitText(jQuery('#cnp_OrganizationInformation'),jQuery('#cnp_OrganizationInformation_countdown'),1500);
				});
				//ThankYouMessage
				jQuery('#cnp_ThankYouMessage_trial').keydown(function(){
					limitText(jQuery('#cnp_ThankYouMessage_trial'),jQuery('#cnp_ThankYouMessage_countdown_trial'),500);
				});
				jQuery('#cnp_ThankYouMessage_trial').keyup(function(){
					limitText(jQuery('#cnp_ThankYouMessage_trial'),jQuery('#cnp_ThankYouMessage_countdown_trial'),500);
				});
				//TermsCondition
				jQuery('#cnp_TermsCondition_trial').keydown(function(){
					limitText(jQuery('#cnp_TermsCondition_trial'),jQuery('#cnp_TermsCondition_countdown_trial'),1500);
				});
				jQuery('#cnp_TermsCondition_trial').keyup(function(){
					limitText(jQuery('#cnp_TermsCondition_trial'),jQuery('#cnp_TermsCondition_countdown_trial'),1500);
				});
			   });
		   </script>
		   
		   	
		   <tr class="gateway gateway_cnp" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_email_customer_recurring"><?php _e('Send Receipt to Patron (Recurring Subscription)', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="checkbox" id="cnp_email_customer_recurring" name="cnp_email_customer_recurring" size="60" value="1" <?php if($cnp_email_customer_recurring == '1') { ?>checked<?php } ?>/>
				</td>
		   </tr>
		    <tr class="gateway gateway_cnp cnp_OrganizationInformation_subscription" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_OrganizationInformation_subscription"><?php _e('Organization Information', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_OrganizationInformation_subscription" name="cnp_OrganizationInformation_subscription" rows="3" cols="80"><?php echo esc_attr($cnp_OrganizationInformation_subscription)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_OrganizationInformation_countdown_subscription">1500</span> characters left.
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_ThankYouMessage_subscription" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_ThankYouMessage_subscription"><?php _e('Thank You Message', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_ThankYouMessage_subscription" name="cnp_ThankYouMessage_subscription" rows="3" cols="80"><?php echo esc_attr($cnp_ThankYouMessage_subscription)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_ThankYouMessage_countdown_subscription">1500</span> characters left.
				</td>
		   </tr>
		   <tr class="gateway gateway_cnp cnp_TermsCondition_subscription" <?php if($gateway != "cnp") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="cnp_TermsCondition_subscription"><?php _e('Terms & Conditions', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cnp_TermsCondition_subscription" name="cnp_TermsCondition_subscription" rows="3" cols="80"><?php echo esc_attr($cnp_TermsCondition_subscription)?></textarea>
					<br />
					Maximum: 1500 characters, the following HTML tags are allowed: &lt;P&gt;&lt;/P&gt;&lt;BR /&gt;&lt;OL&gt;&lt;/OL&gt;&lt;LI&gt;&lt;/LI&gt;&lt;UL&gt;&lt;/UL&gt;.<br>You have <span id="cnp_TermsCondition_countdown_subscription">1500</span> characters left.
				</td>
		   </tr>
		   <script>
			   jQuery(document).ready(function(){
				function in_array(needle, haystack, argStrict) {
				  var key = '',
					strict = !! argStrict;
				  if (strict) {
					for (key in haystack) {
					  if (haystack[key] === needle) {
						return true;
					  }
					}
				  } else {
					for (key in haystack) {
					  if (haystack[key] == needle) {
						return true;
					  }
					}
				  }

				  return false;
				}
				
				/*
				if(jQuery('#cnp_email_customer_recurring').is(":checked"))
				{
					jQuery('.cnp_OrganizationInformation_subscription').show();
					jQuery('.cnp_ThankYouMessage_subscription').show();
					jQuery('.cnp_TermsCondition_subscription').show();
				}
				else
				{
					jQuery('.cnp_OrganizationInformation_subscription').hide();
					jQuery('.cnp_ThankYouMessage_subscription').hide();
					jQuery('.cnp_TermsCondition_subscription').hide();
				}
				
				jQuery('#cnp_email_customer_recurring').click(function(){
					if(jQuery('#cnp_email_customer_recurring').is(":checked"))
					{
						jQuery('.cnp_OrganizationInformation_subscription').show();
						jQuery('.cnp_ThankYouMessage_subscription').show();
						jQuery('.cnp_TermsCondition_subscription').show();
					}
					else
					{
						jQuery('.cnp_OrganizationInformation_subscription').hide();
						jQuery('.cnp_ThankYouMessage_subscription').hide();
						jQuery('.cnp_TermsCondition_subscription').hide();
					}
				});
				*/				
				function limitText(limitField, limitCount, limitNum) {
					if (limitField.val().length > limitNum) {
						limitField.val( limitField.val().substring(0, limitNum) );
					} else {
						limitCount.html (limitNum - limitField.val().length);
					}
				}
				limitText(jQuery('#cnp_OrganizationInformation_subscription'),jQuery('#cnp_OrganizationInformation_countdown_subscription'),1500);
				
				limitText(jQuery('#cnp_ThankYouMessage_subscription'),jQuery('#cnp_ThankYouMessage_countdown_subscription'),500);
				
				limitText(jQuery('#cnp_TermsCondition_subscription'),jQuery('#cnp_TermsCondition_countdown_subscription'),1500);
				
				//OrganizationInformation
				jQuery('#cnp_OrganizationInformation_subscription').keydown(function(){
					limitText(jQuery('#cnp_OrganizationInformation_subscription'),jQuery('#cnp_OrganizationInformation_countdown_subscription'),1500);
				});
				jQuery('#cnp_OrganizationInformation_subscription').keyup(function(){
					limitText(jQuery('#cnp_OrganizationInformation_subscription'),jQuery('#cnp_OrganizationInformation_countdown_subscription'),1500);
				});
				//ThankYouMessage
				jQuery('#cnp_ThankYouMessage_subscription').keydown(function(){
					limitText(jQuery('#cnp_ThankYouMessage_subscription'),jQuery('#cnp_ThankYouMessage_countdown_subscription'),500);
				});
				jQuery('#cnp_ThankYouMessage_trial').keyup(function(){
					limitText(jQuery('#cnp_ThankYouMessage_trial'),jQuery('#cnp_ThankYouMessage_countdown_trial'),500);
				});
				//TermsCondition
				jQuery('#cnp_TermsCondition_trial').keydown(function(){
					limitText(jQuery('#cnp_TermsCondition_subscription'),jQuery('#cnp_TermsCondition_countdown_subscription'),1500);
				});
				jQuery('#cnp_TermsCondition_trial').keyup(function(){
					limitText(jQuery('#cnp_TermsCondition_subscription'),jQuery('#cnp_TermsCondition_countdown_subscription'),1500);
				});
			   });
		   </script>		   
		   <!--Click & Pledge End-->
		   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="payflow_partner"><?php _e('Partner', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="payflow_partner" name="payflow_partner" size="60" value="<?php echo esc_attr($payflow_partner)?>" />
				</td>
		   </tr>
		   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="payflow_vendor"><?php _e('Vendor', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="payflow_vendor" name="payflow_vendor" size="60" value="<?php echo esc_attr($payflow_vendor)?>" />
				</td>
		   </tr>
		   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="payflow_user"><?php _e('User', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="payflow_user" name="payflow_user" size="60" value="<?php echo esc_attr($payflow_user)?>" />
				</td>
		   </tr>
		   <tr class="gateway gateway_payflowpro" <?php if($gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
			   <th scope="row" valign="top">	
					<label for="payflow_pwd"><?php _e('Password', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="password" id="payflow_pwd" name="payflow_pwd" size="60" value="<?php echo esc_attr($payflow_pwd)?>" />
				</td>
		   </tr>
		   <tr class="gateway gateway_paypal gateway_paypalexpress gateway_paypalstandard" <?php if($gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "paypalstandard") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">	
					<label for="gateway_email"><?php _e('Gateway Account Email', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="gateway_email" name="gateway_email" size="60" value="<?php echo esc_attr($gateway_email)?>" />
				</td>
			</tr>                
			<tr class="gateway gateway_paypal gateway_paypalexpress" <?php if($gateway != "paypal" && $gateway != "paypalexpress") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="apiusername"><?php _e('API Username', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="apiusername" name="apiusername" size="60" value="<?php echo esc_attr($apiusername)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_paypal gateway_paypalexpress" <?php if($gateway != "paypal" && $gateway != "paypalexpress") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="apipassword"><?php _e('API Password', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="apipassword" name="apipassword" size="60" value="<?php echo esc_attr($apipassword)?>" />
				</td>
			</tr> 
			<tr class="gateway gateway_paypal gateway_paypalexpress" <?php if($gateway != "paypal" && $gateway != "paypalexpress") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="apisignature"><?php _e('API Signature', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="apisignature" name="apisignature" size="60" value="<?php echo esc_attr($apisignature)?>" />
				</td>
			</tr> 
			
			<tr class="gateway gateway_authorizenet" <?php if($gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="loginname"><?php _e('Login Name', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="loginname" name="loginname" size="60" value="<?php echo esc_attr($loginname)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_authorizenet" <?php if($gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="transactionkey"><?php _e('Transaction Key', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="transactionkey" name="transactionkey" size="60" value="<?php echo esc_attr($transactionkey)?>" />
				</td>
			</tr>
			
			<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="stripe_secretkey"><?php _e('Secret Key', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="stripe_secretkey" name="stripe_secretkey" size="60" value="<?php echo esc_attr($stripe_secretkey)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="stripe_publishablekey"><?php _e('Publishable Key', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="stripe_publishablekey" name="stripe_publishablekey" size="60" value="<?php echo esc_attr($stripe_publishablekey)?>" />
				</td>
			</tr>						
			
			<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="braintree_merchantid"><?php _e('Merchant ID', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="braintree_merchantid" name="braintree_merchantid" size="60" value="<?php echo esc_attr($braintree_merchantid)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="braintree_publickey"><?php _e('Public Key', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="braintree_publickey" name="braintree_publickey" size="60" value="<?php echo esc_attr($braintree_publickey)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="braintree_privatekey"><?php _e('Private Key', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="braintree_privatekey" name="braintree_privatekey" size="60" value="<?php echo esc_attr($braintree_privatekey)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="braintree_encryptionkey"><?php _e('Client-Side Encryption Key', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="braintree_encryptionkey" name="braintree_encryptionkey" rows="3" cols="80"><?php echo esc_textarea($braintree_encryptionkey)?></textarea>					
				</td>
			</tr>

			<tr class="gateway gateway_twocheckout" <?php if($gateway != "twocheckout") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="twocheckout_apiusername"><?php _e('API Username', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="twocheckout_apiusername" name="twocheckout_apiusername" size="60" value="<?php echo esc_attr($twocheckout_apiusername)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_twocheckout" <?php if($gateway != "twocheckout") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="twocheckout_apipassword"><?php _e('API Password', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="twocheckout_apipassword" name="twocheckout_apipassword" size="60" value="<?php echo esc_attr($twocheckout_apipassword)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_twocheckout" <?php if($gateway != "twocheckout") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="twocheckout_accountnumber"><?php _e('Account Number', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" name="twocheckout_accountnumber" size="60" value="<?php echo $twocheckout_accountnumber?>" />
				</td>
			</tr>
			<tr class="gateway gateway_twocheckout" <?php if($gateway != "twocheckout") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="twocheckout_secretword"><?php _e('Secret Word', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" name="twocheckout_secretword" size="60" value="<?php echo $twocheckout_secretword?>" />
				</td>
			</tr>

			<tr class="gateway gateway_cybersource" <?php if($gateway != "cybersource") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="cybersource_merchantid"><?php _e('Merchant ID', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="text" id="cybersource_merchantid" name="cybersource_merchantid" size="60" value="<?php echo esc_attr($cybersource_merchantid)?>" />
				</td>
			</tr>
			<tr class="gateway gateway_cybersource" <?php if($gateway != "cybersource") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="cybersource_securitykey"><?php _e('Transaction Security Key', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="cybersource_securitykey" name="cybersource_securitykey" rows="3" cols="80"><?php echo esc_textarea($cybersource_securitykey);?></textarea>					
				</td>
			</tr>																	
			
			<tr class="gateway gateway_ gateway_paypal gateway_paypalexpress gateway_paypalstandard gateway_braintree gateway_twocheckout gateway_cybersource gateway_stripe gateway_authorizenet gateway_payflowpro gateway_check" <?php if(!empty($gateway) && $gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "paypalstandard" && $gateway != "braintree" && $gateway != "twocheckout" && $gateway != "cybersource" && $gateway != "payflowpro" && $gateway != "stripe" && $gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="currency"><?php _e('Currency', 'pmpro');?>:</label>
				</th>
				<td>
					<select name="currency">
					<?php 
						global $pmpro_currencies;
						foreach($pmpro_currencies as $ccode => $cdescription)
						{
						?>
						<option value="<?php echo $ccode?>" <?php if($currency == $ccode) { ?>selected="selected"<?php } ?>><?php echo $cdescription?></option>
						<?php
						}
					?>
					</select>
					<small><?php _e( 'Not all currencies will be supported by every gateway. Please check with your gateway.', 'pmpro' ); ?></small>
				</td>
			</tr>
			
			<tr class="gateway gateway_ gateway_stripe gateway_authorizenet gateway_paypal gateway_payflowpro gateway_braintree gateway_twocheckout gateway_cybersource gateway_cnp" <?php if(!empty($gateway) && $gateway != "authorizenet" && $gateway != "paypal" && $gateway != "stripe" && $gateway != "payflowpro" && $gateway != "braintree" && $gateway != "twocheckout" && $gateway != "cybersource" && $gateway != "cnp") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="creditcards"><?php _e('Accepted Credit Card Types', 'pmpro');?></label>
				</th>
				<td>
					<input type="checkbox" name="creditcards_visa" value="1" <?php if(in_array("Visa", $pmpro_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> Visa<br />
					<input type="checkbox" name="creditcards_mastercard" value="1" <?php if(in_array("Mastercard", $pmpro_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> Mastercard<br />
					<input type="checkbox" name="creditcards_amex" value="1" <?php if(in_array("American Express", $pmpro_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> American Express<br />
					<input type="checkbox" name="creditcards_discover" value="1" <?php if(in_array("Discover", $pmpro_accepted_credit_cards)) { ?>checked="checked"<?php } ?> /> Discover<br />					
					<?php if(!in_array($gateway, array('cnp'))) 
					{ ?>
					<input type="checkbox" name="creditcards_dinersclub" value="1" <?php if(in_array("Diners Club", $pmpro_accepted_credit_cards)) {?>checked="checked"<?php } ?> /> Diner's Club<br />
					<input type="checkbox" name="creditcards_enroute" value="1" <?php if(in_array("EnRoute", $pmpro_accepted_credit_cards)) {?>checked="checked"<?php } ?> /> EnRoute<br />
					<?php } ?>					
					<input type="checkbox" name="creditcards_jcb" value="1" <?php if(in_array("JCB", $pmpro_accepted_credit_cards)) {?>checked="checked"<?php } ?> /> JCB<br />
				</td>
			</tr>	
			<tr class="gateway gateway_check" <?php if($gateway != "check") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="instructions"><?php _e('Instructions', 'pmpro');?></label>					
				</th>
				<td>
					<textarea id="instructions" name="instructions" rows="3" cols="80"><?php echo esc_textarea($instructions)?></textarea>
					<p><small><?php _e('Who to write the check out to. Where to mail it. Shown on checkout, confirmation, and invoice pages.', 'pmpro');?></small></p>
				</td>
			</tr>
						
			<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="stripe_billingaddress"><?php _e('Show Billing Address Fields', 'pmpro');?>:</label>
				</th>
				<td>
					<select id="stripe_billingaddress" name="stripe_billingaddress">
						<option value="0" <?php if(empty($stripe_billingaddress)) { ?>selected="selected"<?php } ?>><?php _e('No', 'pmpro');?></option>
						<option value="1" <?php if(!empty($stripe_billingaddress)) { ?>selected="selected"<?php } ?>><?php _e('Yes', 'pmpro');?></option>						
					</select>
					<small><?php _e("Stripe doesn't require billing address fields. Choose 'No' to hide them on the checkout page.<br /><strong>If No, make sure you disable address verification in the Stripe dashboard settings.</strong>", 'pmpro');?></small>
				</td>
			</tr>
			
			
			<tr class="gateway gateway_cnp" <?php if(!empty($gateway) && $gateway != "cnp") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="cnp_tax"><?php _e('Sales Tax', 'pmpro');?> <small>(<?php _e('optional', 'pmpro');?>)</small></label>
				</th>
				<td>
					<textarea type="text" id="cnp_tax_state_rate" name="cnp_tax_state_rate"cols="80" rows="3"><?php echo esc_attr($cnp_tax_state_rate)?></textarea>
					&nbsp;
					<p><small><?php _e('Enter the state and tax values. Enter values as "CountryCode-StateCode-TaxRate" Separated with comma. eg:US-VA-7,BD-C-9 which means United States(US) - Country, Virginia(VA) has 7% tax - State For more help on country and state codes <a href="http://en.wikipedia.org/wiki/ISO_3166-2" target="_blank">click</a> here', 'pmpro');?></small></p>
				</td>
			</tr>
			
			<tr class="gateway gateway_ gateway_stripe gateway_authorizenet gateway_paypal gateway_paypalexpress gateway_check gateway_paypalstandard gateway_payflowpro gateway_braintree gateway_twocheckout gateway_cybersource" <?php if(!empty($gateway) && $gateway != "stripe" && $gateway != "authorizenet" && $gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "check" && $gateway != "paypalstandard" && $gateway != "payflowpro" && $gateway != "braintree" && $gateway != "twocheckout" && $gateway != "cybersource") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label for="tax"><?php _e('Sales Tax', 'pmpro');?> <small>(<?php _e('optional', 'pmpro');?>)</small></label>
				</th>
				<td>
					<?php _e('Tax State', 'pmpro');?>:
					<input type="text" id="tax_state" name="tax_state" size="4" value="<?php echo esc_attr($tax_state)?>" /> <small>(<?php _e('abbreviation, e.g. "PA"', 'pmpro');?>)</small>
					&nbsp; Tax Rate:
					<input type="text" id="tax_rate" name="tax_rate" size="10" value="<?php echo esc_attr($tax_rate)?>" /> <small>(<?php _e('decimal, e.g. "0.06"', 'pmpro');?>)</small>
					<p><small><?php _e('US only. If values are given, tax will be applied for any members ordering from the selected state.<br />For non-US or more complex tax rules, use the <a target="_blank" href="http://www.paidmembershipspro.com/2013/10/non-us-taxes-paid-memberships-pro/">pmpro_tax filter</a>.', 'pmpro');?></small></p>
				</td>
			</tr>
			<tr class="gateway gateway_ gateway_stripe gateway_paypalexpress gateway_check gateway_paypalstandard gateway_braintree gateway_twocheckout gateway_cybersource gateway_payflowpro gateway_authorizenet gateway_paypal gateway_cnp">
				<th scope="row" valign="top">
					<label for="use_ssl"><?php _e('Force SSL', 'pmpro');?>:</label>
				</th>
				<td>
					<select id="use_ssl" name="use_ssl">
						<option value="0" <?php if(empty($use_ssl)) { ?>selected="selected"<?php } ?>><?php _e('No', 'pmpro');?></option>
						<option value="1" <?php if(!empty($use_ssl) && $use_ssl == 1) { ?>selected="selected"<?php } ?>><?php _e('Yes', 'pmpro');?></option>	
						<option value="2" <?php if(!empty($use_ssl) && $use_ssl == 2) { ?>selected="selected"<?php } ?>><?php _e('Yes (with JavaScript redirects)', 'pmpro');?></option>							
					</select>
					<small>Recommended: Yes. Try the JavaScript redirects setting if you are having issues with infinite redirect loops.</small>
				</td>
			</tr>				
			<tr>
				<th scope="row" valign="top">
					<label for="sslseal"><?php _e('SSL Seal Code', 'pmpro');?>:</label>
				</th>
				<td>
					<textarea id="sslseal" name="sslseal" rows="3" cols="80"><?php echo stripslashes(esc_textarea($sslseal))?></textarea>
					<br /><small>Your <strong><a target="_blank" href="http://www.paidmembershipspro.com/documentation/initial-plugin-setup/ssl/">SSL Certificate</a></strong> must be installed by your web host. Your <strong>SSL Seal</strong> will be a short HTML or JavaScript snippet that can be pasted here.</small>
				</td>
		   </tr>		   
		   <tr>
				<th scope="row" valign="top">
					<label for="nuclear_HTTPS"><?php _e('HTTPS Nuclear Option', 'pmpro');?>:</label>
				</th>
				<td>
					<input type="checkbox" id="nuclear_HTTPS" name="nuclear_HTTPS" value="1" <?php if(!empty($nuclear_HTTPS)) { ?>checked="checked"<?php } ?> /> <?php _e('Use the "Nuclear Option" to use secure (HTTPS) URLs on your secure pages. Check this if you are using SSL and have warnings on your checkout pages.', 'pmpro');?>
				</td>
		   </tr>
		   <tr class="gateway gateway_paypal gateway_paypalexpress gateway_paypalstandard gateway_payflowpro" <?php if($gateway != "paypal" && $gateway != "paypalexpress" && $gateway != "paypalstandard" && $gateway != "payflowpro") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label><?php _e('IPN Handler URL', 'pmpro');?>:</label>
				</th>
				<td>
					<p><?php _e('To fully integrate with PayPal, be sure to set your IPN Handler URL to ', 'pmpro');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=ipnhandler";?></pre></p>
				</td>
			</tr>
		   <tr class="gateway gateway_twocheckout" <?php if($gateway != "twocheckout") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label><?php _e('TwoCheckout INS URL', 'pmpro');?>:</label>
				</th>
				<td>
					<p><?php _e('To fully integrate with 2Checkout, be sure to set your 2Checkout INS URL ', 'pmpro');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=twocheckout-ins";?></pre></p>
				</td>
			</tr>
			<tr class="gateway gateway_authorizenet" <?php if($gateway != "authorizenet") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label><?php _e('Silent Post URL', 'pmpro');?>:</label>
				</th>
				<td>
					<p><?php _e('To fully integrate with Authorize.net, be sure to set your Silent Post URL to', 'pmpro');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=authnet_silent_post";?></pre></p>
				</td>
			</tr>
			<tr class="gateway gateway_stripe" <?php if($gateway != "stripe") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label><?php _e('Web Hook URL', 'pmpro');?>:</label>
				</th>
				<td>
					<p><?php _e('To fully integrate with Stripe, be sure to set your Web Hook URL to', 'pmpro');?> <pre><?php echo admin_url("admin-ajax.php") . "?action=stripe_webhook";?></pre></p>
				</td>
			</tr>
			<tr class="gateway gateway_braintree" <?php if($gateway != "braintree") { ?>style="display: none;"<?php } ?>>
				<th scope="row" valign="top">
					<label><?php _e('Web Hook URL', 'pmpro');?>:</label>
				</th>
				<td>
					<p>
						<?php _e('To fully integrate with Braintree, be sure to set your Web Hook URL to', 'pmpro');?> 
						<pre><?php 
							//echo admin_url("admin-ajax.php") . "?action=braintree_webhook";
							echo PMPRO_URL . "/services/braintree-webhook.php";
						?></pre>.
					</p>
				</td>
			</tr>
		</tbody>
		</table>            
		<p class="submit">            
			<input name="savesettings" type="submit" class="button-primary" value="<?php _e('Save Settings', 'pmpro');?>" /> 		                			
		</p>             
	</form>
		
<?php
	require_once(dirname(__FILE__) . "/admin_footer.php");	
?>
