<?php
/**
 * Mtaube (https://github.com/mtaube)
 *
 * @category    Mtaube
 * @package     Mtaube_Requirejs
 * @copyright   Copyright (c) 2015 Matt Taube
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 */

class Mtaube_Requirejs_Block_Scripts extends Mage_Page_Block_Html_Head
{
    /**
     * Modules to require()
     *
     * @var array
     */
    protected $_moduleNames = array();

    /**
     * Get URL of the built common module.
     *
     * @return string
     */
    public function getBuiltCommonJsUrl()
    {
        return Mage::helper('requirejs')->getBuiltModuleSetJsUrl(array('common'));
    }

    /**
     * Get URL of the built modules.
     *
     * @return string
     */
    public function getBuiltModuleSetJsUrl()
    {
        return Mage::helper('requirejs')->getBuiltModuleSetJsUrl($this->getModuleNames());
    }

    /**
     * Get the array of module names.
     *
     * @param string $moduleName
     * @return array
     */
    public function getModuleNames()
    {
        return $this->_moduleNames;
    }

    /**
     * Add a module.
     *
     * @param string $name
     * @return void
     */
    public function addModule($name)
    {
        $this->_moduleNames[] = $name;
    }

    /**
     * Remove a module.
     *
     * @param string $moduleName
     * @return void
     */
    public function removeModule($name)
    {
        unset($this->_moduleNames[$name]);
    }
}