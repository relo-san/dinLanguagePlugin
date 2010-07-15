<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Plugin class for performing query and update operations for DinLanguageBindGroup model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageBindGroupTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinLanguageBindGroupTable
     * 
     * @return  PluginDinLanguageBindGroupTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinLanguageBindGroup' );

    } // PluginDinLanguageBindGroupTable::getInstance()

} // PluginDinLanguageBindGroupTable

//EOF