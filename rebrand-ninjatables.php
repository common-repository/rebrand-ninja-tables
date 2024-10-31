<?php
/**
 * Plugin Name: 	Rebrand Ninja Tables
 * Plugin URI: 	    https://rebrandpress.com/rebrand-ninjatables/
 * Description: 	Ninja Tables is a code-free WordPress table builder plugin to create, edit, maintain, and customize tables. Rebrand Ninja Tables allows you to rename the plugin and change the description on both the navigation menu and the site’s plugin page. You can also replace the developer’s link and add a custom one to your company, while changing the colors and logo to match your brand.
 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_NinjaTables_Pro') ) {
	
	class Rebrand_NinjaTables_Pro {
		
		public function bzntp_load()
		{
			global $bzntp_load;

			if ( !isset($bzntp_load) )  
			{
			  require_once(__DIR__ . '/ntp-settings.php');
			  $PluginNTP = new BZ_NTP\BZRebrandNinjaTableSettings;
			  $PluginNTP->init();
			}
			return $bzntp_load;
		}
		
	}
}
$PluginRebrandNinjaTables = new Rebrand_NinjaTables_Pro;
$PluginRebrandNinjaTables->bzntp_load();
