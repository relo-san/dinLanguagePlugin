<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Plugin class for performing query and update operations for DinLanguageGroup model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageGroupTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinLanguageGroupTable
     * 
     * @return  PluginDinLanguageGroupTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinLanguageGroup' );

    } // PluginDinLanguageGroupTable::getInstance()

} // PluginDinLanguageGroupTable

//EOF