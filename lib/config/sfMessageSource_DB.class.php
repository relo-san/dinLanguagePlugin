<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Manage stored in DB translations for Doctrine
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.config
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class sfMessageSource_DB extends sfMessageSource
{

    /**
     * Get source identifier (terminator)
     * 
     * @return  string  md5 key
     */
    public function getId()
    {

        return 'f9bf73b42893cfc580c79d2cc79bb525';

    } // sfMessageSource_DB::getId()


    /**
     * Load translations
     * 
     * @param   string  $catalogue  Dictionary name [optional]
     * @return  boolean True
     */
    public function load( $catalogue = 'messages' )
    {

        $loadData = true;
        if ( $this->cache )
        {
            $data = unserialize( $this->cache->get( $catalogue . ':' . $this->culture ) );
            if ( is_array( $data ) )
            {
                $this->messages[''] = $data;
                $loadData = false;
            }
            unset( $data );
        }

        if ( $loadData )
        {
            $data = &$this->loadData( $catalogue );
            if ( is_array( $data ) )
            {
                $this->messages[''] = $data;
                if ( $this->cache )
                {
                    $this->cache->set( $catalogue . ':' . $this->culture, serialize( $data ) );
                }
            }
            unset( $data );
        }

        return true;

    } // sfMessageSource_DB::load()


    /**
     * Load translated pairs
     * 
     * @param   string  $catalogue  Dictionary name
     * @return  array   Translated pairs
     */
    public function &loadData( $catalogue )
    {

        return Doctrine::getTable( 'DinLanguageDictionary' )->getDictionaryPairsForI18n(
            $catalogue, $this->culture
        );

    } // sfMessageSource_DB::loadData()


    /**
     * Saves the list of missed keys in dictionary (terminator)
     * 
     * @param   string  $catalogue  Dictionary name [optional]
     * @return  boolean Result
     */
    public function save( $catalogue = 'messages' )
    {

        return true;

    } // sfMessageSource_DB::save()


    /**
     * Add key for translation pair
     * 
     * @param   string  $key        Key for translation pair
     * @param   string  $catalogue  Dictionary name [optional]
     * @return  boolean Result
     */
    public function addKey( $key, $catalogue = 'messages' )
    {

        if ( isset( $this->untranslated[$catalogue][$key] ) )
        {
            return false;
        }

        if ( !$cat = Doctrine::getTable( 'DinLanguageDictionary' )->retrieveByName( $catalogue ) )
        {
            $cat = new DinLanguageDictionary;
            $cat->setApplication( sfContext::getInstance()->getConfiguration()->getApplication() );
            $cat->setName( $catalogue );
            $cat->save();
            if ( $cat->state() != Doctrine_Record::STATE_CLEAN )
            {
                return false;
            }
        }

        if ( !$existPair = Doctrine::getTable( 'DinLanguageDictionaryPair' )->retrieveBySource( $key, $cat->getId() ) )
        {
            $newPair = new DinLanguageDictionaryPair;
            $newPair->setDictionaryId( $cat->getId() );
            $newPair->setSource( $key );
            $newPair->setValue( $key );
            $newPair->setIsPublic( true );
            $newPair->save();
            if ( $newPair->state() == Doctrine_Record::STATE_CLEAN )
            {
                $this->cache->remove( $catalogue . ':' . $this->culture );
                $this->untranslated[$catalogue][$key] = true;
                return true;
            }
            return false;
        }

        return false;

    } // sfMessageSource_DB::addKey()


    /**
     * Delete key pair from specified catalogue (terminator)
     * 
     * @param   string  $key        Key for translation pair
     * @param   string  $catalogue  Dictionary name [optional]
     * @return  boolean Action result
     */
    public function delete( $key, $catalogue = 'messages' )
    {

        return true;

    } // sfMessageSource_DB::delete()


    /**
     * Update translation pair (terminator)
     * 
     * @param   string  $key            Key for translation pair
     * @param   string  $translation    Translated value for pair
     * @param   string  $comment        Description for pair
     * @param   string  $catalogue      Dictionary name [optional]
     * @return  boolean Action result
     */
    public function update( $key, $translation, $comment, $catalogue = 'messages' )
    {

        return true;

    } // sfMessageSource_DB::update()


    /**
     * Returns a list of catalogue as key and all it variants as value.
     * 
     * @return  array   List of catalogues
     */
    public function catalogues()
    {

        $cats = Doctrine::getTable( 'DinLanguageDictionary' )->getDictionariesForI18n();

        $out = array();
        foreach ( $cats as $cat )
        {
            $out[] = $cat['name'];
        }

        return $out;

    } // sfMessageSource_DB::catalogues()

} // sfMessageSource_DB

//EOF