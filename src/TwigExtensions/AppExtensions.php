<?php

namespace TwigExtensions;

/**
 * Description of AppExtensions
 *
 * @author cevantime
 */
class AppExtensions extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_Function('dtf', [$this, 'dateTimeFormat'])
        ];
    }
    
    public function dateTimeFormat($format, $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time);
    }
}
