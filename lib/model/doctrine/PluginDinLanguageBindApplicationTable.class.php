<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) 2010 IF Solutions
 * All rights reserved.
 */

/**
 * Plugin class for performing query and update operations for DinLanguageBindApplication model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageBindApplicationTable extends Doctrine_Table
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