<?php
/**
 * Dimension.Grid
 * @author	Jimmie Lin <jimmie.lin@gmail.com>
 * @since	 1.0.674.0
 * @license   Dimension.Grid Shared-Source Components License
 * @copyright (c) 2010 Jimmie Lin
 */

require_once(VENDORS."phpcaptcha".DS."php-captcha.inc.php");

class CaptchaComponent extends Object { 
	var $controller; 
  
	function startup(&$controller) { 
		$this->controller = &$controller; 
	} 

	function image() { 
		$imagesPath = realpath(VENDORS . 'phpcaptcha').DS.'fonts'.DS; 

		$aFonts = array( 
			$imagesPath.'VeraBd.ttf', 
			$imagesPath.'VeraIt.ttf', 
			$imagesPath.'Vera.ttf' 
		); 
		 
		$oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60); 
		$oVisualCaptcha->UseColour(false); 
		$oVisualCaptcha->SetOwnerText("Click to refresh");
		$oVisualCaptcha->CaseInsensitive(true);
		$oVisualCaptcha->SetCharSet("A-Z");
		$oVisualCaptcha->SetNumChars(6);
		$oVisualCaptcha->SetFileType("png");
		$oVisualCaptcha->SetBackgroundImages(
			array(
				$imagesPath."images/ws08.jpg",
				$imagesPath."images/ws08_2.jpg",
				$imagesPath."images/ws08_3.jpg",
				$imagesPath."images/grass.jpg",
				$imagesPath."images/grass2.jpg",
				$imagesPath."images/grass3.jpg",
				$imagesPath."images/grass4.jpg",
				$imagesPath."images/grass5.jpg",
				$imagesPath."images/water.jpg",
				$imagesPath."images/water2.jpg",
				$imagesPath."images/water3.jpg",
				$imagesPath."images/clouds.jpg"
			)
		);
		$oVisualCaptcha->Create();
	}

	function audio() { 
		$oAudioCaptcha = new AudioPhpCaptcha('/usr/bin/flite', '/tmp/'); 
		$oAudioCaptcha->Create(); 
	}
	 
	function check($userCode, $caseInsensitive = true) { 
		if ($caseInsensitive) { 
			$userCode = strtoupper($userCode); 
		} 
		 
		if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && $userCode == $_SESSION[CAPTCHA_SESSION_ID]) { 
			// clear to prevent re-use
			unset($_SESSION[CAPTCHA_SESSION_ID]); 
			 
			return true; 
		} 
		else return false; 
		 
	} 
}
