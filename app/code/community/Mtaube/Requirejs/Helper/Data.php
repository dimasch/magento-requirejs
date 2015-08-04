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
    const CACHE_TAG = 'requirejs';

    /**
     * Get the URL of the built module set. If the built module set is not cached, build it first.
     *
     * @param array $moduleNames
     * @return string
     */
    public function getBuiltModuleSetJsUrl($moduleNames)
    {
        if (!$this->_isModuleSetCached($moduleNames)) {
            $this->_buildModuleSet($moduleNames);
        }

        return $this->_getBuiltModuleSetJsBaseUrl() . DS . $this->_getBuiltModuleSetJsFileName($moduleNames);
    }

    /**
     * Build the module set file.
     *
     * @param array $moduleNames
     * @return void
     */
    protected function _buildModuleSet($moduleNames)
    {
        // TODO Add settings to change location of mainConfigFile and modules
        $options = array(
            'mainConfigFile' => 'skin/frontend/base/default/js/common.js',
            'out' => $this->_getBuiltModuleSetJsBaseDir() . DS . $this->_getBuiltModuleSetJsFileName($moduleNames),
            'include' => implode(',', $moduleNames),
        );
        if (!in_array('common', $moduleNames)) $options['exclude'] = 'common';

        $optionsJoined = implode(' ', array_map(function ($v, $k) { return $k . '=' . $v; }, $options, array_keys($options)));

        shell_exec('r.js -o ' . $optionsJoined);

        if ($this->_isCacheEnabled()) {
            $moduleSetHash = $this->_getModuleSetHash($moduleNames);

            $this->_saveCache($moduleSetHash, $moduleSetHash, array(self::CACHE_TAG));
        }
    }

    /**
     * Get the base directory where built module sets are saved.
     *
     * @return string
     */
    protected function _getBuiltModuleSetJsBaseDir()
    {
        return Mage::getBaseDir('media') . DS . 'js' . DS . 'requirejs';
    }

    /**
     * Get the base URL of the built module sets.
     *
     * @return string
     */
    protected function _getBuiltModuleSetJsBaseUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'js' . DS . 'requirejs';
    }

    /**
     * Get the file name of the built module set.
     *
     * @param array $moduleNames
     * @return string
     */
    protected function _getBuiltModuleSetJsFileName($moduleNames)
    {
        return $this->_getModuleSetHash($moduleNames) . '.js';
    }

    /**
     * Get the identifying hash of the module set.
     *
     * @param array $moduleNames
     * @return string
     */
    protected function _getModuleSetHash($moduleNames)
    {
        return md5(implode($moduleNames));
    }

    /**
     * Check the cache for the identifying hash of the module set.
     *
     * @param array $moduleNames
     * @return bool
     */
    protected function _isModuleSetCached($moduleNames)
    {
        if ($this->_isCacheEnabled()) {
            $moduleSetHash = $this->_getModuleSetHash($moduleNames);

            return $this->_loadCache($moduleSetHash) !== false;
        }
        else {
            return false;
        }
    }

    /**
     * Check if chaching is enabled.
     *
     * @return bool
     */
    protected function _isCacheEnabled()
    {
        // TODO Add logic to disable / enable caching
        return true;
    }

    /**
     * Clean the requirejs cache of the built files.
     *
     * @return bool
     */
    public function cleanCache()
    {
        $this->_cleanCache(array(self::CACHE_TAG));
    }
}