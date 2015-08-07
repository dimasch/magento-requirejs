<?php
/**
 * Mtaube (https://github.com/mtaube)
 *
 * @category    Mtaube
 * @package     Mtaube_Requirejs
 * @copyright   Copyright (c) 2015 Matt Taube
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 */

class Mtaube_Requirejs_Model_Cache
{
    /**
     * Cache tagsfor all module sets.
     *
     * @const string
     */
    const CACHE_TAG = 'requirejs';

    /**
     * Cache tag as array.
     *
     * @var array
     */
    protected $_cacheTags = array(self::CACHE_TAG);

    /**
     * Clean the requirejs cache of the built files.
     *
     * @return void
     */
    public function clean()
    {
        Mage::app()->cleanCache($this->_cacheTags);
    }

    /**
     * Check the cache for the identifying hash of the module set.
     *
     * @param array $moduleNames
     * @return bool
     */
    public function isCached($moduleSetId)
    {
        return $this->load($moduleSetId) !== false;
    }

    /**
     * Use the identifying hash to load the module set to the cache.
     *
     * @param array $moduleNames
     * @return bool
     */
    public function load($moduleSetId)
    {
        return Mage::app()->loadCache($moduleSetId);
    }

    /**
     * Use the identifying hash to save the module set to the cache.
     *
     * @param array $moduleNames
     * @return void
     */
    public function save($moduleSetId)
    {
        Mage::app()->saveCache($moduleSetId, $moduleSetId, $this->_cacheTags);
    }
}