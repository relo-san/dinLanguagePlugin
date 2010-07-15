<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Plugin class for performing query and update operations for DinLanguageBindApplication model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageBindApplicationTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinLanguageBindApplicationTable
     * 
     * @return  PluginDinLanguageBindApplicationTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinLanguageBindApplication' );

    } // PluginDinLanguageBindApplicationTable::getInstance()

} // PluginDinLanguageBindApplicationTable

//EOF