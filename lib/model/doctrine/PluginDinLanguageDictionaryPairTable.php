<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Plugin class for performing query and update operations for DinLanguageDictionaryPair model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageDictionaryPairTable extends dinDoctrineTable
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


    /**
     * Get pairs sources by dictionary identifier
     * 
     * @param   integer $dictionaryId   Dictionary identifier
     * @return  array   Pairs sources
     */
    public function getSourcesByDictionary( $dictionaryId )
    {

        $items = Doctrine_Query::create()->select( 'p.source' )
                ->from( 'DinLanguageDictionaryPair p' )
                ->where( 'p.dictionary_id = ?', $dictionaryId )
                ->execute( array(), Doctrine::HYDRATE_NONE );

        $result = array();
        foreach ( $items as $item )
        {
            $result[] = $item[0];
        }
        return $result;

    } // PluginDinLanguageDictionaryPairTable::getSourcesByDictionary()


    /**
     * Get pair by source
     * 
     * @param   string  $source         Pair source
     * @param   integer $dictionaryId   Dictionary identifier
     * @return  object  A dinLanguageDictionaryPair object
     */
    public function retrieveBySource( $source, $dictionaryId )
    {

        return $this->createQuery( 'p' )->where( 'p.source = ?', $source )
            ->andWhere( 'p.dictionary_id = ?', $dictionaryId )->fetchOne();

    } // PluginDinLanguageDictionaryPairTable::retrieveBySource()


    /**
     * Get pairs object's by dictionary identifier
     * 
     * @param   integer $dictionaryId   Dictionary identifier
     * @return  array   A array of dinLanguageDictionaryPair object's
     */
    public function getPairsByDictionary( $dictionaryId )
    {

        return Doctrine_Query::create()->from( 'DinLanguageDictionaryPair p' )
            ->leftJoin( 'p.Translation t' )
            ->where( 'p.dictionary_id = ?', $dictionaryId )->execute();

    } // PluginDinLanguageDictionaryPairTable::getPairsByDictionary()


    /**
     * Remove cache (with cached i18n app dicts)
     * 
     * @param   array   $params Object params
     * @return  void
     */
    public function removeCache( array $params )
    {

        if ( $params['dictionary_id'] )
        {
            if ( $dict = Doctrine::getTable( 'DinLanguageDictionary' )->find( $params['dictionary_id'] ) )
            {
                $driver = new sfFileCache( array(
                    'lifetime' => 157680000,
                    'cache_dir' => sfConfig::get( 'sf_cache_dir' ) . '/' . $dict->getApplication()
                        . '/*/i18n/' . $dict->getName()
                ) );
                $driver->removePattern( '*' );
            }
        }
        parent::removeCache( $params );

    } // PluginDinLanguageDictionaryPairTable::removeCache()

} // PluginDinLanguageDictionaryPairTable

//EOF