<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Plugin class for performing query and update operations for DinLanguage model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinLanguageTable
     * 
     * @return  PluginDinLanguageTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinLanguage' );

    } // PluginDinLanguageTable::getInstance()

} // PluginDinLanguageTable

//EOF