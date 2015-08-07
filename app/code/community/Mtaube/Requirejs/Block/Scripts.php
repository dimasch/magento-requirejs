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
     * Helper object.
     *
     * @var Mtaube_Requirejs_Helper_Data
     */
    protected $_helper;

    /**
     * Modules to require().
     *
     * @var array
     */
    protected $_moduleNames = array();

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_helper = Mage::helper('requirejs');
    }

    /**
     * Get URL of the built common module.
     *
     * @return string
     */
    public function getBuiltCommonJsUrl()
    {
        $moduleNamesIncluded = array($this->_helper->getCommonModuleName());

        return $this->_helper->getBuiltModuleSetJsUrl($moduleNamesIncluded);
    }

    /**
     * Get URL of the built modules.
     *
     * @return string
     */
    public function getBuiltModuleSetJsUrl()
    {
        $moduleNamesExcluded = array($this->_helper->getCommonModuleName());

        return $this->_helper->getBuiltModuleSetJsUrl($this->getModuleNames(), $moduleNamesExcluded);
    }

    /**
     * Get URL of the built common module.
     *
     * @return string
     */
    public function isBuildEnabled()
    {
        return $this->_helper->isBuildEnabled();
    }

    /**
     * Get the name of the common module, which includes the config.
     *
     * @return bool
     */
    public function getCommonModuleBaseDir()
    {
        return $this->_helper->getCommonModuleBaseDir();
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