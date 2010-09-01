<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) 2010 IF Solutions
 * All rights reserved.
 */

/**
 * Plugin class for performing query and update operations for DinLanguageDictionaryPair model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageDictionaryPairTable extends Doctrine_Table
{

    /**
     * Returns an instance of PluginDinLanguageDictionaryPairTable
     * 
     * @return  PluginDinLanguageDictionaryPairTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinLanguageDictionaryPair' );

    } // PluginDinLanguageDictionaryPairTable::getInstance()

} // PluginDinLanguageDictionaryPairTable

//EOF