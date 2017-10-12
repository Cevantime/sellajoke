<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of AssetTrait
 *
 * @author cevantime
 */
trait AssetTrait
{
    public function asset($url, $packageName = null)
    {
        return $this['assets.packages']->getUrl($url, $packageName);
    }
}
