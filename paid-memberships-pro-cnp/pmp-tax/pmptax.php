<?php
/*
Plugin Name: PMPro Customizations
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for PMPro
Version: 1.0
Author: Click & Pledge
Author URI: http://manual.clickandpledge.com/
*/
/*
Tax solution for more than one states other than US.
*/
//add tax info to cost text. this is enabled if the danish checkbox is checked.
function customtax_pmpro_tax($tax, $values, $order)
{
$rate = $_REQUEST['cnp_tax']/100;
$tax = round((float)$values[price] * $rate, 2);	
return $tax;
}
function customtax_pmpro_level_cost_text($cost, $level)
{
	$str = '';
	$str_tax = '';
	$cnp_tax_state_rate = pmpro_getOption("cnp_tax_state_rate");
	if($cnp_tax_state_rate)
	$cnp_tax_state_rate = explode(',',$cnp_tax_state_rate);
	foreach($cnp_tax_state_rate as $sr) 
	{
		$sr_parts = explode('-', $sr); //Assume 0 - Country, 1 - State, 2 - Percentage
		if(isset($sr_parts[1])) {
		$str .= $sr_parts[1].', ';
		}
		if(isset($sr_parts[2])) {
		$str_tax .= $sr_parts[2].'%, ';
		}
	}
if($str) {
	$cost .= "<br>Customers in ".substr($str, 0, -2)." will be charged ".substr($str_tax, 0, -2)." tax respectively.";
}
return $cost;
}
add_filter("pmpro_level_cost_text", "customtax_pmpro_level_cost_text", 10, 2);
//add BC checkbox to the checkout page
function customtax_pmpro_checkout_boxes()
{

}
add_action("pmpro_checkout_boxes", "customtax_pmpro_checkout_boxes");
//update tax calculation if buyer is in selected states list
function customtax_region_tax_check()
{
	
	$_REQUEST['cnp_tax'] = 0;
	$cnp_tax_state_rate = pmpro_getOption("cnp_tax_state_rate");
	if($cnp_tax_state_rate)
	$cnp_tax_state_rate = explode(',',$cnp_tax_state_rate);
	//print_r($cnp_tax_state_rate);
	foreach($cnp_tax_state_rate as $sr) 
	{
		$sr_parts = explode('-', $sr); //Assume 0 - Country, 1 - State, 2 - Percentage
		//print_r($sr_parts);
		if(!empty($_REQUEST['bstate']) && !empty($_REQUEST['bcountry']))
		{
			if(isset($sr_parts[0]) && isset($sr_parts[1])) 
			{
				if(trim(strtolower($_REQUEST['bcountry'])) == trim(strtolower($sr_parts[0])) && trim(strtolower($_REQUEST['bstate'])) == trim(strtolower($sr_parts[1])))
				{
					$_REQUEST['cnp_tax'] = isset($sr_parts[2]) ? $sr_parts[2] : 0;
					
				}
			}
		}
	}
	
	add_filter("pmpro_tax", "customtax_pmpro_tax", 10, 3);
}
add_action("init", "customtax_region_tax_check");
//remove the taxregion session var on checkout
function customtax_pmpro_after_checkout()
{
if(isset($_SESSION['taxregion']))
unset($_SESSION['taxregion']);
}
add_action("pmpro_after_checkout", "customtax_pmpro_after_checkout");
?>