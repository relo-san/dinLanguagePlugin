<?php

/*
 * This file is part of the dinLanguagePlugin package.
 * (c) DineCat, 2010 http://dinecat.com/
 * 
 * For the full copyright and license information, please view the LICENSE file,
 * that was distributed with this package, or see http://www.dinecat.com/din/license.html
 */

/**
 * Plugin class for performing query and update operations for DinLanguageDictionary model table
 * 
 * @package     dinLanguagePlugin
 * @subpackage  lib.model.doctrine
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 */
class PluginDinLanguageDictionaryTable extends dinDoctrineTable
{

    /**
     * Returns an instance of PluginDinLanguageDictionaryTable
     * 
     * @return  PluginDinLanguageDictionaryTable
     */
    public static function getInstance()
    {

        return Doctrine_Core::getTable( 'PluginDinLanguageDictionary' );

    } // PluginDinLanguageDictionaryTable::getInstance()


    /**
     * Get pairs by dictionary name
     * 
     * @param   string  $dictionary Dictionary name
     * @param   string  $culture    Culture identifier [optional]
     * @return  array   Array of dictionary pairs arrays
     */
    public function &getDictionaryPairsForI18n( $dictionary, $culture = null )
    {

        $application = sfContext::getInstance()->getConfiguration()->getApplication();
        if ( is_null( $culture ) )
        {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        $query = Doctrine_Query::create()->select( 'p.id, p.source, pt.value' )
                ->from( 'DinLanguageDictionaryPair p' )
                ->leftJoin( 'p.Translation pt WITH pt.lang = ?', $culture )
                ->leftJoin( 'p.Dictionary d' )
                ->where( 'd.name = ?', $dictionary )
                ->andWhere( 'd.application = ?', $application )
                ->andWhere( 'pt.is_public = ?', 1 );

        $pairs = $query->execute( array(), Doctrine::HYDRATE_NONE );

        $out = array();
        foreach ( $pairs as $pair )
        {

            if ( mb_strpos( $pair[2], '{%url:', 0, 'utf-8' ) !== false )
            {
                preg_match_all( '|{%url:(.*)%}|uUims', $pair[2], $matches );
                foreach ( $matches[1] as $i => $uri )
                {
                    $pair[2] = str_replace( $matches[0][$i], Url::url( $uri ), $pair[2] );
                }
            }

            $out[$pair[1]] = array(
                0 => $pair[2],
                1 => $pair[0],
                2 => null
            );
        }

        return $out;

    } // PluginDinLanguageDictionaryTable::getDictionaryPairsForI18n()


    /**
     * Get dictionaries
     * 
     * @return  array   Array of dictionary pairs arrays
     */
    public function getDictionariesForI18n()
    {

        $application = sfContext::getInstance()->getConfiguration()->getApplication();

        return Doctrine_Query::create()->select( 'p.id, pt.name' )
                ->from( 'DinLanguageDictionary p' )
                ->where( 'p.application = ?', $application )
                ->execute( array(), Doctrine::HYDRATE_NONE );

    } // PluginDinLanguageDictionaryTable::getDictionariesForI18n()


    /**
     * Retrieve dictionary by name
     * 
     * @param   string  $name   Dictionary name
     * @return  DinLanguageDictionary
     */
    public function retrieveByName( $name )
    {

        $application = sfContext::getInstance()->getConfiguration()->getApplication();
        return $this->createQuery( 'd' )->where( 'd.name = ?', $name )
            ->andWhere( 'd.application = ?', $application )->fetchOne();

    } // PluginDinLanguageDictionaryTable::retrieveByName()


    /**
     * Get query for choices
     * 
     * @param   array   $params Query parameters [optional]
     * @return  Doctrine_Query
     */
    public function getChoicesQuery( $params = array() )
    {

        $q = $this->createQuery();
        $alias = $q->getRootAlias();
        $q->addSelect( $alias . '.id' );
        if ( $this->isI18n() )
        {
            $transAlias = $this->getI18nAlias( $alias );
            $q->leftJoin(
                $transAlias . ' WITH ' . $transAlias . '.lang = ?',
                sfContext::getInstance()->getUser()->getCulture()
            );
            $q->addSelect( $transAlias . '.title as title' );
        }
        return $q;

    } // PluginDinLanguageDictionaryTable::getChoicesQuery()



    /**
     * Remove cache (with cached i18n app dicts)
     * 
     * @param   array   $params Object params
     * @return  void
     */
    public function removeCache( array $params )
    {

        if ( $params['application'] && $params['name'] )
        {
            $driver = new sfFileCache( array(
                'lifetime' => 157680000,
                'cache_dir' => sfConfig::get( 'sf_cache_dir' ) . '/' . $params['application']
                    . '/*/i18n/' . $params['name']
            ) );
            $driver->removePattern( '*' );
        }

    } // PluginDinLanguageDictionary::removeCache()

} // PluginDinLanguageDictionaryTable

//EOF