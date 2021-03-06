<?php
/**
 * Mtaube (https://github.com/mtaube)
 *
 * @category    Mtaube
 * @package     Mtaube_Requirejs
 * @copyright   Copyright (c) 2015 Matt Taube
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 */

class Mtaube_Requirejs_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Build the module set file.
     *
     * @param array $moduleNames
     * @param array $moduleNamesExcluded
     * @return void
     */
    protected function _buildModuleSet($moduleNames, array $moduleNamesExcluded = array())
    {
        $id = $this->_getModuleSetId($moduleNames);
        $options = array(
            'mainConfigFile' => $this->_getMainConfigFile(),
            'out' => $this->_getBuiltModuleSetJsFile($moduleNames),
            'include' => implode(',', $moduleNames),
            'optimize' => $this->_getOptimizer(),
            'exclude' => implode(',', $moduleNamesExcluded)
        );

        $optionsJoined = implode(' ', array_map(function ($v, $k) { return $k . '=' . $v; }, $options, array_keys($options)));

        $output = shell_exec('r.js -o ' . $optionsJoined);

        if ($output) Mage::getModel('requirejs/cache')->save($id);
        else { Mage::throwException('The r.js command failed, please verify installation or disable RequireJS build.'); }
    }

    /**
     * Get the dist directory where built module sets are saved.
     *
     * @return string
     */
    protected function _getDistDir()
    {
        $commonModuleBaseDir = $this->getCommonModuleBaseDir();
        return $commonModuleBaseDir . DS . 'dist';
    }

    /**
     * Get the base directory where built module sets are saved.
     *
     * @return string
     */
    protected function _getBuiltModuleSetJsBaseDir()
    {
        return Mage::getDesign()->getSkinBaseDir() . DS . $this->_getDistDir();
    }

    /**
     * Get the base URL of the built module sets.
     *
     * @return string
     */
    protected function _getBuiltModuleSetJsBaseUrl()
    {
        return Mage::getDesign()->getSkinUrl() . $this->_getDistDir();
    }

    /**
     * Get absolute path to the built module set file.
     *
     * @return string
     */
    protected function _getBuiltModuleSetJsFile($moduleNames)
    {
        return $this->_getBuiltModuleSetJsBaseDir() . DS . $this->_getBuiltModuleSetJsFileName($moduleNames);
    }

    /**
     * Get the file name of the built module set.
     *
     * @param array $moduleNames
     * @return string
     */
    protected function _getBuiltModuleSetJsFileName($moduleNames)
    {
        return $this->_getModuleSetId($moduleNames) . '.js';
    }

    /**
     * Get absolute path to the common module file using the theme fallback pattern.
     *
     * @return string
     */
    protected function _getMainConfigFile()
    {
        $commonModuleBaseDir = $this->getCommonModuleBaseDir();
        $commonModuleName = $this->getCommonModuleName();

        return Mage::getDesign()->getFilename($commonModuleBaseDir . DS . $commonModuleName . '.js', array('_type'=>'skin'));
    }

    /**
     * Get the identifying hash of the module set.
     *
     * @param array $moduleNames
     * @return string
     */
    protected function _getModuleSetId($moduleNames)
    {
        return trim($moduleNames[0]);
    }

    /**
     * Check the cache for the identifying hash of the module set.
     * If the identifying hash is found, we assume the built module set file exists.
     *
     * @param array $moduleNames
     * @return bool
     */
    protected function _isModuleSetCached($moduleNames)
    {
        $moduleSetId = $this->_getModuleSetId($moduleNames);

        return Mage::getModel('requirejs/cache')->isCached($moduleSetId);
    }

    /**
     * Get the optimze setting.
     *
     * @return string
     */
    protected function _getOptimizer()
    {
        $processor = Mage::getStoreConfig('requirejs/settings/uglify_processor');
        return Mage::getStoreConfig('requirejs/settings/uglify') ? $processor : 'none';
    }

    /**
     * Get the URL of the built module set. If the built module set is not cached, build it first.
     *
     * @param array $moduleNames
     * @param array $moduleNamesExcluded
     * @return string
     */
    public function getBuiltModuleSetJsUrl($moduleNames, array $moduleNamesExcluded = array())
    {
        if (!$this->_isModuleSetCached($moduleNames)) {
            $this->_buildModuleSet($moduleNames, $moduleNamesExcluded);
        }

        return $this->_getBuiltModuleSetJsBaseUrl() . DS . $this->_getBuiltModuleSetJsFileName($moduleNames);
    }

    /**
     * Get the base directory of the common module relative to the skin base dir.
     *
     * @return string
     */
    public function getCommonModuleBaseDir()
    {
        return 'js' . DS . Mage::getStoreConfig('requirejs/settings/common_module_base_dir');
    }

    /**
     * Get the name of the common module, which includes the config.
     *
     * @return string
     */
    public function getCommonModuleName()
    {
        return Mage::getStoreConfig('requirejs/settings/common_module_name');
    }

    /**
     * Check whether r.js is enabled.
     *
     * @return bool
     */
    public function isBuildEnabled()
    {
        return Mage::getStoreConfig('requirejs/settings/build');
    }
}
