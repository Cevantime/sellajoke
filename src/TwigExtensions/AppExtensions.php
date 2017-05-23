<?php

namespace TwigExtensions;

/**
 * Description of AppExtensions
 *
 * @author cevantime
 */
class AppExtensions extends \Twig_Extension{
	
	public function getFunctions() {
		return array(
			new \Twig_Function('dtf', array($this, 'dateTimeFormat'))
		);
	}
	
	public function dateTimeFormat($format, $time = null) {
		if(!$time) {
			$time = time();
		}
		return date($format, $time);
	}
	
}
