<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

/**
 * Application Name
 */
$config["Appl"]["Name"] = "Dimension.Grid";

/**
 * Application Version
 */
$config["Appl"]["Version"] = "";

	// Configure the Application Variables here.
	$config["Appl"]["MajorVersion"] = 1;
	$config["Appl"]["MinorVersion"] = 0;
	$config["Appl"]["BuildNumber"] = 976;
	$config["Appl"]["Revision"] = 13828;

	$config["Appl"]["BuildLab"] = "m10_beta0_escrow";

	$config["Appl"]["Debug"] = (Configure::read("debug") == 0 ? false : true);

$config["Appl"]["Version"] = $config["Appl"]["MajorVersion"].".".$config["Appl"]["MinorVersion"].".".$config["Appl"]["BuildNumber"].".".$config["Appl"]["Revision"].".".$config["Appl"]["BuildLab"]
							." ".($config["Appl"]["Debug"] ? "(dbg)" : "(fre)");


/**
 * Politics: Election System Config
 */

// Party President Election Day (default: 15)
$config["Appl"]["PP_Election_Day"] = 23;

// Country President Election Day (default: 20)
$config["Appl"]["CP_Election_Day"] = 20;

// Congressional Election Day (default: 25)
$config["Appl"]["CS_Election_Day"] = 25;