<?php
/**
 * Mtaube (https://github.com/mtaube)
 *
 * @category    Mtaube
 * @package     Mtaube_Requirejs
 * @copyright   Copyright (c) 2015 Matt Taube
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 */

class Mtaube_Requirejs_Model_Observer
{
    /**
     * Clean requrejs cache when the default Magento media cache is cleaned.
     *
     * @return string
     */
    public function cleanBuiltModuleSetJs(Varien_Event_Observer $observer)
    {
        Mage::getModel('requirejs/cache')->clean();
    }
}